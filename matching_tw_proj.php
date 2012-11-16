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

if(!isset($_POST["externalId"])) {
    if(!isset($_GET["externalId"])) {
        echo "{\"error\": \"You must specify an id to match.\"}";
	exit;
    } else {
	$_POST["externalId"] = $_GET["externalId"];
    }
}
print_r($_POST);
//assert(isset($_POST["externalId"]));

//print_r($_POST["externalId"]);

/**
 * Gets the list of teamwork projects
 * @return An array of projects ids
 */
function getTwProjectIds()
{
    // get the teamwork project data if don't have it already
    if(!isset($_SESSION["teamwork-projects"]))
    {
	$allProjects = json_decode(TeamworkPortal::getData("projects.json"));
	$projNameIdIndex = array();
	for($i = 0; $i < count($allProjects->projects); $i++)
	{
	    preg_match('/.*-...R?-.../i', $allProjects->projects[$i]->name, $matches, 0, 0);
	    $sanitizedName = $matches[0];
	    if($sanitizedName === "")
		continue;
	    
	    $projNameIdIndex[$sanitizedName] = $allProjects->projects[$i]->id;
	}
	    
	$_SESSION["teamwork-projects"] = json_encode($projNameIdIndex);
    }
  
    return json_decode($_SESSION["teamwork-projects"]);
}

$teamProjects = getTwProjectIds();


// create response
$retJSON = "{";

//$retJSON .= "'\$_SESSION:'" . $_SESSION["teamwork-projects"] . "',";

$retJSON .= "'posted-external-id': '".$_POST['externalId']."',";

$matchingId = "none";
$dashExternalId = preg_replace("/\s/", "", $_POST["externalId"]);
if(isset($teamProjects->{$dashExternalId}))
    $matchingId = $teamProjects->{$dashExternalId};

$retJSON .= "'matchingTwProjId':'" . $matchingId . "'";

$retJSON .= "}";

echo $retJSON;
?>
