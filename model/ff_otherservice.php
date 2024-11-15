<?php

function save_otherservice($ffid, $ffcct)
{
    global $conn;

    $sql = "INSERT INTO OSSPRG.FF_OTHERSV (
        FF_ID, FF_SERVICE) 
     VALUES ( :ffid,   :ffcct )";
    $statment = $conn->prepare($sql);
    $statment->bindValue(':ffid', $ffid);
    $statment->bindValue(':ffcct', $ffcct);
    $cctdetails = $statment->execute();
    $statment->closeCursor();

    return $cctdetails;
}
