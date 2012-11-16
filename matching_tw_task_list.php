<?php
session_start();

require_once 'TeamworkProjectManager.php';
require_once 'error_utils.php';

/*
 * This script determines if a dashboard task is already in a task
 * list for a given project.  
 * 
 * @pre isset(post/get["taskDescription"])
 * @pre isset(post/get["twProjId"])
 */

// error handling for invalid call
if(!isset($_POST["taskDescription"])) {
    if(!isset($_GET["taskDescription"])) 
	returnErrorJson("taskDescription must be defined");
    
    $_POST["taskDescription"] = $_GET["taskDescription"];
}
else if(!isset($_POST["twProjId"])) {
    if(!isset($_GET["twProjId"])) 
	returnErrorJson("twProjId must be defined");
    
    $_POST["twProjId"] = $_GET["twProjId"];
}

// get the task lists for the given project
$query = "projects/" . $_POST["twProjId"] . "/todo_lists.json";
$todoLists = TeamworkPortal::getData($query);

print_r($todoLists);

?>
