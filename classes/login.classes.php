<?php

class Login extends Dbh {

    protected function getUser($uid, $pwd) {
        $stmt = $this->connect()->prepare('SELECT users_pwd FROM users  WHERE users_uid = ?;');

        if(!$stmt->execute(array($uid))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../index.php?error=userdoesnotexist");
            exit();
        }

        $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pwdCheck = password_verify($pwd, $pwdHashed[0]["users_pwd"]);

        if($pwdCheck == false) {
            $stmt = null;
            header("location: ../index.php?error=badpass");
            exit();
        }
        elseif($pwdCheck == true) {
            $stmt = $this->connect()->prepare('SELECT * FROM users WHERE users_uid = ? AND users_pwd = ?;');
            
            if(!$stmt->execute(array($uid, $pwdHashed[0]["users_pwd"]))) {
                $stmt = null;
                header("location: ../index.php?error=stmtfailed");
                exit();
            }

            if($stmt->rowCount() == 0) {
                $stmt = null;
                header("location: ../index.php?error=userfetchfailed");
                exit();
            }
            else {
                $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

                session_start();
                $_SESSION["userid"] = $user[0]["users_id"];
                $_SESSION["useruid"] = $user[0]["users_uid"];
                
                $stmt = null;
                
                // TWO STEP VERIFICATION

                //New 2 factor entry
                $verify = rand();
                $randomNumber = rand(100000,999999);
                $stmt = $this->connect()->prepare("INSERT INTO twostep (client_session, users_uid, verify) VALUES (?, ?, ?)");
                if(!$stmt->execute(array(session_id(), $_SESSION["useruid"], $randomNumber))) {
                    $stmt = null;
                    header("location: ../index.php?error=stmtfailed");
                    exit();
                }

                $to = $_SESSION["useruid"];
                $subject = '2 Step Verification';
                $content = 'Your verification code: '. $randomNumber;
                $headers = "From: cptsproject@gmail.com\r\n";
                mail($to, $subject, $content, $headers);

                //Remove duplicates
                $stmt = $this->connect()->prepare("DELETE t1 FROM twostep t1 INNER JOIN twostep t2 WHERE t1.cre_time < t2.cre_time AND t1.client_session = t2.client_session");
                if(!$stmt->execute()) {
                    $stmt = null;
                    header("location: ../index.php?error=stmtfailed");
                    exit();
                }

            }
        }

        $stmt = null;
    }

}