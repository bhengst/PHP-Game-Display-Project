<html lang="en">
<?php
    //set the title and require the header
    $page_title = 'Homepage';
    require_once('header.php');
    require_once('connectvars.php');
    require_once('startsession.php');
    
    //require the nav menu
    require_once('navmenu.php');
?>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>Homepage</h1>
            </div>
            <h3>Video Game Reviews</h3>
<?php  
    //connect to database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    //select statement to get all game reviews
    $gameQuery = "select * from game order by title;";
    
    //query
    $gameResult = mysqli_query($dbc, $gameQuery)
            or die('Error querying database.');
    
    //start the table
    echo '<div>';
    echo '<table class="table borderless">';
    
    //loop through all games
    foreach($gameResult as $games) {
        if($games['public'] == 'pub') {
            echo '<tr class="font"><td>' . $games['title'] . '</td></tr>';
            echo '<tr><td class="font2">' . $games['star'] . '/5 stars</td></tr>';
            echo '<tr><td class="font2">' . $games['review'] . '</td></tr>';
            echo '<tr><td class="font2">' . $games['replay'] . '</td></tr>';
            echo '<tr><td class="font2">' . $games['comments'] . '<br /><br /></td></tr>';
        }
    }
    //end the table
    echo '</table>';
    echo '</div>';
    
    //close database
    mysqli_close($dbc);
?>
        </div>
<?php
    require_once('footer.php');
?>        
    </body>
</html>