<?php 
// FrontEnd

/*
function get latest items from database
*/

function getcat(){

    global $con;

    $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY id ASC");
    $stmt2->execute();
    $row = $stmt2->fetchAll();

    return $row;
}

function getitem($where,$value){

    global $con;

    $stmt2 = $con->prepare("SELECT * FROM items WHERE $where = $value ORDER BY id ASC");
    $stmt2->execute(array($value));
    $row = $stmt2->fetchAll();

    return $row;
}

function checkuserstatus($user){

    global $con;

    $stmt2 = $con->prepare("SELECT username,regstatus FROM users WHERE username = ? AND regstatus = 0");
    $stmt2->execute(array($user));
    $row = $stmt2->rowCount();

    return $row;

}

/*
Insert Title To Any Pages
*/ 
function gettitle(){
    global $pagetitle;
    if(isset($pagetitle)){
        echo $pagetitle;
    } else{ echo 'Defualt';}
}

/*
 Redirect Function [$msg , $seconds]
*/ 
function redirecthome($msg,$url=null,$seconds=3){
    if($url=null){
        $url = 'index.php';
    }else{
        if(isset($_SERVER['HTTP_REFERER']) &&  !empty($_SERVER["HTTP_REFERER"]) ){

            $url = $_SERVER['HTTP_REFERER'];
        }else{
            $url = 'index.php';
        }
    }
    echo $msg;
    echo "<div class='alert alert-info'>You Are Redirected After  $seconds Seconds.</div>";
    header("refresh:$seconds;url=$url");
    exit();

}

/*
Check Function From DataBase Before Insert Data
$select[example : user, category]
$from[example:any table]
$value[example:name of users]
*/ 


function checkitem($filed,$table,$value){

    global $con;
    $stmt1 = $con->prepare("SELECT $filed From $table WHERE $filed = ? ");
    $stmt1->execute(array($value));
    $row = $stmt1->rowCount();
    return $row;

}

/* 
function countitems Count Number Of Rows  In Table

*/


function countitems($item,$table){

    global $con;
    $stmt = $con->prepare("SELECT COUNT($item) FROM $table ");
    $stmt->execute();
    $count =  $stmt->fetchColumn();
    return $count;

}

/*
function get latest items from database
*/

function getlatest($filed,$table,$limit = 5){

    global $con;

    $stmt2 = $con->prepare("SELECT $filed FROM $table ORDER BY id DESC LIMIT $limit");
    $stmt2->execute();
    $row = $stmt2->fetchAll();

    return $row;
}
?>