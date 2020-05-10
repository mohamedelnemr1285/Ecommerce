<?php
session_start();
$noNavbar = '';
$pagetitle = 'Login';

if(isset($_SESSION['login'])){
    header('location:dashboard.php');
}

include('init.php');
include $tpl .'header.php';


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $sha = sha1($pass);
   
    $stmt = $con->prepare("SELECT 
                                id,username,password
                            FROM 
                                users
                             WHERE
                              username = ?
                            AND 
                            password = ?
                            AND 
                            groubid = 1
                            LIMIT 1 ");
    $stmt->execute(array($user,$pass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    
    if($count > 0){
        $_SESSION['login'] = $user;
        $_SESSION['id'] = $row['id'] ;
        header('location:dashboard.php');

        exit();
    }else{echo 'false';}

}
?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class="text-center">Admin Login</h4>
<input type="text" class="form-control" name="user" placeholder="Username" autocomplete="off"/>
<input type="password" class="form-control" name="pass" placeholder="Password" autocomplete="new-password"/>
<input type="submit" class="btn btn-primary btn-block" name="submit" value="Login"/>

</form>


<?php
include $tpl . 'footer.php';
?>