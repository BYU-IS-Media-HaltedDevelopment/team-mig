<?php

require_once 'TeamworkProjectManager.php';

/**
 * Get the teamwork project ids of the projects that match the given
 * external id
 * @pre $_POST["api-key"] the api key for the user
 * @pre $_POST["externalId"] the dashboard external i
 * @return The matching teamwork project id is returned and '{}' is 
 * returned if nothing matches
 */

assert(isset($_POST["externalId"]));


$teamProjManager = TeamworkProjectManager::getInstance();
$matchingTwProj = $teamProjManager->getProjectByName($_POST["externalId"]);

if($matchingTwProj == null)
{
    echo "{'matchingTwProjId': 'none'}";
}
else
{
    echo "{'matchingTwProjId':'" + $matchingTwProj->id; + "'}";
}
    
?>
