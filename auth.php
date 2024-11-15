<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
session_start();
require('model/database.php');


echo '<script type="text/javascript"> showLoading();</script>';

$uname = $_POST['uname']."@intranet.slt.com.lk";
$pwd = $_POST['pwd'];
$user_name =$_POST['uname'];


if($_POST['uname'] === ""){
	echo "<script type='text/javascript'>alert('UserName Cannot be Empty')</script>";
	echo '<script type="text/javascript"> document.location = "login.html?id='.$_POST['androidid'].'&version=2";</script>';
}
if($_POST['pwd'] === ""){
	echo "<script type='text/javascript'>alert('Password Cannot be Empty')</script>";
	echo '<script type="text/javascript"> document.location = "login.html?id='.$_POST['androidid'].'&version=2";</script>';
}
if(strpos($_POST['appv'],"2") != 0){
	echo "<script type='text/javascript'>alert('Please Download New App to Continue')</script>";
	echo '<script type="text/javascript"> document.location = "login.html";</script>';
}

 if(strpos($_POST['uname'],"TFS0166")!== false || strpos($_POST['uname'],"TFS017306")!== false || strpos($_POST['uname'],"TFS002156")!== false){
	
	$sql = "select USR_ID  ,USR_NAME , AREA ,LEADER, PWD ,DEVICEID from FF_APP_USERS where USR_ID = '".$_POST['uname']."' ";			
	$statment = $conn->prepare($sql);
	$statment->execute();
	$userdetails = $statment->fetchAll();
	$statment->closeCursor();

	foreach ($userdetails as $cr) : 
		if(strcmp($cr["DEVICEID"] , $_POST['androidid']) != 0 && strcmp($cr["DEVICEID"] , "") != 0){		
			echo "<script type='text/javascript'>alert('Cannot use same username form diffrent devices. Please contact SLT support')</script>";
	  		echo '<script type="text/javascript"> document.location = "login.html?id='.$_POST['androidid'].'&version=2";</script>';
		}else{
			if(strcmp($cr["PWD"] , $_POST['pwd']) == 0 ){		

				$sql = "UPDATE FF_APP_USERS SET DEVICEID = '".$_POST['androidid']."' , LOG_COUNT = LOG_COUNT+1 where USR_ID = '".$_POST['uname']."' ";			
				$statment = $conn->prepare($sql);
				$statment->execute();

				$_SESSION['usrname']= $cr["USR_NAME"];
				$_SESSION['logedin'] = true;
				$_SESSION['app'] = "miapp";
				$_SESSION['sid']= $_POST['uname'];
				$_SESSION['area']= $cr["AREA"];
				$_SESSION['leader']= $cr["LEADER"];
				echo '<script type="text/javascript"> document.location = "index.php";</script>';     
			
			}else
			{
			echo "<script type='text/javascript'>alert('Not Authorize for this App x')</script>";
			echo '<script type="text/javascript"> document.location = "login.html?id='.$_POST['androidid'].'&version=2";</script>';
			}
}			
endforeach;
}

$link = ldap_connect( 'intranet.slt.com.lk' );
if( ! $link )
{
	
    echo "<script type='text/javascript'>alert('Cant connnect to LDAP Server')</script>";
	echo '<script type="text/javascript"> document.location = "login.html?id='.$_POST['androidid'].'&version=2";</script>';
}
ldap_set_option($link, LDAP_OPT_REFERRALS, 0); 
ldap_set_option( $link, LDAP_OPT_PROTOCOL_VERSION, 3 ); 
if (  ldap_bind( $link, $uname, $pwd ) )
{
	$ldap_base_dn = 'DC=intranet,DC=slt,DC=com,DC=lk';
	$filter = '(sAMAccountName='.$user_name.')';
    $attributes = array("name", "telephonenumber", "mail", "samaccountname","thumbnailphoto","sn");
    $result = ldap_search($link, $ldap_base_dn, $filter, $attributes);
	
	if (FALSE !== $result){		
		$entries = ldap_get_entries($link, $result);
		for ($x=0; $x<$entries['count']; $x++){
			$ldap_img = "";
  
            if (!empty($entries[$x]['thumbnailphoto'][0])) {
                $ldap_img = $entries[$x]["thumbnailphoto"][0];
            } 			 
            $_SESSION['ldap_img']= $ldap_img;
		
		}		 	 
	}
	

	$sql = "select USR_ID  ,USR_NAME , AREA ,LEADER ,DEVICEID from FF_APP_USERS where USR_ID = '".$_POST['uname']."' ";			
	$statment = $conn->prepare($sql);
	$statment->execute();
	$userdetails = $statment->fetchAll();
	$statment->closeCursor();

	if (count($userdetails) > 0) {

		//var_dump($userdetails);
	foreach ($userdetails as $cr) : 
		if(strcmp($cr["DEVICEID"] , $_POST['androidid']) != 0 && strcmp($cr["DEVICEID"] , "") != 0){		
			echo "<script type='text/javascript'>alert('Cannot use same username for diffrent devices. Please contact SLT support')</script>";
	  		echo '<script type="text/javascript"> document.location = "login.html?id='.$_POST['androidid'].'&version=2";</script>';
		}else{
		if($cr["USR_ID"] == $_POST['uname'] ){			  
					 
			$sql = "UPDATE FF_APP_USERS SET DEVICEID = '".$_POST['androidid']."' , LOG_COUNT = LOG_COUNT+1 where USR_ID = '".$_POST['uname']."' ";			
				$statment = $conn->prepare($sql);
				$statment->execute();
					  
						$_SESSION['usrname']= $cr["USR_NAME"];
        				$_SESSION['logedin'] = true;
        				$_SESSION['app'] = "miapp";
						$_SESSION['sid']= $_POST['uname'];
						$_SESSION['area']= $cr["AREA"];
						$_SESSION['leader']= $cr["LEADER"];
						echo '<script type="text/javascript"> document.location = "index.php";</script>';     
					  
					}else
					{
					  echo "<script type='text/javascript'>alert('Not Authorize for this App')</script>";
					  echo '<script type="text/javascript"> document.location = "login.html?id='.$_POST['androidid'].'&version=2";</script>';
					}		
				}	  
	endforeach;
}else{
	echo "<script type='text/javascript'>alert('Not Authorize for this App')</script>";
	echo '<script type="text/javascript"> document.location = "login.html?id='.$_POST['androidid'].'&version=2";</script>';
					
}
	

}else{
		echo "<script type='text/javascript'>alert('Invalid User Name or Password')</script>";
		echo '<script type="text/javascript"> document.location = "login.html?id='.$_POST['androidid'].'&version=2";</script>';
}


?>


<script>
	    function showLoading() {
    //  Android.showloading();
    }

    function hideLoading() {
    //  Android.hideloading();
    }
</script>