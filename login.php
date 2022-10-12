<html>
<?php
    //set the title and require the header
    $page_title = "Login";
    require_once('header.php');
    require_once('connectvars.php');
    require_once('startsession.php');
    
    //require the navigation menu
    require_once('navmenu.php');
?>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>Log In To Your Account</h1>
            </div>
<?php
    if (!isset($_SESSION['userId'])) {
        if (isset($_POST['submit'])) {
            //connect to the database
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            //grab the login data
            $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
            $user_password = trim($_POST['password']);
            
            if (!empty($user_username) && !empty($user_password)) {
                //look up the username and password in the database
                $query = "select * from user where username = '$user_username'";
                $result = mysqli_query($dbc, $query);

                if (mysqli_num_rows($result) == 1) {
                    //the login is good, set he userId and username session vars
                    $row = mysqli_fetch_assoc($result);
                    
                    if (password_verify($user_password, $row['password'])) {
                        $_SESSION['userId'] = $row['userId'];
                        $_SESSION['username'] = $row['username'];
                        
                        //set cookies
                        setcookie('userId', $row['username'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
                        setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
                        
                        //redirect to the homepage
                        $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index01.php';
                        header('Location: ' . $home_url);
                        
                    } else {
                        echo '<p>The username or password do no match.</p>';
                    }
                } else {
                    //the username/password are incorrect, show error message
                    echo '<p>You must enter a valid username and password to log in.</p>';
                    echo '<p>If you are\'t already a registered member, please register <a href="register.php">here</a>.</p>';
                }
            } else {
                echo '<p>You must enter a valid username and password to log in.</p>';
            }
        }
    }
    
    if (empty($_SESSION['userId'])) {
?>
        <p>Please enter your username and password to log in.</p>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <fieldset>
                    <label for="username" class="big">Username: </label>
                    <input type="text" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>" />
                    <br /><br />
                    <label for="password" class="big">Password: </label>
                    <input type="password" name="password" />
                </fieldset>
                <br />
                <div class="button-center">
                    <input type="submit" value="Go!" name="submit" />
                </div>
            </div>
        </form>
<?php
    } else {
        //show that the user is logged in
        echo '<p>You are logged in as ' . $_SESSION['username'] . '.</p>';
        echo '<p>Click <a href="index01.php">here</a> to go to the homepage.</p>';
    }
?>
        </div>
<?php
    require_once('footer.php');
?>
    </body>
</html>