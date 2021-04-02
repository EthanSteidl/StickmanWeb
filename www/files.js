/*
Author: Ethan Steidl
Description: Contains javascript functions specific to files.php
This document relies on func.js being loaded to function.
Functions in this file relate to deleteing/uploading/loading
files. The loading of files will redirect to index.php and 
load the correct clothing piece onto the stickman
*/


/**
 * Author: Ethan Steidl
 * Description: Deletes the file 
 * param fname (string): name of file to remove
 * return: none
 */
function delete_file(fname)
{
     //prepare post JSON
     var params = {
          filename: fname
     }

     //post delete to delete_file.php
     post('delete_file.php', params);
}

/**
 * Author: Ethan Steidl
 * Description: Loads configuration file
 * param fname (string): name of file to load
 * return: none
 */
function files_load_config(fname)
{
     //create history and retrieve session data
     hist = new History();
     loadSessionStorage();

     //Create a stickman with the configurations body parts
     var mytext = loadConfiguration(fname);
     var json_obj = JSON.parse(mytext);
     var stk_man = new Stickman();
     stk_man.head = json_obj.head;
     stk_man.body = json_obj.body;
     stk_man.larm = json_obj.larm;
     stk_man.rarm = json_obj.rarm;
     stk_man.legs = json_obj.legs;

     //Add this action to the history and perform load
     hist.executeAction(new UndoRedo(stk_man));

     //redirect back to index.php
     window.location.href = "index.php";
}

/**
 * Author: Ethan Steidl
 * Description: Loads part file
 * param part (string): body part to load to
 * param fname (string): name of file to load
 */
function files_load_part(part, fname)
{
     //create history and retrieve session data
     hist = new History();
     loadSessionStorage();

     //set the pody part to the new part
     setBodyPart(part, fname);

     //redirect to index.php
     window.location.href = "index.php";

}

/**
 * Author: Ethan Steidl
 * Description: Uploads a part or a config file
 * param: none
 * return: none
 */
function upload_part()
{
     //finds file and part from the fields in the upload file section
     var _files = document.getElementById("upload_filesx").value;
     var _part = document.getElementById("part_selection").value;

     //files is likely a list therefore add all elements in list
     //place values into a json
     var params = {
          part: _part,
          files: _files
     }

     //post the json to upload_file.php
     post('upload_file.php', params);
}


/**
 * Author: Dcode, Ethan Steidl
 * Description: manages thumbnail and image on the file upload
 *   box. This code is based on Dcode's example at 
 *   https://www.youtube.com/watch?v=Wtrin7C4b7w and
 *   https://codepen.io/dcode-software/pen/xxwpLQo
 * param dropZoneElement (object): object with the file input field
 * param file (File): file to set as the thumbnail
 * return: none
 */
function updateThumbnail(dropZoneElement, file) {
     let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");
   
     // First time - remove the prompt
     if (dropZoneElement.querySelector(".drop-zone__prompt")) 
     {
          dropZoneElement.querySelector(".drop-zone__prompt").remove();
     }
   
     // First time - there is no thumbnail element, so lets create it
     if (!thumbnailElement) 
     {
          thumbnailElement = document.createElement("div");
          thumbnailElement.classList.add("drop-zone__thumb");
          dropZoneElement.appendChild(thumbnailElement);
     }
   
     thumbnailElement.dataset.label = file.name;
   
     // Show thumbnail for image files
     if (file.type.startsWith("image/")) 
     {
          const reader = new FileReader();

          //set thumbnial for image
          reader.readAsDataURL(file);
          reader.onload = () => {
               thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
          };
     } 
     else 
     {
          //prevent error if there is no valid image thumbnail
          thumbnailElement.style.backgroundImage = null;
     }
}
   

/**
 * Author: Ethan Steidl, Dcode
 * Description: Prepares the document when the page loads
 *   The main part of this function prepares the file drag and drop zone.
 *   This code is based on Dcode's example at 
 *   https://www.youtube.com/watch?v=Wtrin7C4b7w and
 *   https://codepen.io/dcode-software/pen/xxwpLQo
 * param: none
 * return: none
 */
window.onload = function() {


     document.querySelectorAll(".drop-zone__input").forEach(inputElement => {
          const dropZoneElement = inputElement.closest(".drop-zone");
          
          //Enables the ability to click on the file drop zone
          dropZoneElement.addEventListener("click", (e) => 
          {
               inputElement.click();
          });
          
          //enables the change event to set the thumbnail
          inputElement.addEventListener("change", (e) => {
               if (inputElement.files.length) 
               {
                    updateThumbnail(dropZoneElement, inputElement.files[0]);
               }
          });
          
          //enables the ability to change the outline on dragover
          dropZoneElement.addEventListener("dragover", e => {
               e.preventDefault();
               dropZoneElement.classList.add("drop-zone--over");
     
          });

          //resets the box when the cursor leaves or ends
          ["dragleave", "dragend"].forEach(type => {
               dropZoneElement.addEventListener(type, e => {
                    dropZoneElement.classList.remove("drop-zone--over");
               });
          });

          //updates the thumbnail when a file is dropped in the file uploader
          dropZoneElement.addEventListener("drop", e => {
               e.preventDefault();
               if(e.dataTransfer.files.length) {
                    inputElement.files = e.dataTransfer.files;
                    updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);

               }
               dropZoneElement.classList.remove("drop-zone--over");
          })
     });

}