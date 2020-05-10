<?php 

ob_start();

session_start();
if(isset($_SESSION['login'])){
    $pagetitle = 'Members';

    include 'init.php';
    include $tpl .'header.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';
   /* $do = '';
    if(isset($_GET['do'])) {
        $_GET['do'];
    }else{$do = 'mange';}  */

    if($do == 'mange')
    {
      $activate = '';
      if(isset($_GET['page']) && $_GET['page'] == 'pending' ){
        $activate = '&& regstatus = 0';
      }
      
      $stmt = $con->prepare("SELECT * FROM users WHERE groubid != 1 $activate");
      $stmt->execute();
      $rows = $stmt->fetchall();
      ?>
       <h1 class="text-center">Mange Member</h1>
       <div class="container">

       <table class="table table-striped text-center">
  <thead class="thead">
    <tr>
      <th scope="col">#</th>
      <th scope="col">UserName</th>
      <th scope="col">Image</th>
      <th scope="col">Email</th>
      <th scope="col">FullName</th>
      <th scope="col">Register Date</th>
      <th scope="col">Control</th>

    </tr>
  </thead>
  
  <tbody>
  <?php foreach($rows as $row){
    echo "<tr>";
      
      echo "<th scope='row'>". $row['id']."</th>";
      echo"<td>".   ucwords($row['username'])  ."</td>";
      echo"<td><img src='upload/".$row['image']."' alt=".$row['image']." width = 50px hight = 50px/></td>";
      echo"<td>".   $row['email']  ."</td>";
      echo"<td>".  ucwords($row['fullname'])  ."</td>";
      echo"<td>".   $row['date']  ."</td>";
      echo'<td><a href="members.php?do=edit&userid='.$row["id"].'" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
      <a href="delete.php?do=delete&userid='.$row["id"].'" class="btn btn-danger confirm"><i class="fa fa-trash"></i>Delete</a>';
    
    if($row['regstatus'] == 0){
      echo'<a href="activate.php?do=activate&userid='.$row["id"].'" class="btn btn-info Activate"></i>Activate</a></td>';
    }
   echo "</tr>";
  } ?>
  
   </tbody>

</table>

<a href="members.php?do=add" class="btn btn-primary"><i class="fa fa-plus" ></i>New Member</a>

       </div>

         
   <?php }elseif($do == 'add'){?>
                <h1 class="text-center">Add New Member</h1>

          <div class="member container">

                <!-- Horizontal material form -->
          <form action="?do=insert" method="POST" enctype="multipart/form-data">
          <!-- Grid row -->
          <div class="form-group row">
              <!-- Material input -->
              <label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">User Name</label>
              <div class="col-lg-8 col-sm-10">
                <div class="md-form mt-0">
                  <input type="text" class="form-control" name="username" id="inputEmail3MD"  placeholder="User Name" required="required">
                </div>
              </div>
            </div>
            <!-- Grid row -->
            <!-- Grid row -->
            <div class="form-group row">
              <!-- Material input -->
              <label for="inputEmail3MD" class="col-sm-2 col-form-label font-weight-bold">Email</label>
              <div class="col-lg-8 col-sm-10">
                <div class="md-form mt-0">
                  <input type="email" class="form-control" name="email" id="inputEmail3MD"  placeholder="Email" required="required">
                </div>
              </div>
            </div>
            <!-- Grid row -->

            <!-- Grid row -->
            <div class="form-group row">
              <!-- Material input -->
              <label for="inputPassword3MD" class="col-sm-2 col-form-label font-weight-bold">Password</label>
              <div class="col-lg-8 col-sm-10">
                <div class="md-form mt-0">
                    <input type="password" class="password form-control" name="password" id="inputPassword3MD" placeholder="Password" autocomplete="new-psssword" required="required">
                    <i class="showpass fa fa-eye" ></i>
                  </div>
              </div>
            </div>
            <!-- Grid row -->
            <!-- Grid row -->
            <div class="form-group row">
              <!-- Material input -->
              <label for="inputPassword3MD" class="col-sm-2 col-form-label font-weight-bold">Full Name</label>
              <div class="col-lg-8 col-sm-10">
                <div class="md-form mt-0">
                  <input type="text" class="form-control" name="fullname" id="inputPassword3MD"  placeholder="Full Name" required="required">
                </div>
              </div>
            </div>
            <!-- Grid row -->

            <!-- Grid row -->
            <div class="form-group row">
             <!-- Material input -->
             <label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">User Image</label>
              <div class="col-lg-8 col-sm-10">
                <div class="md-form mt-0">
                  <input type="file" class="form-control" name="image" id="inputEmail3MD" >
                </div>
              </div>
            </div>
            <!-- Grid row -->

            <!-- Grid row -->
            <div class="form-group row">
              <div class="col-md-3 offset-md-2">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
            <!-- Grid row -->
            <!-- Grid row -->
          <div class="form-group row">
             
          </form>
          </div>
          <!-- Horizontal material form -->

   <?php }elseif($do == 'insert'){

  echo "<h1 class='text-center'>Insert New Members</h1>";
  echo "<div class='container'>";

if($_SERVER['REQUEST_METHOD'] == 'POST'){


 $imagename = $_FILES['image']['name'];
 $imagesize = $_FILES['image']['size'];
 $imagetmp = $_FILES['image']['tmp_name'];
 $imagetype = $_FILES['image']['type'];

 $imageallowed = array("jpg","gif","jpeg","png");
 $explode = explode(".", $imagename); // convert array to string
 $end = end($explode);                // the last elemnt of array
 $imageextaion = strtolower($end);    // convert string to lower alphapet elzero 126
  
  $username = $_POST['username'];
  $email = $_POST['email'];
  $fullname = $_POST['fullname'];
  $password = $_POST['password'];

  $shapassword = sha1($_POST['password']);

 
  $errors = [];

  if(strlen($username) < 3){
    $errors[] = ' username cant be less than <strong>2 charcter</strong>';
  }
  if(empty($username)){
    $errors[] = 'username cant be <strong>empty</strong>';
  }
  if(empty($email)){
    $errors[] = 'email cant be<strong> empty</strong>';
  }
  if(empty($password)){
    $errors[] = 'password cant be<strong> empty</strong>';
  }
  if(empty($fullname)){
    $errors[] = 'fullname cant be <strong>empty</strong>';
  }
  if(! in_array($imageextaion,$imageallowed) && ! empty($imagename)){
    $errors[] = 'This Extantion Its Not<strong>Allowd</strong>';
  }
  if( empty($imagename)){
    $errors[] = 'No Image<strong>Upload</strong>';
  }
  if($imagesize > 4222222){
    $errors[] = 'The Image Cant Be Lager Than<strong>4MB</strong>';
  }
  foreach($errors as $error){
    echo '<div class ="alert alert-danger">' . $error. ' </div>';
  }

  if(empty($errors)){

    $image = rand(0,1000).'_'.$imagename;
    move_uploaded_file($imagetmp,"upload\\".$image);

   $check =  checkitem('username','users',$username);
   if($check == 1){

      $error =  'Sorry This Name Already Exist';
      $msg = '<div class ="alert alert-danger">' . $error. ' </div>';
      redirecthome($msg,'back');
      
    }else{

        $stmt = $con->prepare("INSERT INTO users (username,email, fullname, password,regstatus ,date,image)
                              VALUES (:username,:email,:fullname,:password,1,now(), :image ) ");
        $stmt->execute(array(
          'username' => $username,
          'email' => $email,
          'fullname' => $fullname,
          'password' => $shapassword,
          'image'    => $image
        ));
        $msg = '<div class ="alert alert-success">' .$stmt->rowcount() . " Insert" .'</div>';
        redirecthome($msg,'back');
      } 


  }
       
}else{

  $msg = "<div class='alert alert-danger'>Sorry You Can't Browse Directly</div>";
  redirecthome($msg,'back');
 
} 
echo '</div>'; 
       

}
    elseif($do == 'edit'){
        
     $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) :0;
    $stmt = $con->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute(array($userid));
    $row = $stmt->fetch();
    $count = $stmt->rowcount();
    if($count > 0){?>
                    
    <h1 class="text-center">Edit Members</h1>

<div class="members container">

      <!-- Horizontal material form -->
<form action="?do=update" method="POST" enctype="multipart/form-data">
<!-- Grid row -->
<input type="hidden" name="id" value="<?php echo $userid ?>">
<div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-sm-2 col-form-label font-weight-bold">User Name</label>
    <div class="col-sm-10 col-lg-8">
      <div class="md-form mt-0">
        <input type="text" class="form-control" name="username" id="inputEmail3MD" value="<?php echo $row['username'] ?>" placeholder="User Name" required="required">
      </div>
    </div>
  </div>
  <!-- Grid row -->
  <!-- Grid row -->
  <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-sm-2 col-form-label font-weight-bold">Email</label>
    <div class="col-sm-10 col-lg-8">
      <div class="md-form mt-0">
        <input type="email" class="form-control" name="email" id="inputEmail3MD" value="<?php echo $row['email'] ?>" placeholder="Email" required="required">
      </div>
    </div>
  </div>
  <!-- Grid row -->

  <!-- Grid row -->
  <div class="form-group row">
    <!-- Material input -->
    <label for="inputPassword3MD" class="col-sm-2 col-form-label font-weight-bold">Password</label>
    <div class="col-sm-10 col-lg-8">
      <div class="md-form mt-0">
        <input type="hidden"  name="oldpassword" value="<?php echo $row['password'] ?>">
        <input type="password" class="form-control" name="newpassword" id="inputPassword3MD" placeholder="Password" autocomplete="new-psssword">
      </div>
    </div>
  </div>
  <!-- Grid row -->
  <!-- Grid row -->
  <div class="form-group row">
    <!-- Material input -->
    <label for="inputPassword3MD" class="col-sm-2 col-form-label font-weight-bold">Full Name</label>
    <div class="col-sm-10 col-lg-8">
      <div class="md-form mt-0">
        <input type="text" class="form-control" name="fullname" id="inputPassword3MD" value="<?php echo $row['fullname'] ?>" placeholder="Full Name" required="required">
      </div>
    </div>
  </div>
  <!-- Grid row -->

   <!-- Grid row -->
   <div class="form-group row">
             <!-- Material input -->
             <label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">User Image</label>
              <div class="col-lg-8 col-sm-10">
                <div class="md-form mt-0">
                  <input type="file" class="form-control" name="image"  value="<?php echo $row['image'] ?>" id="inputEmail3MD" >
                </div>
              </div>
            </div>
            <!-- Grid row -->


  <!-- Grid row -->
  <div class="form-group">
    <div class="col-sm-3 offset-sm-0">
      <button type="submit" class="btn btn-primary btn-md">Save</button>
    </div>
  </div>
  <!-- Grid row -->
</form>
</div>
<!-- Horizontal material form -->
<?php

}else{

  $msg = "<div class='alert alert-danger'>There Is Not Found ID</div>";
  redirecthome($msg,'back');
}

   } elseif($do = 'update'){

    echo "<h1 class='text-center'>Update Members</h1>";
    echo "<div class='container'>";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
      
   
      $imagename = $_FILES['image']['name'];
      $imagesize = $_FILES['image']['size'];
      $imagetmp = $_FILES['image']['tmp_name'];
      $imagetype = $_FILES['image']['type'];

      $image = rand(0,1000).'_'.$imagename;
       move_uploaded_file($imagetmp,"upload\\".$image);

      $id = $_POST['id'];
      $username = $_POST['username'];
      $email = $_POST['email'];
      $fullname = $_POST['fullname'];

      $password = '';
      if(empty($_POST['newpassword'])){
        $password = $_POST['oldpassword'];
      }else{
        $password =sha1($_POST['newpassword']);
      }

      $errors = [];

      if(strlen($username) < 3){
        $errors[] = ' username cant be less than <strong>2 charcter</strong>';
      }
      if(empty($username)){
        $errors[] = 'username cant be <strong>empty</strong>';
      }
      if(empty($email)){
        $errors[] = 'email cant be<strong> empty</strong>';
      }
      if(empty($fullname)){
        $errors[] = 'fullname cant be <strong>empty</strong>';
      }
      foreach($errors as $error){
        echo '<div class ="alert alert-danger">' . $error. ' </div';
      }

      if(empty($errors)){

        

        $stmt2 = $con->prepare("SELECT * FROM users WHERE username = ? && id != ?");
        $stmt2->execute(array($username,$id));
        $rows = $stmt2->rowCount();

        if($rows == 1){
          $msg = '<div class ="alert alert-danger">Sorry This Name Already Exist</div';
          redirecthome($msg,header('location:members.php?do=mange'));

        }else {

          $stmt = $con->prepare('UPDATE users SET username = ?, email = ?, fullname = ?, password = ?, image = ?  WHERE id = ?');
        $stmt->execute(array($username, $email, $fullname, $password, $image, $id));


        $msg = '<div class ="alert alert-success">' .$stmt->rowcount() . " update" .'</div>';
        redirecthome($msg,header('location:members.php?do=mange') );

        }

        
      }
           
    }
    
}else{
  $msg = "<div class='alert alert-danger'>Sorry You Can't Browse Directly</div>";
  redirecthome($msg,'back');
 }
echo'</div>';

    include $tpl.'footer.php';
}else{
    header('location:index.php');
    exit();
}

ob_end_flush();
?>