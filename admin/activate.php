<?php 

session_start();
if(isset($_SESSION['login'])){
    $pagetitle = 'Members';

    include 'init.php';
    include $tpl .'header.php';


    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';

    if($do == 'activate')
    {
        echo'<h1 class="text-center">Activate Member</h1>';

        echo'<div class="member container">';
  
   $userid =   isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;
    
    $check = checkitem('id','users',$userid);
   
    if($check > 0){
       
        $stmt = $con->prepare("UPDATE users SET regstatus = 1 WHERE id = ?");
        
        $stmt->execute(array($userid));

        $msg = "<div class='alert alert-success'>".$stmt->rowcount() . ' User Activate' ."</div>";
        redirecthome($msg);

    }else{
        
        $msg = "<div class='alert alert-danger'>This Id Is Not Exist</div>";
        redirecthome($msg);
    }
    
    echo '</div>';

    }



    include $tpl.'footer.php';
}
?>