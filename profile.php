<?php 

session_start();
ob_start();

$pagetitle = 'Profile';

include('init.php');

include $tpl .'header.php';

if(isset($_SESSION['user'])){

  $userinfo = $con->prepare("SELECT * FROM users WHERE username = ?");
  $userinfo->execute(array($_SESSION['user']));
  $info = $userinfo->fetch();

?>

<div class="info">
    <div class="container block">

    <div class="card  text-white bg-info">
  <div class="card-header">My Information</div>
  <div class="card-body">
  <ul class="list-unstyled">

    <li>
    <i class="fa fa-unlock-alt fa-fw"></i>
    <sapn class="span">Name</sapn>  : <?php echo ucwords($info['fullname'])  ?> </li>

    <li class="card-text">
    <i class="fa fa-envelope-o fa-fw"></i>
      <span>Email</span>  : <?php echo $info['email'] ?> </li>
    <li class="card-text">
    <i class="fa fa-calendar fa-fw"></i>
      <span>Date</span>  : <?php echo $info['date'] ?> </li>
    <li class="card-text">
    <i class="fa fa-tags fa-fw"></i>
      <span>Favourate Category</span>  : <?php echo $info['id'] ?> </li>
    </ul>
  </div>
</div>

    </div>
</div>

<div class="my-ads">
    <div class="container block">

    <div class="card  text-white bg-secondary">
  <div class="card-header">My ADS</div>
  <div class="card-body">
    
      <?php 
      if(! empty(getitem('member_id',$info['id']))){
        echo '<div class="row">';
         foreach(getitem('member_id',$info['id']) as $item){            
            echo '<div class="col-sm-6 col-md-4">';
            echo '<div class="card" style="width: 18rem;">';
            echo '<span class="price-tag">$'.$item['price'].'</span>';
           echo '<img class="card-img-top" src="layout/images/love-birds.png" alt="Card image cap">';
           echo '<div class="card-body">';
            echo '<h5 class="card-title"><a href="item.php?itemid='.$item['id'].'">'.$item['name'].'</a></h5>';
            echo '<p class="card-text">'.$item['description'].'</p>';
            echo '<p class="card-text">'.$item['date'].'</p>';

          echo '</div>';
      echo '</div>';  
      echo '</div>';  
    } 
  }else { echo 'No Itemes Found';}
      ?>  </div>
</div>
</div>
    </div>
</div>



<div class="com">
    <div class="container block">

    <div class="card  text-white bg-danger">
  <div class="card-header">My Comments</div>
  <div class="card-body">
    <?php 
    $stmt = $con->prepare("SELECT comment FROM comments WHERE user_id = ?");
    $stmt->execute(array($info['id']));
    $comments = $stmt->fetchAll();
    if(! empty($comments)){

      foreach($comments as $comment){

        echo '<p class="card-text">'.$comment['comment'].'</p>';

      }
    }else { echo 'No Comments Found';}
    ?>
  </div>
</div>

    </div>
</div>

<?php
}else{ header('location:login.php');}
include $tpl . 'footer.php';
ob_end_flush();
?>