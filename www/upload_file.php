
<!-- 
Author: Ethan Steidl
Description: Allows the uploading of a file to the server.
Accepts files in $_files with the key 'upload_files'. There
must also be a post variable set 'part_slection' set to part
or configuration.

The file uploaded will be saved into the correct part or
configuration folder with the exact filename given, overwriting
any files that exist with that name.
-->

<?php
     //enable error reporting
     error_reporting(E_ALL);
     
     $target_dir = "";   //target directory
     $target_file = "";  //target file

     //sets the target file to the correct spot depending on part or config
     if($_POST['type_selection'] === 'part')
     {
          $target_dir = "stickman_images/" .$_POST['part_selection'] . "/";
          $target_file = $target_dir . $_FILES['upload_files']['name'];
     }
     else
     {
          $target_dir = "stickman_configurations/";
          $target_file = $target_dir . $_FILES['upload_files']['name'];
     }
     

     //ensure file is safe to upload
     $uploadOk = 1;
     $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
     // Check if image file is a actual image or fake image
     //code based on https://stackoverflow.com/questions/27844258/upload-a-file-to-a-website-using-php
     if(isset($_POST["submit"])) {
          $check = getimagesize($_FILES['upload_files']['tmp_name']);
          if($check !== false) 
          {
               echo "File is an image - " . $check["mime"] . ".";
               $uploadOk = 1;
          } 
          else {
               echo "File is not an image.";
               $uploadOk = 0;
          }
     }
     
     //attempt to save file if file is good to upload
     if($uploadOk === 1)
     {
          if(move_uploaded_file($_FILES["upload_files"]["tmp_name"], $target_file))
          {
               echo 'Saved part as \'' . $_POST['upload_files']['name'] . '\'';
          }

     }

     //redirect back to files.php
     header("Location: files.php"); 

?>

