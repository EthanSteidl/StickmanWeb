
<!-- 
Author: Ethan Steidl
Description: Allows the uploading of a file to the server from the index.php
page. post must have a filename and stickman object inside of it.

The file uploaded will be saved into the correct
configuration folder with the exact filename given, overwriting
any files that exist with that name.
-->

<?php
     //enable error reporting
     error_reporting(E_ALL);
     
     //set the save filename
     $newfilename = 'stickman_configurations/' . $_POST['filename'] . '.json';

     //if no name was given change the filename to temp.json
     if($newfilename === 'stickman_configurations/')
     {
          $newfilename = 'stickman_configurations/temp.json';
     }

     //create a json of only the  stickman
     $json = json_encode($_POST, JSON_PRETTY_PRINT);
     $decoded = json_decode($json);
     unset($decoded->filename);
     $json = json_encode($decoded, JSON_PRETTY_PRINT);

     //save the file
     if(file_put_contents($newfilename, $json) !== false)
     {
          echo 'Saved configuration as \'' . $_POST['filename'] . '\'';
     }

     //redirect back to index.php
     header("Location: index.php"); 
?>

