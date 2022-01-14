<?php
require_once("functions.php");

if ( score_check($score, 0, 100) === FALSE ) {
    die( "error: exiting.." );
} 