<?php // Example 26-2: header.php
  session_start();

  echo "<!DOCTYPE html><html><head><meta charset='utf-8'>" .
    "<meta http-equiv='X-UA-Compatible' content='IE=edge'>".
    "<meta name='viewport' content='width=device-width, initial-scale=1'>" .
    "<meta name='description' content=''>" .
    "<meta name='author' content=''>" .

    "<title>Picture Hub v.2</title>".

    //<!-- Bootstrap Core CSS -->
    "<link href='css/bootstrap.min.css' rel='stylesheet'>".

    //<!-- Custom CSS -->
    "<link href='css/grayscale.css' rel='stylesheet'>".

    //<!-- Custom Fonts -->
    "<link href='font-awesome/css/font-awesome.min.css' rel='stylesheet' type='text/css'>".
    "<link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>" .
    "<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>";

  require_once 'functions.php';

  $userstr = ' (Guest)';

  if (isset($_SESSION['user']))
  {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = " ($user)";
  }
  else $loggedin = FALSE;

  echo "<div class='col-lg-8 col-lg-offset-2'><title>$appname$userstr</title><link rel='stylesheet' " .
       "href='style.css' type='text/css'>"                     .
       "</div></head><body onload='initialize();'><center><canvas id='logo' width='624' "    .
       "height='96'>$appname</canvas></center>"             .
       "<div class='appname'>$appname$userstr</div>"            .
       "<script src='javascript.js'></script>" .
      " <script src='js/jquery.js'></script>" .

    
    "<script src='js/bootstrap.min.js'></script>" .

      
    "<script src='js/jquery.easing.min.js'></script>" .

    "<script src='js/grayscale.js'></script>";

  if ($loggedin)
  {
      
    echo "<br ><div class='container'><ul class='menu'>" .
         "<li><a href='members.php?view=$user' class='btn btn-default btn-lg'>Home</a></li>" .
         "<li><a href='members.php' class='btn btn-default btn-lg'>Members</a></li>"         .
         "<li><a href='friends.php' class='btn btn-default btn-lg'>Friends</a></li>"         .
         "<li><a href='messages.php' class='btn btn-default btn-lg'>Messages</a></li>"       .
         "<li><a href='profile.php' class='btn btn-default btn-lg'>Edit Profile</a></li>"    .
         "<li><a href='logout.php' class='btn btn-default btn-lg'>Log out</a></li></ul></div><br>";
  }
  else
  {
    echo ("<br><ul class='menu'>" .
          "<li><a href='index.php' class='btn btn-default btn-lg'>Home</a></li>"                .
          "<li><a href='signup.php' class='btn btn-default btn-lg'>Sign up</a></li>"            .
          "<li><a href='login.php' class='btn btn-default btn-lg'>Log in</a></li></ul><br>"     .
          "<span class='info'>&#8658; You must be logged in to " .
          "view this page.</span><br><br>");
  }
?>
