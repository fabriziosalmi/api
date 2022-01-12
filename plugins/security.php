<?php

if ( !isset($_GET["key"]) ) {
    die("error: no auth provided");
}

if ( isset($_GET["key"]) && $_GET["key"] = "" ) {
    die("error: key is empty");
}

if ( isset($_GET["key"]) && $_GET["key"] != "48h93br3497n43hr743r43897r34hr34" ) {
    die("error: key is not valid");
}