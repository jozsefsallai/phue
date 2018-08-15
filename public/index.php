<?php

$debugMode = true;

if ($debugMode) {
  error_reporting(E_ALL);
  ini_set('display_errors', 'on');
}

require_once('../api/lib/views.php');
require_once('../api/lib/router/Router.php');
require_once('../api/lib/routes.php');

?>
