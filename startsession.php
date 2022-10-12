<?php
    session_start();
    
    //If the session vars aren't set, try to set them with a cookie
    if(!isset($_SESSION['userId'])) {
        if(isset($_COOKIE['userId']) && isset($_COOKIE['username'])) {
            $_SESSION['userId'] = $_COOKIE['userId'];
            $_SESSION['username'] = $_COOKIE['username'];
        }
    }
?>