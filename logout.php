<?php
session_start();
$appv =$_SESSION['appv'];
$androidid =$_SESSION['androidid'];

session_unset();
session_destroy();


header("Location: login.html");
exit();
?>