<?php
$debug = false;
$dbedit = true;

function urlvar($varname, $get = false) {
    global $debug;
    
    if($get || $debug) {
        return $_GET[$varname];
    }
    else {
        return $_POST[$varname];
    }
}

?>