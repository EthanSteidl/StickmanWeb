<!-- 
Author: Ethan Steidl
Description: This file contains code to let users download/upload/load/delete
clothing articles for the stickman. Users can also downlaod/upload/load/
delete configurations for the stickman.
-->
<html>
     <head>
          <!-- Set the style sheets and javascript -->
          <title>Files Page</title>
          <link href="StyleSheet.css" rel="stylesheet" type="text/css">
          <link href="StyleSheetFiles.css" rel="stylesheet" type="text/css">
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <script id="js_type" type="text/javascript" src="funcs.js"></script>
          <script id="js_type" type="text/javascript" src="files.js"></script>
          <!--this sets the icon of the webpage in the tabs to NULL-->
          <link rel="shortcut icon" href="#">
     </head>
     <body>

          <!-- Title of page -->
          <div class="header">
               <h1>The Stickman</h1>
               <p>A project by Ethan Steidl</p>
          </div>
          <!-- Nav Bar -->
          <div class="top_navigation">
                    <a href="index.php">Home</a>
                    <a class="active" href="files.php">Files</a>
                    <a href="help.html">Help</a>
          </div>
          <!-- Stickman, this needs to be invisible for the Javascript to alter values -->
          <div class="hidden_box"> 
                    <img class="main_body_part" id="stk_head" src="stickman_images/head/stickman-head_Default.png"></br>
                    <img class="main_body_part" id="stk_larm" src="stickman_images/larm/stickman-lArm_Default.png"><img class="main_body_part" id="stk_body" src="stickman_images/body/stickman-body_Default.png"><img class="main_body_part" id="stk_rarm" src="stickman_images/rarm/stickman-rArm_Default.png"></br>
                    <img class="main_body_part" id="stk_legs" src="stickman_images/legs/stickman-legs_Default.png"></br>
          </div>
          <!-- Make a left and right container for drag/drop and configurations -->
          <div class="files_container">
               <div class="files_container_left">
                    <!-- File upload -->
                    <form action="upload_file.php" method="post" enctype="multipart/form-data">
                         <div class="drop-zone" id="drop-zone">
                              <span id="drop-zone-prompt" class="drop-zone__prompt">Drop file here or click to upload</span>
                              <input id="upload_files" type="file" name="upload_files" class="drop-zone__input">
                         </div>
                         <select name="part_selection" id="part_selection">
                                   <option value="head">Head</option>
                                   <option value="body">Body</option>
                                   <option value="larm">Left Arm</option>
                                   <option value="rarm">Right Arm</option>
                                   <option value="legs">Legs</option>
                         </select>
                         <select name="type_selection" id="type_selection">
                                   <option value="part">Upload as Part</option>
                                   <option value="configuration">Upload as Configuration</option>
                         </select>
                         <input type="submit" value="Upload">
                    </form>
               </div>
               
               <!-- Displays configurations -->
               <!-- Each configuration gets a download link, load button, and delete button -->
               <div class="files_container_right">
                    <div class="files_file_listing">
                    <?php
                         $files_configurations = array_diff(scandir('stickman_configurations'), array('.', '..'));
                         

                         echo '<table>';
                         echo '<tr><td><h2>Configurations</h2></td></tr>';
                         foreach($files_configurations as $x)
                         {
                              echo '<tr><td>';
                              echo '<button type="button" onclick=files_load_config("stickman_configurations/' . $x . '")>Load</button>';
                              echo '<button type="button" onclick=delete_file("stickman_configurations/' . $x . '")>Delete</button>';
                              echo '<a href="stickman_configurations/';
                              echo $x;
                              echo '" download="';
                              echo $x;
                              echo '">';
                              echo $x;
                              echo '</a>';
                              echo '</td></tr>';
                         }
                         echo '</table>';
                    ?>
                    </div>

               </div>
               
          </div>

          <!-- Stickman parts file listings -->
          <!-- Each part gets a download link, load button, and delete button -->
          <div class="files_file_listing">
               <?php
                    //Gets file arrays from server
                    $files_head = array_diff(scandir('stickman_images/head'), array('.', '..'));
                    $files_body = array_diff(scandir('stickman_images/body'), array('.', '..'));
                    $files_larm = array_diff(scandir('stickman_images/larm'), array('.', '..'));
                    $files_rarm = array_diff(scandir('stickman_images/rarm'), array('.', '..'));
                    $files_legs = array_diff(scandir('stickman_images/legs'), array('.', '..'));

                    echo '<h2>Files for download:<h2>';
                    echo '<table>';
                    echo '<tr><td><h2>Head</h2></td></tr>';

                    //walk thorugh each file array and display parts with buttons
                    foreach($files_head as $x)
                    {
                         echo '<tr><td>';
                         echo '<button type="button" onclick=files_load_part("stk_head",'. '"' . $x . '")>Load</button>';
                         echo '<button type="button" onclick=delete_file("stickman_images/head/' . $x . '")>Delete</button>';
                         echo '<a href="stickman_images/head/';
                         echo $x;
                         echo '" download="';
                         echo $x;
                         echo '">';
                         echo $x;
                         echo '</a>';
                         echo '</td></tr>';
                    }
                    echo '<tr><td><h2>Body</h2></td></tr>';
                    foreach($files_body as $x)
                    {
                         echo '<tr><td>';
                         echo '<button type="button" onclick=files_load_part("stk_body",'. '"' . $x . '")>Load</button>';
                         echo '<button type="button" onclick=delete_file("stickman_images/body/' . $x . '")>Delete</button>';
                         echo '<a href="stickman_images/body/';
                         echo $x;
                         echo '" download="';
                         echo $x;
                         echo '">';
                         echo $x;
                         echo '</a>';
                         echo '</td></tr>';
                    }
                    echo '<tr><td><h2>Left Arm</h2></td></tr>';
                    foreach($files_larm as $x)
                    {
                         echo '<tr><td>';
                         echo '<button type="button" onclick=files_load_part("stk_larm",'. '"' . $x . '")>Load</button>';
                         echo '<button type="button" onclick=delete_file("stickman_images/larm/' . $x . '")>Delete</button>';
                         echo '<a href="stickman_images/larm/';
                         echo $x;
                         echo '" download="';
                         echo $x;
                         echo '">';
                         echo $x;
                         echo '</a>';
                         echo '</td></tr>';
                    }
                    echo '<tr><td><h2>Right Arm</h2></td></tr>';
                    foreach($files_rarm as $x)
                    {
                         echo '<tr><td>';
                         echo '<button type="button" onclick=files_load_part("stk_rarm",'. '"' . $x . '")>Load</button>';
                         echo '<button type="button" onclick=delete_file("stickman_images/rarm/' . $x . '")>Delete</button>';
                         echo '<a href="stickman_images/rarm/';
                         echo $x;
                         echo '" download="';
                         echo $x;
                         echo '">';
                         echo $x;
                         echo '</a>';
                         echo '</td></tr>';
                    }
                    echo '<tr><td><h2>Legs</h2></td></tr>';
                    foreach($files_legs as $x)
                    {
                         echo '<tr><td>';
                         echo '<button type="button" onclick=files_load_part("stk_legs",'. '"' . $x . '")>Load</button>';
                         echo '<button type="button" onclick=delete_file("stickman_images/legs/' . $x . '")>Delete</button>';
                         echo '<a href="stickman_images/legs/';
                         echo $x;
                         echo '" download="';
                         echo $x;
                         echo '">';
                         echo $x;
                         echo '</a>';
                         echo '</td></tr>';
                    }
                    echo '</table>';
               ?>
          </div>
     </body>
</html>
