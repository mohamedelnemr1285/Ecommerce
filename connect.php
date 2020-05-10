<?php 

$server = "mysql:host=localhost;dbname=shop";
//$dbname = 'shop';
$user = 'root';
$pass = '';
$option = array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8');

try {

    $con = new PDO($server,$user,$pass,$option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   //  $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  //  echo 'You Are Connect';
} catch (PDOException $e) {
    die('connection falid : ' . $e->getMessage());


}


?>