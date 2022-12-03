<?php
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);
if(isset($_POST["submit"]))
{
    $vid = $_POST["vid"];

    include "../classes/dbh.classes.php";
    include "../classes/verify.classes.php";

    $verify = new Verify();
    $verify->verify($vid);
    
    //Back to home
    header("location: ../index.php?error=none");
    exit();
}
header("location: ../index.php?error=nopost");
exit();