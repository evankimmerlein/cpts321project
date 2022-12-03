<?php
session_start();
class Verify extends Dbh {

    public function verify($vid)
    {
        $stmt = $this->connect()->prepare("SELECT verify FROM twostep WHERE client_session = ?");
        if(!$stmt->execute(array(session_id()))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../index.php?error=userdoesnotexist");
            exit();
        }

        $vidInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $vidReal = $vidInfo[0]["verify"];

        if($vidReal == $vid) {
            $_SESSION["ver"] = "true";
            $stmt = null;
            header("location: ../index.php?error=none");
            exit();
        }
        else {
            $stmt = null;
            header("location: ../index.php?error=invalidcode");
            exit();
        }
    }

}