<?php
$pagetitle = 'Categories';
include('init.php');
include $tpl .'header.php';
?>

<div class="container">
    <h1 class="text-center"><?php echo $_GET['name'] ?></h1>
    <div class="row">
     <?php
         foreach(getitem('cat_id',$_GET['catid']) as $item){
             
            echo '<div class="col-sm-6 col-md-4">';
            echo '<div class="card" style="width: 18rem;">';
            echo '<span class="price-tag">'.$item['price'].'</span>';
           echo '<img  class="card-img-top" src="layout/images/love-birds.png" alt="Card image cap">';
           echo '<div class="card-body">';
            echo '<h5 class="card-title"><a href="item.php?itemid='.$item['id'].'">'.$item['name'].'</a></h5>';
            echo '<p class="card-text">'.$item['description'].'</p>';
          echo '</div>';
      echo '</div>';  
      echo '</div>';  

    }
    ?>
   </div>
   </div>



<?php include $tpl . 'footer.php'; ?>