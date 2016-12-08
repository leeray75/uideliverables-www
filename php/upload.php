<?php
	$file = $_FILES['file-0'];
	$ext = end(explode(".", $file["name"]));
	echo "Extension: " . $ext;
	$id = $_GET['id'];
	$filename = $id.".".$ext;
	$docroot = getenv('DOCUMENT_ROOT')."/www/php";
	$filepath = $docroot ."/upload/".$filename;
if ($file ["error"] > 0)
  {
  echo "Error: " . $file["error"] . "<br>";
  }
else
  {
  echo "Upload: " . $file["name"] . "<br> \n\r";
  echo "Type: " . $file["type"] . "<br> \n\r";
  echo "Size: " . ($file["size"] / 1024) . " kB<br> \n\r";
 // echo "Stored in: " . $filename;
    if (file_exists($docroot . $filename))
      {
      echo $filename . " already exists. ";
      }
    else
      {
      	if(move_uploaded_file($file['tmp_name'],$filepath))
		{
	      echo "Stored in: " . $filepath;
		}
		else
		{
			echo "Failed to store file: $filepath";	
		}
      }  
  }
?> 
