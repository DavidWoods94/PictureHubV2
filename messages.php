<?php // Example 26-11: messages.php
  require_once 'header.php';
    //crescent fresh code
require_once "php/db_connect.php";
require_once "php/functions.php";



//end of crescent freshness


  if (!$loggedin) die();





  if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
  else                      $view = $user;




if (isset($_FILES['image']))
  {
   
    $time = $_SERVER['REQUEST_TIME'];
     $saveto = "$time.jpg";
	   $file_name = $time . '.jpg';
        $tmp_name = $_FILES['image']['name'];
    $dstFolder = 'users';
    move_uploaded_file($_FILES['image']['tmp_name'], $dstFolder . '/' . $saveto);
       //move_uploaded_file($_FILES['upload']['tmp_name'], $dstFolder . DIRECTORY_SEPARATOR . $file_name);
    $typeok = TRUE;

    switch($_FILES['image']['type'])
    {
      case "image/gif":   $src = imagecreatefromgif($saveto); break;
      case "image/jpeg":  // Both regular and progressive jpegs
      case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
      case "image/png":   $src = imagecreatefrompng($saveto); break;
      default:            $typeok = FALSE; break;
    }

    if ($typeok)
    {
      list($w, $h) = getimagesize($saveto);

      $max = 100;
      $tw  = $w;
      $th  = $h;

      if ($w > $h && $max < $w)
      {
        $th = $max / $w * $h;
        $tw = $max;
      }
      elseif ($h > $w && $max < $h)
      {
        $tw = $max / $h * $w;
        $th = $max;
      }
      elseif ($max < $w)
      {
        $tw = $th = $max;
      }

      $tmp = imagecreatetruecolor($tw, $th);
      imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
      imageconvolution($tmp, array(array(-1, -1, -1),
        array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
      imagejpeg($tmp, $saveto);
      imagedestroy($tmp);
      imagedestroy($src);
    }
  }











  if (isset($_POST['text']))
  {
     
    $text = sanitizeString($_POST['text']);
      
    $filter = sanitizeString($_POST['filter']);
      
    if ($text != "")
    {
      $pm   = substr(sanitizeString($_POST['pm']),0,1);
      $time = time();
      queryMysql("INSERT INTO messages VALUES(NULL, '$user',
        '$view', '$pm', $time, '$text', '$file_name', '$filter')");
    }
  }

  if ($view != "")
  {
    if ($view == $user) $name1 = $name2 = "Your";
    else
    {
      $name1 = "<a href='members.php?view=$view'>$view</a>'s";
      $name2 = "$view's";
    }

    echo "<div class='main'><h3>$name1 Messages</h3>";
    showProfile($view);
    
      echo "<script src='javascript.js'></script>";
      
      //<button href='#' id='showF'>Upload Picture</button>
      
    echo "
    <h3 onclick = 'gone()'>Post a Picture</h3>
                    
    <button href='#' onclick = 'hidey()' class = 'btn btn-default btn-lg' id='showF'>Upload Picture</button>
    
    <form method='post' action='messages.php?view=$view' enctype='multipart/form-data'>
    <div class='container'>    
		<div class='row'>
			
				
                    
                    <div id='secret' style = 'display:none;'>
                    
                    <div class='form-group'>
                        
                        <!--<img id='image' name='image' src='' width='100%'>-->
                        
                        <input id = 'choose' type='file' name='image' value = '' size='14'>
                    </div>
                    
                    
                    <div class='form-group'>
                        <h3>Filter Photo</h3>
                        <div class='checkbox-inline'>
                            <label for='myNostalgia'>My Nostalgia</label>
                            <input type='radio' name='filter' id='1' value='1' onclick='applyMyNostalgiaFilter();'>
                        </div>
                        <div class='checkbox-inline'>
                            <label for='grayscale'>Grayscale</label>
                            <input type='radio' name='filter' id='2' value='2' onclick='applyGrayscaleFilter();'>
                        </div>
                        <div class='checkbox-inline'>
                            <label for='grayscale'>Sepia</label>
                            <input type='radio' name='filter' id='3' value='3' onclick='applySepiaFilter();'>
                        </div>
                        
                        <div class='checkbox-inline'>
                            <label for='grayscale'>Sad Puppy</label>
                            <input type='radio' name='filter' id='4' value='4' onclick='applyHueFilter();'>
                        </div>
                        
                        <div class='checkbox-inline'>
                            <label for='grayscale'>Invert</label>
                            <input type='radio' name='filter' id='5' value='5' onclick='applyInvertFilter();'>
                        </div>
                        
                        <div class='checkbox-inline'>
                            <label for='grayscale'>Blur</label>
                            <input type='radio' name='filter' id='6' value='6' onclick='applyBlurFilter();'>
                        </div>
                        
                        <div class='checkbox-inline'>
                            <label for='original'>Revert to Original</label>
                            <input type='radio' name='filter' id='lomo' value='lomo' onclick='revertToOriginal();'>
                        </div>
                        </div>
                    </div>
		</div>
	</div>
    
      
      Type here to leave a message:<br>
      <textarea name='text' class = 'status' cols='40' rows='3'></textarea><br>
      Public<input type='radio' name='pm' value='0' checked='checked'>
      Private<input type='radio' name='pm' value='1'>
      <input type='submit' value='Post Message'></form>
      <br>";
      

    if (isset($_GET['erase']))
    {
      $erase = sanitizeString($_GET['erase']);
      queryMysql("DELETE FROM messages WHERE id=$erase AND recip='$user'");
    }
    
    $query  = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
    $result = queryMysql($query);
    $num    = $result->num_rows;
    
    for ($j = 0 ; $j < $num ; ++$j)
    {
      $row = $result->fetch_array(MYSQLI_ASSOC);

      if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user)
      {
        echo date('M jS \'y g:ia:', $row['time']);
        echo " <a href='messages.php?view=" . $row['auth'] . "'>" . $row['auth']. "</a> ";

        if ($row['pm'] == 0)
        {
          echo "<div class = 'post'>posted:<img class = 'images'". "onerror='imgError(this);'"  ."value  = '" . $row['FILTER'] . "'id = '" . $row['time'] . "' src='" . $server_root . "/users/" . $row['IMAGE_NAME'] . "' width='300px'/>" ." &quot;" . $row['message'] . "&quot; </div> ";
           if($row['FILTER'] == '1')
        {
            
            echo " <style>   [id = '{$row['time']}'] {
  -webkit-filter:  saturate(40%) grayscale(100%) contrast(45%) sepia(100%);
  filter:  saturate(40%) grayscale(100%) contrast(45%) sepia(100%);
} </style>";
        }
        else if($row['FILTER'] == '2')
        {
            echo "<style>   [id = '{$row['time']}'] {
  -webkit-filter: grayscale(1);
  filter: grayscale(1);
} </style>";
        }
        else if($row['FILTER'] == '3')
        {
            echo " <style>   [id = '{$row['time']}'] {
  -webkit-filter: sepia(1);
  filter: sepia(1);
} </style>";
        }
        else if($row['FILTER'] == '4')
        {
            echo " <style>   [id = '{$row['time']}'] {
  -webkit-filter: hue-rotate(180deg);
  filter: hue-rotate(180deg);
} </style>";
        }
        else if($row['FILTER'] == '5')
        {
            echo " <style>   [id = '{$row['time']}'] {
  -webkit-filter: invert(1);
  filter: invert(1);
} </style>";
        }
        else if($row['FILTER'] == '6')
        {
            echo " <style>   [id = '{$row['time']}'] {
  -webkit-filter: blur(2.5px);
  filter: blur(2.5px);
} </style>";
        }
                   
        }
          
        else
        {
          echo "<div class = 'post'>whispered:". "<img class = 'images'". "onerror='imgError(this);'"  ."value  = '" . $row['FILTER'] . "'id = '" . $row['time'] . "' src='" . $server_root . "/users/" . $row['IMAGE_NAME'] . "' width='300px'/>" . "  "." <span class='whisper'>&quot;" .
            $row['message']. "&quot;</span></div> ";
           if($row['FILTER'] == '1')
        {
            
            echo " <style>   [id = '{$row['time']}'] {
  -webkit-filter:  saturate(40%) grayscale(100%) contrast(45%) sepia(100%);
  filter:  saturate(40%) grayscale(100%) contrast(45%) sepia(100%);
} </style>";
        }
        else if($row['FILTER'] == '2')
        {
            echo "<style>   [id = '{$row['time']}'] {
  -webkit-filter: grayscale(1);
  filter: grayscale(1);
} </style>";
        }
        else if($row['FILTER'] == '3')
        {
            echo " <style>   [id = '{$row['time']}'] {
  -webkit-filter: sepia(1);
  filter: sepia(1);
} </style>";
        }
        else if($row['FILTER'] == '4')
        {
            echo " <style>   [id = '{$row['time']}'] {
  -webkit-filter: hue-rotate(180deg);
  filter: hue-rotate(180deg);
} </style>";
        }
        else if($row['FILTER'] == '5')
        {
            echo " <style>   [id = '{$row['time']}'] {
  -webkit-filter: invert(1);
  filter: invert(1);
} </style>";
        }
        else if($row['FILTER'] == '6')
        {
            echo " <style>   [id = '{$row['time']}'] {
  -webkit-filter: blur(2.5px);
  filter: blur(2.5px);
} </style>";
        }

        }
        if ($row['recip'] == $user)
          echo "[<a href='messages.php?view=$view" .
               "&erase=" . $row['id'] . "'>erase</a>]";

        echo "<br>";
      }
    }
  }

  if (!$num) echo "<br><span class='info'>No messages yet</span><br><br>";

  echo "<br><a class='button' href='messages.php?view=$view'>Refresh messages</a>";
?>

    </div><br>
  </body>
</html>
