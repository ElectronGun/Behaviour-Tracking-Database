<!DOCTYPE HTML>
<html>
<head>
  <title>Behaviour Tracker Application</title>
  <style>
    table, tr, th, td {
      border: 2px solid black;
    }

    table {
      border-collapse: collapse;
    }

    td, th { 
      padding: 10px;
    }
    
    .error {
      color: red;
    }

    fieldset {
      width: 640px;
    }
  </style>
</head>
<body>
  <h1>Behaviour Tracker Application</h1>
  
  <!-- Diplay Behaviour Records in Table -->
  <h2>Behaviours Recorded</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Student Name</th>
      <th>Behaviour</th>
      <!-- *** ADD Up & Down Sorting Controls *** -->
      <th>Severity <a href="app.ctrl.php?sort=asc">UP</a> | <a href="app.ctrl.php?sort=desc">DOWN</a></th>
      <th>Date/Time</th>
      <!-- *** ADD Lasted >1Hr *** -->
      <th>Lasted >1 Hour</th>
      <th>Delete</th>
      <th>Update</th>
      <!-- *** ADD Duplicate Record *** -->
      <th>Duplicate Record</th>
    </tr>
    <?php foreach ($TPL["behaviours"] as $behaviour) { ?> 
      <tr>
        <td><?php echo $behaviour["id"] ?></td>
        <td><?php echo $behaviour["studentname"] ?></td>
        <td><?php echo $behaviour["behaviour"] ?></td> 
        <td><?php echo $behaviour["severity"] ?></td> 
        <td><?php echo $behaviour["timewhen"] ?></td>
        <!-- *** ADD Lasted >1Hr OPTION*** -->
        <td><?php echo $behaviour["lastedhour"] ?> <a href="app.ctrl.php?act=update_hour&id=<?php echo $behaviour["id"] ?>">✓</a></td>
        

        <!-- Notice how we output the id into the link URL to setup the action!  This
             is how delete and update actions know *which* record is being deleted, etc.
        -->
        <td><a href="app.ctrl.php?act=delete&id=<?php echo $behaviour["id"] ?>">D</a></td>
        <td><a href="app.ctrl.php?act=update&id=<?php echo $behaviour["id"] ?>">U</a></td>

        <!-- *** ADD Duplicate Record OPTION*** -->
        <td><a href="app.ctrl.php?act=duplicate&id=<?php echo $behaviour["id"] ?>">Duplicate</a></td>
      </tr>
    <?php } ?>
  </table>
  
  <br />


  <!-- Optionally Diplay A Message -->
  <?php 
    if ($TPL["delete_message"]) { 
  ?>
    <strong><?php echo $TPL["message"]; ?></strong>
  <?php } ?>

  <?php 
    if ($TPL["create_message"]) { 
  ?>
    <strong><?php echo $TPL["message"] ?></strong>
  <?php  } ?>

  <?php 
    if ($TPL["update_message"]) { 
  ?>
    <strong><?php echo $TPL["message"] ?></strong>
  <?php  } ?>  

  <?php 
    if ($TPL["error_message"]) { 
  ?>
    <strong class="error"><?php echo $TPL["message"] ?></strong>
  <?php  } ?>  


  <br />  

  <!-- Optionally Diplay The Update Form -->
  <?php 
    if ($TPL["update_form"]) { 
  ?>
    <h3>Update Record <?php echo $TPL["update_id"] ?></h3>
    
    <!-- We put the id of the record being updated into the form action as a
         query parameter so that the controller knows which record is being 
         updated when the form is sumbmitted.  Also notice how we set the 
         action itself with act=perform_update. -->
    <form action="app.ctrl.php?act=perform_update&id=<?php echo $TPL["update_id"] ?>" 
          method="post">
      <fieldset>

        <!-- We output the current behaviour and severity values of the record 
             being updated into the form inputs so the user can modify them 
             from this starting point.  -->
        <label for="behaviour">Behaviour:</label> 
        <input type="text" name="behaviour" 
               value="<?php echo $TPL["updaterecord"]["behaviour"] ?>" /> <br /> <br />
        <label for="severity">Severity:</label> 
        <input type="number" name="severity" min="1" max="5"
               value="<?php echo $TPL["updaterecord"]["severity"] ?>" /> <br />  <br />
        <input type="submit" value="Update Record" /> 
    </fieldset>
   </form>

  <?php } ?>

  <br /> 

  <h3>Create Record</h3>
  <!-- We set the act to create as a query parameter in the from action -->
  <form action="app.ctrl.php?act=create" method="post">
    <fieldset>
      <label for="studentname">Student Name:</label> 
      <input type="text" name="studentname" /> <br /> <br /> 
      <label for="behaviour">Behaviour:</label> 
      <input type="text" name="behaviour" /> <br /> <br />
      <label for="severity">Severity:</label> 
      <input type="number" min="1" max="5" value="1" name="severity" /> <br />  <br />
      <label for="timewhen">Date/Time:</label>  
      <input type="datetime-local" name="timewhen" /> <br /> <br /> <br />
      <input type="submit" value="Create Record" /> 
    </fieldset>
  </form>

  <br /> <br />


  <!-- **** ADD a DELETE ALL button  **** -->
  <button onclick="window.location.href='app.ctrl.php?act=delete_all'">Delete All Records</button>



  
  <!-- We do a print_r of the template array into a preformatted text tag so
       that when developing the application we can see the template array 
       values.  This may help us to debug things as we can see in the view 
       what the controller set in the template array.  -->
  <br /> <br /> <br /> <br />
  <h3>Debug Help - Template Array</h3>
  <pre>
    <?php print_r($TPL); ?>
  </pre>
</body>
</html>