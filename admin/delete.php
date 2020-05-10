<?php 

    $pagetitle = 'Members';

    include 'init.php';
    include $tpl .'header.php';


    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';

    if($do == 'delete')
    {
        echo "<h1 class='text-center'>Delete Memeber</h1>";
         echo "<div class='container'>";

    $userid =   isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;
    $check = checkitem('id','users',$userid);
    if($check > 0){

        $stmt = $con->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindparam('id',$userid);
        $stmt->execute();

        $msg = "<div class='alert alert-danger'>".$stmt->rowcount() . ' User Deleted' ."</div>";
        redirecthome($msg);

    }else{
        
        $msg = "<div class='alert alert-danger'>This Id Is NOt Exist</div>";
        redirecthome($msg);
    }
    
    echo'</div>';


    }



    include $tpl.'footer.php';

?>