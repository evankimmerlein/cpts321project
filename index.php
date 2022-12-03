<?php
    session_start();
?>

<html>
<html>
<body>

<h1>CPTS 321 Project</h1>
<section class="index-login">
    <?php
        if(!isset($_SESSION["userid"])) {
    ?>
    <div class="wrapper">
        <div class="index-login-signup">
                <h4>Sign Up</h4>
                <p>No account? Sign up.</p>
                <form method="post" action="includes/signup.inc.php">
                    <input type="text" class="form-control" name="uid" placeholder="Email">
                    <br>
                    <input type="password" class="form-control" name="pwd" placeholder="Password">
                    <br>
                    <input type="password" class="form-control" name="pwdr" placeholder="Repeat Password">
                    <br>
                    <input type="submit" class="form-control" name="submit">
                </form>
            </div>
            <div class="index-login-login">
                <h4>Login</h4>
                <p>Have account? Log in.</p>
                <form method="post" action="includes/login.inc.php">
                    <input type="text" class="form-control" name="uid" placeholder="Email">
                    <br>
                    <input type="password" class="form-control" name="pwd" placeholder="Password">
                    <br>
                    <input type="submit" class="form-control" name="submit">
                </form>
            </div>
        </div>
    </div>
    <?php
        }
        elseif (isset($_SESSION["ver"])) {
    ?>
    <h3> Welcome <?php echo $_SESSION["useruid"]; ?> </h3>
    <h4> You are officially logged in! </h4>
    <br>
    <form method="post" action="includes/logout.inc.php">
        <input type="submit" class="form-control" name="logout" value="Logout">
    </form>
    <?php
        }
        else {
    ?>
    <p>Please enter the code you received</p>
    <form method="post" action="includes/verify.inc.php">
                    <input type="number" class="form-control" name="vid" placeholder="Code">
                    <br>
                    <input type="submit" class="form-control" name="submit">
                </form>
    <form method="post" action="includes/logout.inc.php">
        <input type="submit" class="form-control" name="logout" value="Cancel">
    </form>
    <?php
        }
        if(isset($_GET["error"])) {
            switch($_GET["error"]) {
                case "emptyinput":
                    echo "Please fill out all feilds.";
                    break;
                case "email":
                    echo "The email you entered is invalid.";
                    break;
                case "passwordmatch":
                    echo "Your password does not match.";
                    break;
                case "emailtaken":
                    echo "This email is already in use.";
                    break;
                case "badpass":
                    echo "Invalid password.";
                    break;
                case "invalidcode":
                    echo "Your code is invalid or expired.";
                    break;

            }
        }
    ?>
</section>
</body>
</html>
</html>