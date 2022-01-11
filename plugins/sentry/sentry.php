<?php

/* Sentry.io */
require_once("raven-php/lib/Raven/Autoloader.php");
Raven_Autoloader::register();
$client = new Raven_Client('https://11eeea6339dc4b098f31fb3b2686f105:6c19f3c89d85423884e37db385aa1f8b@o149725.ingest.sentry.io/6141065');
$client->environment = "prod";
$client->release = "0.1";
$error_handler = new Raven_ErrorHandler($client);
$error_handler->registerExceptionHandler();
$error_handler->registerErrorHandler();
$error_handler->registerShutdownFunction();
