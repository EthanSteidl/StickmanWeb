<!-- 
Author: Ethan Steidl
Class: CSC 468
Description: This program is a webpage that lets the user edit the cloths
of a stickman. The user can undo and redo changes on the stickman. They
can also save their progress to the server and load their progress at any
time. They can also download any saved clothing item. In additon to clothing
items, configuration files for the stickman may also be loaded/saved/etc.

Checklist:
See the help page or help.html

Bugs:
None

-->

<html>
     <head>
          <!-- Set the style sheets and javascript -->
          <title>Landing Page</title>
          <link href="StyleSheet.css" rel="stylesheet" type="text/css">
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <script id="js_type" type="text/javascript" src="funcs.js"></script>
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
                    <a class="active" href="index.php">Home</a>
                    <a href="files.php">Files</a>
                    <a href="help.html">Help</a>
          </div>

          <div class="main_container">
               <!-- Holds stickman display -->
               <div class="main_container_left">
                    <div class="main_body_display"> 
                    <img class="main_body_part" id="stk_head" src="stickman_images/head/stickman-head_Default.png"></br>
                    <img class="main_body_part" id="stk_larm" src="stickman_images/larm/stickman-lArm_Default.png"><img class="main_body_part" id="stk_body" src="stickman_images/body/stickman-body_Default.png"><img class="main_body_part" id="stk_rarm" src="stickman_images/rarm/stickman-rArm_Default.png"></br>
                    <img class="main_body_part" id="stk_legs" src="stickman_images/legs/stickman-legs_Default.png"></br>
                    </div>
               </div>
               <!-- Holds all otions and interactables -->
               <div class="main_container_right">
                    <div class="main_option_buttons">
                         <!-- Undo,redo,save,load interactables -->
                         <button id="undo" type="button">Undo</button>
                         <button id="redo" type="button">Redo</button>
                         <button id="save_config" type="button">Save Config</button>
                         <input id="save_name" type="text" name="save_name">
                         <button id="load_config" type="button">Load Config</button>
                         <input id="load_name" type="text" name="load_name">
                    </div>
                    <!-- Displays image of all body parts on server, lets user click them to change man -->
                    <?php
                         //get files in server directories
                         $path    = 'stickman_images';
                         $files_head = array_diff(scandir('stickman_images/head'), array('.', '..'));
                         $files_body = array_diff(scandir('stickman_images/body'), array('.', '..'));
                         $files_larm = array_diff(scandir('stickman_images/larm'), array('.', '..'));
                         $files_rarm = array_diff(scandir('stickman_images/rarm'), array('.', '..'));
                         $files_legs = array_diff(scandir('stickman_images/legs'), array('.', '..'));

                         //place all the files in a table with onclick to change body parts
                         echo '<table>';
                         echo '<tr>';
                         foreach($files_head as $x)
                         {
                              echo '<th><img class="body_part" onclick="setBodyPart(\'stk_head\', \'';
                              echo $x;
                              echo '\')" src="stickman_images/head/';
                              echo $x;
                              echo '"></th>';
                         }
                         echo '</tr>';
                         echo '<tr>';
                         foreach($files_body as $x)
                         {
                              echo '<th><img class="body_part" onclick="setBodyPart(\'stk_body\', \'';
                              echo $x;
                              echo '\')" src="stickman_images/body/';
                              echo $x;
                              echo '"></th>';
                         }
                         echo '</tr>';
                         echo '<tr>';
                         foreach($files_larm as $x)
                         {
                              echo '<th><img class="body_part" onclick="setBodyPart(\'stk_larm\', \'';
                              echo $x;
                              echo '\')" src="stickman_images/larm/';
                              echo $x;
                              echo '"></th>';
                         }
                         echo '</tr>';
                         echo '<tr>';
                         foreach($files_rarm as $x)
                         {
                              echo '<th><img class="body_part" onclick="setBodyPart(\'stk_rarm\', \'';
                              echo $x;
                              echo '\')" src="stickman_images/rarm/';
                              echo $x;
                              echo '"></th>';
                         }
                         echo '</tr>';
                         echo '<tr>';
                         foreach($files_legs as $x)
                         {
                              echo '<th><img class="body_part" onclick="setBodyPart(\'stk_legs\', \'';
                              echo $x;
                              echo '\')" src="stickman_images/legs/';
                              echo $x;
                              echo '"></th>';
                         }
                         echo '</tr>';
                         echo '</table>';
                    
                    ?>
                    <!-- Shows configuration options for stickman -->
                    <div class="stickman_configurations_display">
                         <h2>
                              Configuration Options
                         </h2>
                         <?php
                              $config_files = array_diff(scandir('stickman_configurations'), array('.', '..'));
                              
                              foreach($config_files as $x)
                              {

                                   echo $x;
                                   echo '<br>';
                              }
                              
                         ?>
                    </div>
               </div>
          </div>
     </body>
</html>

