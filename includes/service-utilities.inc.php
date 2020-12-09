<?php

function getJsonErrorMessage()
{
    return '{"error": {"message":"Value not found or Incorrect query string values"}}';
}


/*
  Checks for query string info that specifies which criteria to use
*/
function isIdPresent($paramName) {
    $lower = strtolower($paramName);
    
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET[$lower]) && !empty($_GET[$lower])) {
        return true;
    }
    
    return false;
}
