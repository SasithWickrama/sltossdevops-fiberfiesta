<?php

function save_service($ffid, $ffcct, $ffsat)
{
    global $conn;

    $sql = "INSERT INTO OSSPRG.FF_SERVICES (
            FF_ID, FF_CCT, FF_SATISFACTION) 
         VALUES ( :ffid,   :ffcct,:ffsat )";
    $statment = $conn->prepare($sql);
    $statment->bindValue(':ffid', $ffid);
    $statment->bindValue(':ffcct', $ffcct);
    $statment->bindValue(':ffsat', $ffsat);
    $cctdetails = $statment->execute();
    $statment->closeCursor();

    return $cctdetails;
}
