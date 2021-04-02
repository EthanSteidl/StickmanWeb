<!--
Author: Ethan Steidl
Description: Deletes the name of a file in the directory of this
php file with the filename in the $_POST['filename'] variable.
Then redirects the user to files.php
-->
<?php


     //enable error reporting
     error_reporting(E_ALL);

     //get the file to delete and add the path to the start
     $filename = $_POST['filename'];
     $mydirectory = getcwd();
     $file_to_delete = $mydirectory . "/" . $filename;

     //delete the file
     $deleted = unlink($file_to_delete);

     //redirect to files.php
     header("Location: files.php"); 
?>

