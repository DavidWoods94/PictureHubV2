<?php


function SavePostToDB($_db, $_user, $_title, $_text, $_time, $_file_name, $_post_date, $_filter)
{
   
	/* Prepared statement, stage 1: prepare query */
	if (!($stmt = $_db->prepare("INSERT INTO POSTCARDS(USER_USERNAME, STATUS_TITLE, STATUS_TEXT, TIME_STAMP, IMAGE_NAME, POST_DATE, FILTER) VALUES (?, ?, ?, ?, ?, ?, ?)")))
	{
		echo "Prepare failed: (" . $_db->errno . ") " . $_db->error;
	}

	/* Prepared statement, stage 2: bind parameters*/
	if (!$stmt->bind_param('sssssss', $_user, $_title, $_text, $_time, $_file_name, $_post_date, $_filter))
	{
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	/* Prepared statement, stage 3: execute*/
	if (!$stmt->execute())
	{
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
}

function getPostcards($_db)
{
    $query = "SELECT USER_USERNAME, STATUS_TITLE, STATUS_TEXT, TIME_STAMP, IMAGE_NAME, POST_DATE, FILTER FROM POSTCARDS ORDER BY TIME_STAMP DESC";
    
    
    
    if(!$result = $_db->query($query))
    {
        die('There was an error running the query [' . $_db->error . ']');
    }
    
    $output = '';
    while($row = $result->fetch_assoc())
    {
        $output = $output . '<div class="panel panel-default"><div class="panel-heading">"' . $row['STATUS_TITLE']
        . '" posted by ' . $row['USER_USERNAME'] 
        . ' on ' . $row['POST_DATE'] . '</div><div class="body"><img class = "images" value  = "'. $row['FILTER'] . '"id = "' . $row['TIME_STAMP'] . '" src="' . $server_root . 'users/' . $row['IMAGE_NAME'] . '" width="300px">'  . '</div>' . '<p>Poster comment: ' . $row['STATUS_TEXT'] . '</p></div>';
        $id = $row['TIME_STAMP'];
         if($row['FILTER'] == '1')
        {
            
            $output = "{$output} <style>   [id = '{$row['TIME_STAMP']}'] {
  -webkit-filter:  saturate(40%) grayscale(100%) contrast(45%) sepia(100%);
  filter:  saturate(40%) grayscale(100%) contrast(45%) sepia(100%);
} </style>";
        }
        else if($row['FILTER'] == '2')
        {
            $output = "{$output} <style>   [id = '{$row['TIME_STAMP']}'] {
  -webkit-filter: grayscale(1);
  filter: grayscale(1);
} </style>";
        }
        else if($row['FILTER'] == '3')
        {
            $output = "{$output} <style>   [id = '{$row['TIME_STAMP']}'] {
  -webkit-filter: sepia(1);
  filter: sepia(1);
} </style>";
        }
        else if($row['FILTER'] == '4')
        {
            $output = "{$output} <style>   [id = '{$row['TIME_STAMP']}'] {
  -webkit-filter: hue-rotate(180deg);
  filter: hue-rotate(180deg);
} </style>";
        }
        else if($row['FILTER'] == '5')
        {
            $output = "{$output} <style>   [id = '{$row['TIME_STAMP']}'] {
  -webkit-filter: invert(1);
  filter: invert(1);
} </style>";
        }
        else if($row['FILTER'] == '6')
        {
            $output = "{$output} <style>   [id = '{$row['TIME_STAMP']}'] {
  -webkit-filter: blur(2.5px);
  filter: blur(2.5px);
} </style>";
        }
    }
    return $output;
}
?>