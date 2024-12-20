<?php 
  
  // include the config file first to make the database connection
  include "app.config.php";

  // include the model so that the controller has access to the mdoel functions
  include "app.model.php";
  
  // create the template array
  $TPL = [];
  
  // get the act query parameter used by all 'actions'
  $act = filter_input(INPUT_GET, "act", FILTER_SANITIZE_SPECIAL_CHARS);
  
  // get the id query parameter that most actions use
  $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_SPECIAL_CHARS);
  
  // get the form data (will work with either the create or update forms)
  $studentname = filter_input(INPUT_POST, "studentname", FILTER_SANITIZE_SPECIAL_CHARS);
  $behaviour = filter_input(INPUT_POST, "behaviour", FILTER_SANITIZE_SPECIAL_CHARS);
  $severity = filter_input(INPUT_POST, "severity", FILTER_VALIDATE_INT);
  $timewhen = filter_input(INPUT_POST, "timewhen", FILTER_SANITIZE_SPECIAL_CHARS);
  
// ***Severity Sort - Default sort order is ASCENDING
// get the sort parameter
if (isset($_GET['sort'])) {
  $sort_order = $_GET['sort'];
} else {
  $sort_order = 'asc'; // default sort order
}


  // initialize the template booleans to false... we can display these sections
  // of the view by setting these keys to true if necessary
  $TPL["delete_message"] = false; 
  $TPL["create_message"] = false;
  $TPL["update_form"] = false;
  $TPL["update_message"] = false;
  $TPL["error_message"] = false;
 
  // if the act is not NULL, the user has performed an action like clicking
  // on a link...
  if ($act != NULL)
  {
    // We use a "switch controller" that looks at the $act and runs the code
    // according to the action that has taken place
    switch ($act)
    {
      // delete a record
      case "delete":

        // call the model function to delete the record from the database
        deleteRecord($id);

        // display a delete message (find these keys in the view to see how 
        // they work!)
        $TPL["delete_message"] = true; 
        $TPL["message"] = "Deleted Record " . $id;
        break;
      

      // create a record
      case "create":

        // check if any form inputs are empty, display a message if they are
        if ($studentname == "" || $behaviour == "" || $severity == "" || $timewhen == "")
        {
          $TPL["error_message"] = true;
          $TPL["message"] = "Form inputs cannot be empty.";
        }
        // check if student name exceeds max length, display a message if so
        else if (!(strlen($studentname) <= 255))
        {
          $TPL["error_message"] = true; 
          $TPL["message"] = "Student Name must be below 255 characters.";
        }   
        // check if behaviour exceeds max length, display a message if so
        else if (!(strlen($behaviour) <= 255))
        {
          $TPL["error_message"] = true; 
          $TPL["message"] = "Behaviour must be below 255 characters.";
        } 
        // if all form validation succeeds, create the record              
        else 
        {
          // modify the date received from the HTML input such that it can 
          // be stored in the MySQL database
          $date = date("Y-m-d H:i:s", strtotime($timewhen));
          
          // call the model function to create the record
          createRecord($studentname, $behaviour, $severity, $date);

          // set template array keys to display a message that a record has been 
          // created
          $TPL["create_message"] = true; 
          $TPL["message"] = "Created Record for " . $studentname . " at time " . $timewhen;
        }
        break;
     

      // update action will display the upate form
      case "update":

        // fetch the *specific* record of data for behaviour with the given id
        $TPL["updaterecord"] = getBehaviour($id);

        // set template array keys to display the update form and set its 
        // action to update the behaviour with the update_id
        $TPL["update_form"] = true;
        $TPL["update_id"] = $id;

        break;
      

      // action to perform the update of the data itself when the update form
      // is submitted
      case "perform_update":

        // check if any form inputs are empty, display a message if they are
        if ($behaviour == "" || $severity == "")
        {
          $TPL["error_message"] = true;
          $TPL["message"] = "Form inputs cannot be empty.";
        }
        // check if behaviour exceeds max length, display a message if so
        else if (!(strlen($behaviour) <= 255))
        {
          $TPL["error_message"] = true; 
          $TPL["message"] = "Behaviour must be below 255 characters.";
        } 
        // if all form validation succeeds, create the record              
        else 
        {        
          // call model function to update this specific record in the database
          performUpdate($behaviour, $severity, $id);

          // set template array keys to display the update message
          $TPL["update_message"] = true;
          $TPL["message"] = "Updated Record " . $id;
        }
        break;

      // **** Add to switch cases DELETE ALL records ***
      case "delete_all":
        deleteAllRecords();
        $TPL["delete_message"] = true; 
        $TPL["message"] = "Deleted All Records";
        break;

      // **** Add to switch cases LASTED >1HR ***
      case "update_hour":
        updateHour($id);
        $TPL["update_message"] = true; 
        $TPL["message"] = "Updated Lasted >1 Hour for Record " . $id;
        break;

      // **** Add to switch cases DUPLICATE RECORD ***
      case "duplicate":
        duplicateRecord($id);
        $TPL["create_message"] = true; 
        $TPL["message"] = "Duplicated Record " . $id;
        break;
    }
  }
  
  // fetch all the behavior records for display in the view... we put this 
  // *below* the switch in this case because switch actions may effect the 
  // records, and because we want to display all the records after an action
  // has been performed no matter what action takes place (or even if no 
  // action has taken place, as when the page first loads)
  // *** Severity Sort - retrieved in order specified by sort parameter ***
  $TPL["behaviours"] = getBehavioursSortedBySeverity($sort_order);

  // include the view file at the bottom of the controller
  include "app.view.php";

?>