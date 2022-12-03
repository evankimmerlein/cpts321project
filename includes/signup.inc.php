<?php
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);
if(isset($_POST["submit"]))
{
    
    //Collect data
    $uid = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdr = $_POST["pwdr"];

    //Create Signup class
    include "../classes/dbh.classes.php";
    include "../classes/signup.classes.php";
    include "../classes/signup-contr.classes.php";
    $signup = new SignupContr($uid, $pwd, $pwdr);
    //$signup = new SignupContr("1", "2", "3");

    //Running error handlers
    $signup->signupUser();
    //Two Step
    
    //Back to home
    header("location: ../index.php?error=none");
    exit();
}
header("location: ../index.php?error=nopost");
exit();