<?php

/**
 * Returns an error message from json
 * @param String $message The message of the error.
 */
function returnErrorJson($message)
{
    echo "{\"error\": \"" . $message ."\"}";
    exit;   
}

?>
