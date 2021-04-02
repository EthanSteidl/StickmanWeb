
/*
Author: Ethan Steidl
Description: Contains javascript functions specific to index.php
Functions in this file relate to changing the body parts of the 
stickman and updating their display
*/

/**
 * Author: Ethan Steidl
 * Description: Sets the body part on the stickman
 * param part (string): body part to set on the stickman
 * param filename (string): filename of part to load
 * return: none
 */
function setBodyPart(part, filename){
     //loads the current stickman body parts
     var stk_man = new Stickman();

     //alters the correct body part:
     //stk_head, stk_body, stk_larm, stk_rarm, stk_legs
     if(part == "stk_head")
     {
          //get full filename of new part
          var location = "stickman_images/head/";
          var path = location.concat(filename);

          //execute part placement saving it to history
          stk_man.head = path;
          //GRADING: ACTION
          hist.executeAction(new UndoRedo(stk_man));
     }
     else if(part == "stk_body")
     {
          //get full filename of new part
          var location = "stickman_images/body/";
          var path = location.concat(filename);

          //execute part placement saving it to history
          stk_man.body = path;
          hist.executeAction(new UndoRedo(stk_man));
     }
     else if(part == "stk_legs")
     {
          //get full filename of new part
          var location = "stickman_images/legs/";
          var path = location.concat(filename);

          //execute part placement saving it to history
          stk_man.legs = path;
          hist.executeAction(new UndoRedo(stk_man));
     }
     else if(part == "stk_larm")
     {
          //get full filename of new part
          var location = "stickman_images/larm/";
          var path = location.concat(filename);

          //execute part placement saving it to history
          stk_man.larm = path;
          hist.executeAction(new UndoRedo(stk_man));
          
     }
     else if(part == "stk_rarm")
     {
          //get full filename of new part
          var location = "stickman_images/rarm/";
          var path = location.concat(filename);

          //execute part placement saving it to history
          stk_man.rarm = path;
          hist.executeAction(new UndoRedo(stk_man));
     }
}

/*
function f(id){
     var next_img = get_next(document.getElementById(id).src);
     document.getElementById(id).src = "stickman_images/head/stickman-head_Leprechaun-beard.png";
}

function get_next(file){
     
     var fs = require('fs');
     var files = fs.readdirSync('/stickman_images');
     console.log(fs);
}

*/

/**
 * Author: Ethan Steidl
 * Description: Contains actions performed and allows each action to be
 *   undon or redone. After every action history saves itself to the 
 *   session storage
 * param: none
 * return: none
 * 
 * 
 */
function History(){
     //GRADING: MANAGE
     var commands =[];   //list of commands executed
     var index = 0;      //index of currently active command

     /**
      * Author: Ethan Steidl
      * Description: Executes action and saves to history, then updates
      *   session storage
      * param cmd (UndoRedo): command to execute
      * return: none
      */
     this.executeAction = function(cmd){
          commands.length = index;
          commands.push(cmd);
          index = commands.length;
          cmd.exec();

          //update storage
          updateSessionStorage();
     }

     /**
      * Author: Ethan Steidl
      * Description: Undoes action and saves to history, then updates
      *   session storage. Updates the stickman to the previous model
      * param: none
      * return: none
      */
     this.undoCmd = function(){

          //check if there is an action to do
          if(index > 0){
               //get previous command and set body to what the previous
               //command set it to.
               var cmd = commands[index-1];
               cmd.undo = function() {updateBody(cmd.old_man);}
               cmd.undo();
               index=index-1;
          }

          //update storage
          updateSessionStorage();
     }

     /**
      * Author: Ethan Steidl
      * Description: Redoes the previous command and saves history to
      *   session storage
      * param: none
      * return: none
      */
     this.redoCmd = function()
     {
          //check if there is an action to redo
          if(index < commands.length) 
          {
               //redoes previous action
               var cmd = commands[index];
               cmd.exec = function() {updateBody(cmd.stk_man);}
               cmd.exec();
               index = index+1;
          }

          //updates storage
          updateSessionStorage();
     }

     /**
      * Author: Ethan Steidl
      * Description: Loads history from a JSON object
      * param parsed_object (JSON): JSON of History
      * return: none
      */
     this.loadJSON = function(parsed_object)
     {
          commands = parsed_object.commands;
          index = parsed_object.index;
     }

     /**
      * Author: Ethan Steidl
      * Description: Converts history to a JSON
      * param: none
      * return merged (JSON): History as JSON
      */
     this.toJSON = function()
     {
          var merged = {
               commands,
               index
          };

          return merged;
     }


}

/**
 * Author: Ethan Steidl
 * Description: Stores the previous stickman and current stickman.
 *   Allows to update the stickman to the current or the previous
 *   state.
 * param stk_man (Stickman): Stickman object to be current stickman
 * return: none
 */
function UndoRedo(stk_man){   
     
     this.stk_man = stk_man;       //current stickman
     this.old_man = new Stickman();//old stickman

     /**
      * Author: Ethan Steidl
      * Description: Sets the stickman display to stk_man
      * param: none
      * return: none
      */
     this.exec = function(){
          updateBody(this.stk_man);
     }

     /**
      * Author: Ethan Steidl
      * Description: Sets the stickman display to old_man
      * param: none
      * return: none
      */
     this.undo = function(){
         updateBody(this.old_man);
     }
}

/**
 * Author: Ethan Steidl
 * Description: loads into the current stickman the configuration stored in
 *   the load_name element in the HTML. This will also cause history to 
 *   update.
 * param: none
 * return: none
 */
