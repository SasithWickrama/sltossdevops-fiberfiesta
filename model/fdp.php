<?php

function get_fdplist($lat, $lon,$area){ 
    global $conn; 
        $sql = "SELECT DISTINCT x.LOCN_TTNAME LOCATION,X.FRAC_DESCRIPTION EQ_NAME ,x.FRAC_FRAN_NAME TYPE , x.LOCN_X ,   x.LOCN_Y ,   x.DISTANCE  
        ,x.FRAC_INDEX EQ_INDEX,x.LOCN_AREA_CODE LEA,x.FRAC_STATUS STATUS
FROM FRAME_CONTAINERS FC, FRAME_UNITS FU, (
                  SELECT * FROM (SELECT D.RTOM_CODE   ,  LOCN_TTNAME  , LOCN_X ,   LOCN_Y  , FC.FRAC_DESCRIPTION,FC.FRAC_FRAN_NAME,  FC.FRAC_INDEX  ,LOCN_AREA_CODE ,
                   ROUND(((ACOS(SIN( :lat * (22/7) / 180) * SIN(A.LOCN_X * (22/7) / 180) + COS(:lat * (22/7) / 180) * COS(A.LOCN_X * (22/7) / 180) * COS((:lon - A.LOCN_Y) * (22/7) / 180)) * 180 / (22/7)) * 60 * 1.1515 * 1.609344)*1000 ,3)
                     AS DISTANCE ,FRAC_STATUS
                 FROM CLARITY.LOCATIONS A , CLARITY.FRAME_CONTAINERS FC,  OSSRPT.SLT_AREA D 
                 WHERE  LOCN_X IS NOT NULL
                AND FC.FRAC_FRAN_NAME = 'FDP'
                AND FC.FRAC_LOCN_TTNAME = LOCN_TTNAME
                AND LOCN_AREA_CODE = D.LEA_CODE
                AND D.RTOM_CODE =  :area
                AND FRAC_STATUS IN ('PLANNED','INSERVICE')
                AND ROUND(((ACOS(SIN( :lat * (22/7) / 180) * SIN(A.LOCN_X * (22/7) / 180) + COS(:lat * (22/7) / 180) * COS(A.LOCN_X * (22/7) / 180) * COS((:lon - A.LOCN_Y) * (22/7) / 180)) * 180 / (22/7)) * 60 * 1.1515 * 1.609344)*1000 ,3) < 800
                ORDER BY DISTANCE ASC) WHERE ROWNUM <= 4
                ) X
WHERE  FC.FRAC_FRAN_NAME = 'FDP'  
AND FU.FRAU_FRAC_ID = FC.FRAC_ID
AND FC.FRAC_LOCN_TTNAME =LOCN_TTNAME";
        $statment = $conn->prepare($sql);
        $statment->bindValue(':lat',$lat);
        $statment->bindValue(':lon',$lon);
        $statment->bindValue(':area',$area);
        $statment->execute();
        $cctdetails = $statment->fetchAll();
        $statment->closeCursor();
        return $cctdetails;    
}



function get_fdplist1($lat, $lon,$area){ 
    global $conn; 
        $sql = "SELECT * FROM (SELECT   LOCATION ,   
        ROUND(((ACOS(SIN( :lat * (22/7) / 180) * SIN(A.LOCN_X * (22/7) / 180) + COS(:lat * (22/7) / 180) * COS(A.LOCN_X * (22/7) / 180) * COS((:lon - A.LOCN_Y) * (22/7) / 180)) * 180 / (22/7)) * 60 * 1.1515 * 1.609344)*1000 ,3)
          AS DISTANCE 
      FROM FF_DP A
      WHERE  LOCN_X IS NOT NULL
                AND D.RTOM_CODE =  :area
     AND ROUND(((ACOS(SIN( :lat * (22/7) / 180) * SIN(A.LOCN_X * (22/7) / 180) + COS(:lat * (22/7) / 180) * COS(A.LOCN_X * (22/7) / 180) * COS((:lon - A.LOCN_Y) * (22/7) / 180)) * 180 / (22/7)) * 60 * 1.1515 * 1.609344)*1000 ,3) < 800
     ORDER BY DISTANCE ASC) WHERE ROWNUM <= 4";
        $statment = $conn->prepare($sql);
        $statment->bindValue(':lat',$lat);
        $statment->bindValue(':lon',$lon);
        $statment->bindValue(':area',$area);
        $statment->execute();
        $cctdetails = $statment->fetchAll();
        $statment->closeCursor();
        return $cctdetails;    
}

function get_service($no){ 
    global $conn; 
    //if(strcmp(substr($no,0,3),"091") != 0){
    //    $cctdetails = "error";
   // }else{
        $sql = "SELECT X.CIRT_ACCT_NUMBER, X.CIRT_CUSR_ABBREVIATION,X.CIRT_DISPLAYNAME ,X.CIRT_SERT_ABBREVIATION, X.CIRT_STATUS 
        FROM CIRCUITS C , CIRCUITS X
        WHERE C.CIRT_DISPLAYNAME = :tp
        AND C.CIRT_STATUS IN ('INSERVICE','SUSPENDED')
        AND X.CIRT_ACCT_NUMBER = C.CIRT_ACCT_NUMBER
        AND X.CIRT_CUSR_ABBREVIATION = C.CIRT_CUSR_ABBREVIATION
        AND X.CIRT_STATUS IN ('INSERVICE','SUSPENDED')
        AND X.CIRT_SERT_ABBREVIATION NOT LIKE 'AB-%'";
        $statment = $conn->prepare($sql);
        $statment->bindValue(':tp',$no);
        $statment->execute();
        $cctdetails = $statment->fetchAll();
        $statment->closeCursor();
   // }
        return $cctdetails;    
}