<?php
// initialize session
session_start();

// unset all session veriables
$_SESSION = array();

//destroy the session
session_destroy();


// redirect to the home page
header("location: ./index.php");

?>