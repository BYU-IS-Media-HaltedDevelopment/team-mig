<?php
session_start();

require_once 'TeamworkProjectManager.php';

/**
 * Get the teamwork project ids of the projects that match the given
 * external id
 * @pre $_POST["api-key"] the api key for the user
 * @pre $_POST["externalId"] the dashboard external i
 * @return The matching teamwork project id is returned and '{}' is 
 * returned if nothing matches
 */

/**
 * Gets the list of teamwork projects
 * @return json array of teamwork projects
 */
function getTwProjects()
{
    $fullProjectJson = TeamworkPortal::getData("projects.json");
    return $fullProjectJson;
}

if(!isset($_SESSION["teamwork-porjects"]))
{
    $_SESSION["teamwork-porjects"] = getTwProjects();
}

$matchingTwProj = null;
if(isset($_GET["externalId"]))
{
	$_POST["externalId"] = $_GET["externalId"];
}
assert(isset($_POST["externalId"]));

$teamProjManager = TeamworkProjectManager::getInstance();
$matchingTwProj = $teamProjManager->getProjectByName($_POST["externalId"]);

$retJSON = "{";

$retJSON .= "'posted-external-id': '".$_POST['externalId']."',";


if($matchingTwProj == null)
{
    $retJSON .= "'matchingTwProjId': 'none'";
}
else
{
    $retJSON .= "'matchingTwProjId':'" + $matchingTwProj->id; + "'";
}
$retJSON .= "}";

echo $retJSON;
?>
