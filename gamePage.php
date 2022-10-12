<html lang="en">
<?php
    //set the title and require the header
    $page_title = 'My Games';
    require_once('header.php');
    require_once('connectvars.php');
    require_once('startsession.php');
    
    //require the nav menu
    require_once('navmenu.php');
?>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>My Games</h1>
            </div>
<?php
    //make sure the user is logged in
    if (!isset($_SESSION['userId'])) {
        echo '<p>You must be logged in to access this page.</p>';
        exit();
    }
    
    //connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    if (isset($_POST['delete'])) {
        //delete the certain row
        $deleteQuery = "delete from game where gameId=" . $_POST['gameId'] . " limit 1";
        mysqli_query($dbc, $deleteQuery)
                or die ('Error querying database.');
        
        //close the database
        mysqli_close($dbc);
        
        //confirm success
        echo '<p>The game was deleted successfully!</p>';
        echo '<br />';
        echo '<a href="gamePage.php"> Back to My Games</a>';
    } else {
        //select statment to get the user's games
        $userQuery = "select * from game where userId='" . $_SESSION['userId'] . "'order by gameId";
        
        //run query
        $result = mysqli_query($dbc, $userQuery)
                or die('Error querying database.');
        
        //start the table
        echo '<div>';
        echo '<table class="table borderless">';
        
        //fetch the user's games
        foreach($result as $games) {
            echo '<tr class="font"><td>' . $games['title'] . '</td>';
            //start of delete button
            echo '<form method="post" action="">';
            echo '<td valign=bottom><input type="submit" value="delete" name="delete" class="button" /></td>';
            echo '<input type="hidden" name="gameId" value="' . $games['gameId'] . '" />';
            echo '</form></tr>';
            //end of delete button
            echo '<tr><td class="font2">' . $games['star'] . '/5 stars</td></tr>';
            echo '<tr><td class="font2">' . $games['review'] . '</td></tr>';
            echo '<tr><td class="font2">' . $games['replay'] . '</td></tr>';
            echo '<tr><td class="font2">' . $games['comments'] . '</td></tr>';
        }
        //end the table
        echo '</table>';
        echo '</div>';
        
        //close database
        mysqli_close($dbc);
    }
?>
        </div>
<?php
    require_once('footer.php');
?>
    </body>
</html>