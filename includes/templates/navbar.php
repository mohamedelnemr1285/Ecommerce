
<div class="upper-bar">
<div class="container">
<?php 
if(isset($_SESSION['user'])){
  ?>
 
  <div class="my-info">
   <img class="rounded-circle" src="layout/images/love-birds.png"/>
  
  <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  <?php echo ucwords($_SESSION['user']); ?>  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="profile.php">My Profile</a>
    <a class="dropdown-item" href="logout.php">Logout</a>
    <a class="dropdown-item" href="newad.php">New Ads</a>
  </div>
</div>
</div>

 <?php
 $status = checkuserstatus($_SESSION['user']);
 if($status == 1){
   // gh
 }

}else{
?>
   <a href="login.php" class="pull-right">
  <span>Login | SignIn</span>
  </a>
 <?php } ?>
  </div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
  <div class="container">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ">
      <li class="nav-item active">
        <a class="navbar-brand" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
         
      </ul>
      <ul class="drrop navbar-nav ml-auto">
      <?php 
       $stmt2 = $con->prepare("SELECT * FROM categories Where parent = 0 ORDER BY id ASC");
       $stmt2->execute();
       $cats = $stmt2->fetchAll();
      foreach($cats as $cat){
      echo  '<li class="nav-item">';
      echo   '<a class="nav-link" href="categories.php?catid='.$cat['id'].'&name='.$cat['name'] .'">'.$cat['name'].'</a>';
      echo '</li>';
          }
      ?>
    </ul>
      </div>
      </div>
</nav>