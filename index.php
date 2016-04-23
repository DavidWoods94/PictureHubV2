<?php // Example 26-4: index.php
  require_once 'header.php';

  echo "<br><span class='main'><h2>Welcome to $appname,";

  if ($loggedin) echo " $user, you are logged in.</h2>";
  else           echo ' Please log in or sign up </h2>';
?>

    </span><br><br>
  </body>
</html>
