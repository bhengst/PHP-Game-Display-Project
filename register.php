<html>
<?php
    //set the title and require the header
    $page_title = 'Register';
    require_once('header.php');
    require_once('connectvars.php');
    require_once('startsession.php');
    
    //require the navigation menu
    require_once('navmenu.php');
?>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>Register Your Account</h1>
            </div>
<?php
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    if (isset($_POST['submit'])) {
        //grab the profile date from the POST
        $username = mysqli_real_escape_string($dbc, trim($_POST ['username']));
        $password1 = trim($_POST['password1']);
        $password2 = trim($_POST['password2']);

        //password hash
        $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
                
        if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
            //make sure someone isn't already registered with the same username
            $query = "select * from user where username = '$username'";
            $data = mysqli_query($dbc, $query);
            
            if(mysqli_num_rows($data) == 0) {
                //the user name is unique, insert data into database
                $insertQuery = "insert into user (password, username) values ('$hashed_password', '$username')";
                $insertData = mysqli_query($dbc, $insertQuery);
                
                //confirm success with user
                echo '<p>You have been successfully registered. You\'re now ready to <a href="login.php">login</a>.</p>';
                
                mysqli_close($dbc);
                exit();
            } else {
                echo '<p>An account already exists for this username. Please use a different username.</p>';
                echo '<p>Already have an account? <a href="login.php">Click here</a> to log in.</p>';
                $username = "";
            }
        } else {
            echo '<p>You must fill in all of the sign-up data, including your desired password twice.</p>';
        }
    }
    mysqli_close($dbc);
?>
        <p>Please enter a username and password to register.</p>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <fieldset>
                    <label for="username" class="big">Username: </label>
                    <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" />
                    <br /><br />
                    <label for="password1" class="big">Password: </label>
                    <input type="password" id="password1" name="password1" />
                    <br /><br />
                    <label for="password2" class="big">Renter Password: </label>
                    <input type="password" id="password2" name="password2" />
                </fieldset>
                <br />
                <div class="button-center">
                    <input type="submit" value="Go!" name="submit" />
                </div>
            </div>
        </form>
        </div>
<?php
    require_once('footer.php');
?>
    </body>
</html>