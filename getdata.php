<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();
require('model/database.php');
require('model/fdp.php');
require('model/ff_records.php');
require('model/ff_services.php');
require('model/ff_userloc.php');
require('model/ff_otherservice.php');


if ($_GET['action'] == 'getfdplist') {
    $data = get_fdplist($_POST['lat'], $_POST['lon'], $_SESSION['area']);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
}

if ($_GET['action'] == 'getfdplistnew') {
    $data = get_fdplist1($_POST['lat'], $_POST['lon'], $_SESSION['area']);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
}



if ($_GET['action'] == 'getsvlist') {
    $data = get_service($_POST['no']);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
}


if ($_GET['action'] == 'getteam') {
    $data = getTeamLoc($_SESSION['sid']);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
}


if ($_GET['action'] == 'saverec') {

    if($_SESSION['sid'] == ""){
        echo "<script type='text/javascript'>alert('Please Login Again')</script>";
        echo '<script type="text/javascript"> document.location = "logout.php";</script>';
    }

    $seq = save_rec(
        $_POST['fflat'],
        $_POST['fflon'],
        $_POST['ffvoice'],
        $_POST['ffcr'],
        $_POST['ffacc'],
        $_POST['ffmob'],
        $_POST['ffcat'],
        $_POST['serviceno'],
        //$_SESSION['sid'],
        $_POST['ffdp'],
        $_POST['ffcuscat'],
        $_POST['commentx'],
        $_SESSION['area']
    );


    foreach ($_POST as $name => $val) {
        if (strpos($name, '#')  !== false) {
            $temp = explode("#", $name);
            save_service($seq, $temp[0], $val);
        }
    }

    $othersvarr = $_POST['othersv'];

    foreach ($othersvarr as $othersv) {
        save_otherservice($seq,$othersv);
    }

    echo "<script type='text/javascript'>alert('Data Updated !')</script>";
    echo '<script type="text/javascript"> document.location = "index.php";</script>';
}



if ($_GET['action'] == 'saveuserloc') {
    if ($_SESSION['sid'] == "" ) {
        echo '<script type="text/javascript"> document.location = "logout.php";</script>';
    }
    $data = save_userloc($_POST['lat'], $_POST['lon'], $_SESSION['sid']);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
}


if ($_GET['action'] == 'upfeedback') {
    $data = updatefeedback($_POST['feedback'],$_POST['c']);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
}


if ($_GET['action'] == 'getfeedback') {
    $data = get_feedback($_POST['c']);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
}
