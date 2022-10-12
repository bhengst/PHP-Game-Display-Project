<!-- Bootstrap for navmenu -->
<nav class="navbar navbar-inverse" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="brand brand-name navbar-left" href="index01.php">
                <img src="images/logo.png" alt="Games" />
            </a>
        </div>
        
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
<?php
    //navigation menu
    if (isset($_SESSION['userId'])) {
        echo '<li><a href="index01.php"> Home </a></li>';
        echo '<li><a href="addGame.php"> Add A Game </a></li>';
        echo '<li><a href="gamePage.php"> My Games</a></li>';
        echo '</ul>';
        echo '<ul class="nav navbar-nav navbar-right">';
        echo '<li><a href="signout.php"> Sign Out (' . $_SESSION['username'] . ')</a></li>';
    } else {
        echo '<li><a href="index01.php"> Home </a></li>';
        echo '</ul>';
        echo '<ul class="nav navbar-nav navbar-right">';
        echo '<li><a href="register.php"> Register </a></li>';
        echo '<li><a href="login.php"> Log In </a></li>';
    }
?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>