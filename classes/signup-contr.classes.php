<?php
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);
class SignupContr extends Signup{

    private $uid;
    private $pwd;
    private $pwdr;

    public function __construct($uid, $pwd, $pwdr) {
        $this->uid = $uid;
        $this->pwd = $pwd;
        $this->pwdr = $pwdr;
    }

    public function signupUser() {
        if($this->emptyInput() == true) {
            header("location: ../index.php?error=emptyinput");
            exit();
        }
        if($this->invalidEmail() == true) {
            header("location: ../index.php?error=email");
            exit();
        }
        if($this->pwdCheck() == false) {
            header("location: ../index.php?error=passwordmatch" . $this->pwd . $this->pwdr);
            exit();
        }
        if($this->uidTakenCheck() == true) {
            header("location: ../index.php?error=emailtaken");
            exit();
        }

        $this->setUser($this->uid, $this->pwd);
    }

    private function emptyInput() {
        $result;
        if(empty($this->uid) || empty($this->pwd) || empty($this->pwdr)) {
            $result = true;
        }
        else {
            $result= false;
        }
        return $result;
    }

    private function invalidEmail() {
        $result;
        if(filter_var($this->uid, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        }
        else {
            $result = true;
        }
        return $result;
    }

    private function pwdCheck() {
        $result;
        if($this->pwd == $this->pwdr) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    private function uidTakenCheck() {
        $result;
        if($this->checkUser($this->uid)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }
}