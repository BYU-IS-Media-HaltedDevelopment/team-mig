<?php


require 'DashboardTaskManager.php';

/**
 * Retreives all of the dashboard tasks for a user and returns it 
 * as json
 */

/**
 * @pre $_POST["dash_user"] contains the user's dashboard username
 */

assert(isset($_POST["dash_user"]));

$dashTaskManager = new DashboardTaskManager($_POST["dash_user"]);
//$dashTaskManager;

//print_r($dashTaskManager->dashTasks);
echo json_encode($dashTaskManager->dashTasks);

?>
