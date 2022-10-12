<html>
<?php
    //set the title and require files
    $page_title = 'Add A Game';
    require_once('header.php');
    
    //connect to the database
    require_once('connectvars.php');
    
    //start the session
    require_once('startsession.php');
    
    require_once('navmenu.php');
?>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>Add A Game</h1>
            </div>
        <h3>Review</h3>
        <br />
<?php
    //connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    //make sure the user is logged in before going further
    if (!isset($_SESSION['userId'])) {
        echo '<p>Please <a href="login.php">log in</a> to access this page.</p>';
        exit();
    }
    
    if (isset($_POST['submit'])) {
        //grab the data from the form
        $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
        $star = mysqli_real_escape_string($dbc, trim($_POST['star']));
        $review = mysqli_real_escape_string($dbc, trim($_POST['review']));
        $replay = mysqli_real_escape_string($dbc, trim($_POST['replay']));
        $public = mysqli_real_escape_string($dbc, trim($_POST['public']));
        $comment = mysqli_real_escape_string($dbc, trim($_POST['comment']));
        
        //validate the user entered something for each required field
        if (!empty($title) && !empty($star) && !empty($review) && !empty($replay) && !empty($public) && empty($comment)) {
            //insert into database
            $insertQuery = "insert into game (title, star, review, replay, public, userId) " .
                    "values('$title', '$star', '$review', '$replay', '$public', '" . $_SESSION['userId'] . "');";
            
            //query
            $result = mysqli_query($dbc, $insertQuery)
                    or die('Error querying database');
                    
        echo '<p>Your game has been posted successfully!</p><br />';

        } else if (!empty($title) && !empty($star) && !empty($review) && !empty($replay) && !empty($public) && !empty($comment)) {
            //insert into database
            $insertQuery = "insert into game (title, star, review, replay, public, comments, userId) " .
                    "values('$title', '$star', '$review', '$replay', '$public', '$comment', '" . $_SESSION['userId'] . "');";
        
            //query
            $result = mysqli_query($dbc, $insertQuery)
                    or die('Error querying database');
                    
        echo '<p>Your game has been posted successfully!</p><br />';
        
        } else {
            echo '<p>You must fill in </p>';
        }
        
        mysqli_close($dbc);
    }
?>
        <form method="post" action"<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <fieldset>
                    <input type="text" class="form-control" name="title" placeholder="Title..." />
                    <br />
                    <label for="star" class="big">Rating: </label>
                    <label class="big">
                        <input type="radio" name="star" value="0">0
                    </label>
                    <label class="big">
                        <input type="radio" name="star" value="1">1
                    </label>
                    <label class="big">
                        <input type="radio" name="star" value="2">2
                    </label>
                    <label class="big">
                        <input type="radio" name="star" value="3">3
                    </label>
                    <label class="big">
                        <input type="radio" name="star" value="4">4
                    </label>
                    <label class="big">
                        <input type="radio" name="star" value="5">5
                    </label>
                    <br />
                    <textarea name="review" class="form-control" placeholder="Enter review here..."></textarea>
                    <br />
                    <label for="replay" class="big">Enter replay value: <br /> Low &#8594; High</label>
                    <br />
                    <input type="text" class="form-control" name="replay" />
                    <br />
                    <label for="public" class="big">Would you like this to be public or private?</label>
                    <br />
                    <label class="big">
                        <input type="radio" name="public" value="public" >Public
                    </label>
                    <label class="big">
                        <input type="radio" name="public" value="private">Private
                    </label>
                    <br />
                    <textarea name="comment" class="form-control" placeholder="Enter any other comments here..."></textarea>
                </fieldset>
                <br />
                <div class="button-center">
                    <input type="submit" name="submit" value="Submit My Game!" />
                </div>
            </div>
        </form>
        </div>
<?php
    require_once('footer.php');
?>
    </body>
</html>