<?php
require_once "php/db_connect.php";
require_once "php/functions.php";

if(isset($_POST['name']) && isset($_POST['title']) && isset($_POST['text']))
{    
    $name = sanitizeString($db, $_POST['name']);
    $title = sanitizeString($db, $_POST['title']);
    $text = sanitizeString($db, $_POST['text']);
    $filter = sanitizeString($db, $_POST['filter']);
    
    $time = $_SERVER['REQUEST_TIME'];
	$file_name = $time . '.jpg';
    $day = getdate();
    $date = "{$day[mon]}/{$day[mday]}/{$day[year]} at {$day[hours]}:{$day[minutes]}:{$day[seconds]}";
    

    if ($_FILES)
    {
        $tmp_name = $_FILES['upload']['name'];
        $dstFolder = 'users';
        move_uploaded_file($_FILES['upload']['tmp_name'], $dstFolder . DIRECTORY_SEPARATOR . $file_name);
       
    }

    SavePostToDB($db, $name, $title, $text, $time, $file_name, $date, $filter);
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<title>Picture Hub</title>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
    
    <link href="css/scrolling-nav.css" rel="stylesheet">
    
    <link rel="stylesheet" href="css/styles.css">
    
    <link rel="stylesheet" href="css/style.css">
	
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body onload="filters();">
    
    
    <div class = "title">
    <h3>Picture Hub</h3>
    </div>
    
    <div class="container">
        <?php echo getPostcards($db); ?>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	
	<!-- Latest compiled and minified JavaScript -->
	<script src="js/bootstrap.min.js"></script>
	
	<script src="functions.js"></script>
    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/filters.js"></script>
    
        <!-- Scrolling Nav JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/scrolling-nav.js"></script>

    
</body>



<?php $db->close(); ?>