<?php

session_start();
session_destroy();
header('location: ../AUTH/signin.php');
exit();

?>