<?php
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);
if(isset($_POST["submit"]))
{
    
    //Collect data
    $uid = $_POST["uid"];
    $pwd = $_POST["pwd"];

    //Create Signup class
    include "../classes/dbh.classes.php";
    include "../classes/login.classes.php";
    include "../classes/login-contr.classes.php";
    $login = new LoginContr($uid, $pwd);

    //Running error handlers
    $login->loginUser();
    //Two Step
    
    //Back to home
    header("location: ../index.php?error=none");
    exit();
}
header("location: ../index.php?error=nopost");
exit();