<?php


$connstring = '(DESCRIPTION =
(ADDRESS_LIST =
(ADDRESS = (PROTOCOL = TCP)(HOST = 172.25.1.172)(PORT = 1521))
)
(CONNECT_DATA = (SID=clty))
)';
$user = 'ossprg';
$pass = 'prgoss456';

  

try{
    $conn = new PDO("oci:dbname=" . $connstring, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
    
}catch (PDOException $e){
    $error = "Database Error: ".$e->getMessage();
    echo "<script>alert('DB Error!'); </script>";
   // include('view/error.php');
  //  exit();
}



