<?php

function save_userloc($lat, $lon, $usr)
{
    global $conn;

    $sql = "INSERT INTO OSSPRG.FF_USER_LOCATIONS (
        SID, LOG_DATE, LAT, LON) 
     VALUES ( :usr,SYSDATE,:lat,:lon)";
    $statment = $conn->prepare($sql);
    $statment->bindValue(':lat', $lat);
    $statment->bindValue(':lon', $lon);
    $statment->bindValue(':usr', $usr);
    $cctdetails = $statment->execute();
    $statment->closeCursor();

    return $cctdetails;
}
