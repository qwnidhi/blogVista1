<?php 
require_once 'config/constants.php';

//destroy all session and redirect user to home page
session_destroy();
header('location: ' .ROOT__URL);
die();
?>