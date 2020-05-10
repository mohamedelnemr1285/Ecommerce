<?php

ob_start();
session_start();
$pagetitle = '';

if(isset($_SESSION['login'])){

    include 'init.php';
    include $tpl .'header.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';

    if($do == 'mange'){
        echo 'mange';
    }elseif($do == 'add'){

    }elseif($do == 'insert'){

    }elseif($do == 'edit'){

    }elseif($do == 'update'){

    }elseif($do == 'delete'){
        
    }

    include $tpl.'footer.php';

}else{
    header('location:index.php');
    exit();
}

ob_end_flush();

?>