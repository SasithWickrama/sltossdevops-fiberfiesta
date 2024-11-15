<?php

function save_rec($fflat,$fflon,$ffvoice,$ffcr,$ffacc,$ffmob,$ffcat,$ffuser,$ffdp,$ffcuscat,$ffcom,$ffrtom){ 
    global $conn; 
        $sql = "SELECT FF_SEQ.NEXTVAL SEVAL FROM DUAL";
       // $statment = $conn->prepare($sql);
        $result = $conn->query($sql);
        while ($row = $result->fetch()) {
            $seq = $row['SEVAL'];
        }

        $sql = "INSERT INTO OSSPRG.FF_RECORDS (
            FF_ID, FF_LAT, FF_LON, 
            FF_VOICENO, FF_CR, FF_ACC, 
            FF_MOBILE, FF_CATAGORY, FF_STATUS, 
            FF_STATUSDATE, FF_USER, FF_FDP, FF_CUSCAT , COMMENTS, FF_RTOM) 
         VALUES ( :ffid, :fflat, :fflon ,:ffvoice ,
          :ffcr , :ffacc , '07'||:ffmob , :ffcat ,
          0 , SYSDATE , :ffuser , :ffdp , :ffcuscat, :ffcom, :ffrtom)";
        $statment = $conn->prepare($sql);
        $statment->bindValue(':ffid',$seq);
        $statment->bindValue(':fflat',$fflat);
        $statment->bindValue(':fflon',$fflon);
        $statment->bindValue(':ffvoice',$ffvoice);
        $statment->bindValue(':ffcr',$ffcr);
        $statment->bindValue(':ffacc',$ffacc);
        $statment->bindValue(':ffmob',$ffmob);
        $statment->bindValue(':ffcat',$ffcat);
        $statment->bindValue(':ffuser',$ffuser);
        $statment->bindValue(':ffdp',$ffdp);
        $statment->bindValue(':ffcuscat',$ffcuscat);
        $statment->bindValue(':ffcom',$ffcom);
        $statment->bindValue(':ffrtom',$ffrtom);
        $cctdetails = $statment->execute();
        $statment->closeCursor();

        if(strcmp($ffmob, '') != 0 ){
            $sql = "INSERT INTO slt010563.SMSMSGS1 (
                SEND_TPNO, SEND_MSG, SEND_SUCS, 
                SENT_OWNER, SMS_ID, DATE_INS,SEND_USER) 
             VALUES (
                '07'||:ffmob,
             'You have been just visited by an SLT-Mobitel Officer. Thank you very much for your cooperation. Please do send your feedback on the courtesy of our employee on a scale 1 to 5 where 5 is for the best.Please reply as #CF<space>1-5 Thank you.',
              0,
             '1212',
             :ffmob,
             SYSDATE,'SLTCMS')";
            $statment = $conn->prepare($sql);
            $statment->bindValue(':ffmob',$ffmob);
            $cc = $statment->execute();
            $statment->closeCursor();
    
        }
       

        if($cctdetails){
            return $seq;
        }else{
            return $cctdetails;
        }
            
}


function updatefeedback($fffb,$ffid){
    global $conn; 
    $sql = "Update OSSPRG.FF_RECORDS SET FEEDBACK = :fffb WHERE FF_ID = :ffid  and FEEDBACK is null";
    $statment = $conn->prepare($sql);
    $statment->bindValue(':fffb',$fffb);
    $statment->bindValue(':ffid',$ffid);
    $cctdetails = $statment->execute();
    $statment->closeCursor();
    return true;
}

function get_feedback($ffid){ 
    global $conn; 
        $sql = "SELECT nvl(FEEDBACK,'0') FEEDBACK  from OSSPRG.FF_RECORDS  where  FF_ID = :ffid";
        $statment = $conn->prepare($sql);
        $statment->bindValue(':ffid',$ffid);
        $statment->execute();
        $cctdetails = $statment->fetch();
        $statment->closeCursor();
        return $cctdetails;    
}


function getTeamLoc($uidx){
    global $conn; 
    try{
    $sql = "select * from ( SELECT USR_ID,
    (SELECT  X.LAT  FROM FF_USER_LOCATIONS X WHERE SID = USR_ID  
    AND X.LOG_DATE = (SELECT MAX(Y.LOG_DATE) FROM FF_USER_LOCATIONS Y WHERE Y.SID = X.SID ) ) XLAT,
    (SELECT  X.LON  FROM FF_USER_LOCATIONS X WHERE SID = USR_ID  
    AND X.LOG_DATE = (SELECT MAX(Y.LOG_DATE) FROM FF_USER_LOCATIONS Y WHERE Y.SID = X.SID ) ) XLON,         
    (SELECT (sysdate - MAX(Y.LOG_DATE)) *24 * 60  FROM FF_USER_LOCATIONS Y WHERE Y.SID = USR_ID ) UTIME  
     FROM FF_APP_USERS 
    WHERE  TEAM = (SELECT TEAM FROM FF_APP_USERS WHERE USR_ID = :uidx)) WHERE XLAT IS NOT NULL";
     $statment = $conn->prepare($sql);
     $statment->bindValue(':uidx',$uidx);
     $statment->execute();
     $cctdetails = $statment->fetchAll();
     $statment->closeCursor();
    }catch(Exception $e) {
        $cctdetails = $e->getMessage();
    }
    return $cctdetails;  
}