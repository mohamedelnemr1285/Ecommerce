<?php
session_start();
ob_start();

$pagetitle = 'Login';

if(isset($_SESSION['user'])){
    header('location:index.php');
}
include('init.php');
include $tpl .'header.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['login'])){
    $user = $_POST['username'];
    $password = $_POST['password'];
    $sha = sha1($password);

$stmt = $con->prepare("SELECT
                            id, username, password
                         FROM
                             users
                         WHERE
                          username = ? AND password = ?");
$stmt->execute(array($user,$sha));
$get = $stmt->fetch();
$count = $stmt->rowCount();
if($count > 0){
    $_SESSION['user'] = $user;
    $_SESSION['id'] = $get['id'];
    header('location:profile.php');
    exit();
}
}else { 
    
    
    $errors = array();

  //  $fullname = '';
    $username = $_POST['username'];
    if(isset($_POST['fullname'])){
        $fullname = $_POST['fullname'];
    }
    
    $password1 = $_POST['password'];
    $email = $_POST['email'];


    if(isset($_POST['username'])){
        $filter = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
        if(strlen($filter) < 4){
            $errors[] = 'Username Must Be Larger Than 4 Chracter';
        }
    }

  
    if(isset($_POST['password']) && isset($_POST['password2'])){
        if(empty($_POST['password'])){

            $errors[] = 'Password Is Empty';
        }
        $pass = sha1($_POST['password']);
        $pass2 = sha1($_POST['password2']);
        if($pass !== $pass2){

            $errors[] = 'Sorry Password Is Not Match';
        }
    }

    if(isset($_POST['email'])){
        $filteremail = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        if(filter_var($filteremail,FILTER_VALIDATE_EMAIL) != true){
            $errors[] = 'Email Not Valid';
        }
    }

    
    if(empty($errors)){

    
        $check =  checkitem('username','users',$username);
         if($check == 1){
     
           $error =  'Sorry This Name Already Exist';
           echo '<div class ="alert alert-danger">' . $error. ' </div>';
           
         }else{
     
             $stmt = $con->prepare("INSERT INTO users (username,email, fullname, password,regstatus ,date)
                                   VALUES (:username,:email,:fullname,:password,0,now() ) ");
             $stmt->execute(array(
               'username' => $username,
               'email' => $email,
               'fullname' => $fullname,
               'password' => sha1($password1) 
             ));

             echo '<div class ="alert alert-success">' .$stmt->rowcount() . " SighnIn Success " .'</div>';
           }
     
     
       }
            
     }
               


}


?>

<div class="container login-page">
     <h1 class="text-center">
        <span class="active" data-class="login">Login</span> | <span data-class="signin">SignIn</span>
    </h1>
    <form class="login" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="members">
        <input type="text" name="username" class="form-control" placeholder="Type Your Username" required="required">
        </div>
       
        <div class="members">
     <input type="password" name="password" class="form-control" placeholder="Type Your Password" required="required">
        </div>

    <input type="submit" name="login" class="btn btn-primary btn-block" value="Login">
</form>





    <form class="signin" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
    
    <div class="members">
    <input type="text" name="username" class="form-control" placeholder="Type Your Username" required="required">
     </div>

     <div class="members">
    <input type="text" name="fullname" class="form-control" placeholder="Type Your Full Name">
     </div>

     <div class="members">
    <input type="password" name="password" class="form-control" placeholder="Type Your Password" required="required">
    </div>

    <div class="members">
    <input type="password" name="password2" class="form-control" placeholder="Type Your Password Agin" required="required">
    </div>

    <div class="members">
    <input type="email" name="email" class="form-control" placeholder="Type Your Email" required="required">
    </div>
     <input type="submit" name="signin" class="btn btn-success btn-block"  value="Signin">
    </form>

    <div class="error">
    <?php 
    if(!empty($errors)){

        foreach($errors as $error){
            echo '<div class="msg">'.$error.'</div>';
        } 
    }
    
     ?>
</div>
</div>



<?php
include $tpl . 'footer.php';
ob_end_flush();
?>