function load_configuration_prep()
{
     //load json of parts from config file
     var config_text = loadConfiguration('stickman_configurations/' + document.getElementById('load_name').value);
     var json_obj = JSON.parse(config_text);

     //place the config parts into a stickman
     var stk_man = new Stickman();
     stk_man.head = json_obj.head;
     stk_man.body = json_obj.body;
     stk_man.larm = json_obj.larm;
     stk_man.rarm = json_obj.rarm;
     stk_man.legs = json_obj.legs;

     //set this stickman to active and add to history
     //GRADING: ACTION
     hist.executeAction(new UndoRedo(stk_man));

}

/**
 * Author: Ethan Steidl
 * Description: Retrieves configFile from the server and returns the
 *   contents.
 * param configFile (string): Configuration file to load
 * return Httpreq.responseText (string): JSON representing configFile
 */
function loadConfiguration(configFile)
{
     //get config file from server
     var Httpreq = new XMLHttpRequest();
     Httpreq.open("GET",configFile,false);
     Httpreq.send(null);

     //return contents of configFile
     return Httpreq.responseText;  
}

/**
 * Author: Ethan Steidl
 * Description: Updates the session storage for the stickman and the history
 * param: none
 * return: none
 */
function updateSessionStorage()
{
     //save stickman to session as "stk_man"
     stk_man = new Stickman();
     sessionStorage.setItem("stk_man", JSON.stringify(stk_man));

     //save History to session as "hist"
     sessionStorage.setItem("hist", JSON.stringify(hist.toJSON()));

}

/**
 * Author: Ethan Steidl
 * Description: Loads the history and stickman from session. If they are not
 *   in the session, nothing is loaded.
 * param: none
 * return: none
 */
function loadSessionStorage()
{
     //check if the history is in the session if so, load it
     if(sessionStorage.getItem("hist") !== null)
     {
          var new_hist = JSON.parse(sessionStorage.getItem("hist"));
          hist.loadJSON(new_hist);
     }

     //check if the stickman is in the session if so, load it
     if(sessionStorage.getItem("stk_man") !== null)
     {
          var str = sessionStorage.getItem("stk_man");
          var stk_man = JSON.parse(str);
          updateBody(stk_man);
     }
}

/**
 * Author: Ethan Steidl
 * Description: Updates the display of the stickman to a new stk_man
 * param stk_man (Stickman): New stickman to display
 * return: none
 */
function updateBody(stk_man)
{
     //sets the document images to new part images
     document.getElementById('stk_head').src = stk_man.head;
     document.getElementById('stk_body').src = stk_man.body;
     document.getElementById('stk_legs').src = stk_man.legs;
     document.getElementById('stk_larm').src = stk_man.larm;
     document.getElementById('stk_rarm').src = stk_man.rarm;
}

/**
 * Author: Ethan Steidl
 * Description: Holds five body parts of a stickman. Their initial values are
 *   the file names of the five currently displayed stickman parts.
 * param: none
 * return: none
 */
function Stickman(){
     //GRADING: COMMAND
     //note the 5 params are file names not paths
     this.head = document.getElementById('stk_head').src;
     this.body = document.getElementById('stk_body').src;
     this.legs = document.getElementById('stk_legs').src;
     this.larm = document.getElementById('stk_larm').src;
     this.rarm = document.getElementById('stk_rarm').src;
}

/**
 * Author: Ethan Steidl
 * Description: POST request from Javascript. This is not my code. It belongs
 *   to Rakesh Pai and can be found at
 *   https://stackoverflow.com/questions/133925/javascript-post-request-like
 *   -a-form-submit
 * 
 *   This submits the params to a server file path as a post request.
 * param path (string): server file to post to
 * param params (JSON): Data to post
 * param method (string): Send type, GET, POST, etc.
 * return: none
 */
function post(path, params, method='post') 
{

     const form = document.createElement('form');
     form.method = method;
     form.action = path;
   
     for (const key in params) 
     {
       if (params.hasOwnProperty(key)) 
       {
         const hiddenField = document.createElement('input');
         hiddenField.type = 'hidden';
         hiddenField.name = key;
         hiddenField.value = params[key];
   
         form.appendChild(hiddenField);
       }
     }
   
     document.body.appendChild(form);
     form.submit();
}

/**
 * Author: Ethan Steidl
 * Description: Posts the current stickman to upload_index.php along with
 *   a name to save the configuration file as. The server will then save
 *   this configuration with that filename.
 * param: none
 * return: none
 */
function post_prep()
{
     //get current stickman
     var stk_man = new Stickman();

     //create a json with the stickman and the save file name
     var params = {
          filename: document.getElementById('save_name').value,
          head: stk_man.head,
          body: stk_man.body,
          larm: stk_man.larm,
          rarm: stk_man.rarm,
          legs: stk_man.legs

     }
     
     //post to upload_index.php
     post('upload_index.php', params);
}


//create a history object to manage history
var hist = new History();

/**
 * Author: Ethan Steidl
 * Description: Prepares the window onload by linking buttons. Also laods
 *   the stickman and history from session storage
 * param: none
 * return: none
 */
window.onload = function() {

     hist = new History();
     document.getElementById("undo").onclick = hist.undoCmd;
     document.getElementById("redo").onclick = hist.redoCmd;
     document.getElementById("save_config").onclick = post_prep;
     document.getElementById("load_config").onclick = load_configuration_prep;
     loadSessionStorage();
}
