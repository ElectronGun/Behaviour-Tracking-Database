<?php 

  // The model contains all the functions that access and modify the database,
  // which is the responsibility of the model in the MVC pattern.


  // Retrieves all behavior records from the behaviours table and returns them
  function getAllBehaviours()
  {
    // use the global $conn variable for the connection to the database
    global $conn;
    
    // run the query to select all the records... there is no need for using a 
    // prepared statement as we have no parameters
    $stmt = $conn->query("SELECT * FROM behaviours");
    
    // Use fetchAll() to fetch *all* the records at once
    // php.net fetchAll(): 
    //   https://www.php.net/manual/en/pdostatement.fetchall.php
    $behaviours = $stmt->fetchAll();
    
    // return all the fetched records
    return $behaviours;
  }
  
  // deletes the record with the $id provided as an argument
  function deleteRecord($id)
  {
    // use the global $conn variable for the connection to the database
    global $conn; 
    
    // prepare the statement to delete the record with the given id
    $stmt = $conn->prepare("DELETE FROM behaviours WHERE id=?");
    
    // execute the statement
    $stmt->execute([$id]);
  }
  
  // creates a record with the given studentname, behaviour, severity and 
  // timewhen parameters
  function createRecord($studentname, $behaviour, $severity, $timewhen)
  {
    // use the global $conn variable for the connection to the database
    global $conn; 
    
    // prepare the statement... we hardcode "lastedhour" to be set to "No" when
    // the record is first created
    $stmt = $conn->prepare("INSERT INTO `behaviours`(`id`, `studentname`, `behaviour`, `severity`, `timewhen`, `lastedhour`) VALUES (NULL, ?, ?, ?, ?, 'No')");
    
    // execute the statement 
    $stmt->execute([ $studentname, $behaviour, $severity, $timewhen ]);
  }
  
  // get a specific behaviour record using its id
  function getBehaviour($id)
  {
    // use the global $conn variable for the connection to the database
    global $conn; 
    
    // prepare the statement to get a specific record, using a where clause 
    // looking for the record with the matching id
    $stmt = $conn->prepare("SELECT * FROM behaviours WHERE id=?");
    
    // execute the statement
    $stmt->execute([$id]);
    
    // fetch all the records... note that we *know* there will only be one 
    // record in the array of records in practice because we know id is a 
    // unique value for each record as it is the primary key
    $behaviours = $stmt->fetchAll();
    
    // return the one record that we know must be present
    return $behaviours[0];    
  }
  
  // updates the severity and behaviour fields of a record with the given id
  function performUpdate($behaviour, $severity, $id)
  {
    // use the global $conn variable for the connection to the database
    global $conn; 
    
    // prepare the update statement
    $stmt = $conn->prepare("UPDATE `behaviours` SET `behaviour`=?,`severity`=? WHERE id=?");
    
    // execute the update statement using the parameters
    $stmt->execute([ $behaviour, $severity, $id ]);    
  }

  // **** MY MODIFICATIONS TO app.model.php
  // *** SEVERITY SORT *** /
  // *** Retrieves all behavior records from the behaviours table and returns them sorted by severity
  function getBehavioursSortedBySeverity($sort_order)  {

    // *** Use the global $conn variable for the connection to the database
    global $conn;
    
    // *** Run the query to select all the records and sort them by severity
    $stmt = $conn->prepare("SELECT * FROM behaviours ORDER BY severity " . $sort_order);
    
    // *** Execute the statement
    $stmt->execute();
    
    // *** Use fetchAll() to fetch *all* the records at once
    $behaviours = $stmt->fetchAll();
    
    // *** Return all the fetched records
    return $behaviours;
  }

  // *** DELETE ALL records 
  function deleteAllRecords() {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM behaviours");
    $stmt->execute();
  }

  // *** ADD LASTED >1HR - updateHour *** /
  function updateHour($id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE behaviours SET lastedhour = 'Yes' WHERE id = ?");
    $stmt->execute([$id]);
  }

  // *** ADD DUPLICATE RECORD *** /
  function duplicateRecord($id) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO behaviours (studentname, behaviour, severity, timewhen, lastedhour) SELECT studentname, behaviour, severity, timewhen, lastedhour FROM behaviours WHERE id = ?");
    $stmt->execute([$id]);
  }
?>