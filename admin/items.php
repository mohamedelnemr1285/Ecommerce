<?php

ob_start();
session_start();
$pagetitle = 'Items';

if(isset($_SESSION['login'])){

    include 'init.php';
    include $tpl .'header.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';

    if($do == 'mange'){
        
       $stmt = $con->prepare("SELECT
                                 items.*,
                                 categories.name AS cat_name,
                                 users.username 
                             FROM 
                                  items
                            INNER JOIN
                                  categories
                            ON 
                                  categories.id = cat_id
                            INNER JOIN
                                  users
                            ON
                                  users.id = member_id");
      $stmt->execute();
      $items = $stmt->fetchall();
      ?>
       <h1 class="text-center">Mange Items</h1>
       <div class="container">

       <table class="table table-striped text-center">
  <thead class="thead">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Item Name</th>
      <th scope="col">Description </th>
      <th scope="col">Price</th>
      <th scope="col">Register Date</th>
      <th scope="col">Member Name</th>
      <th scope="col">Category</th>
      <th scope="col">Control</th>

    </tr>
  </thead>
  
  <tbody>
  <?php foreach($items as $item){
    echo "<tr>";
      
      echo "<th scope='row'>". $item['id']."</th>";
      echo"<td>".   $item['name']  ."</td>";
      echo"<td>".   $item['description']  ."</td>";
      echo"<td>$".   $item['price']  ."</td>";
      echo"<td>".   $item['date']  ."</td>";
      echo"<td>".   $item['username']  ."</td>";
      echo"<td>".   $item['cat_name']  ."</td>";
      echo'<td><a href="items.php?do=edit&itemid='.$item["id"].'" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
      <a href="items.php?do=delete&itemid='.$item["id"].'" class="btn btn-danger confirm"><i class="fa fa-trash"></i>Delete</a>';
      if($item['approve'] == 0){
        echo'<a href="items.php?do=approve&itemid='.$item["id"].'" class="btn btn-info Activate"><i class="fa fa-check"></i>Approve</a></td>';
      }
    
       echo "</tr>";
  } ?>
  
  
 </tbody>

</table>

<a href="items.php?do=add" class="btn btn-primary"><i class="fa fa-plus" ></i>New Item</a>

       </div>



   <?php }elseif($do == 'add'){?>


        <h1 class="text-center">Add New Item</h1>

    <div class="container">

      <!-- Horizontal material form -->
    <form action="?do=insert" method="POST">
    <!-- Grid row -->
    <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Item</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
        <input type="text" class="form-control" name="item" id="inputEmail3MD"  placeholder="Item Name" required="required">
      </div>
    </div>
  </div>
  <!-- Grid row -->
  
   <!-- Grid row -->
   <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Description</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
        <input type="text" class="form-control" name="desc" id="inputEmail3MD"  placeholder="Description Name" >
      </div>
    </div>
  </div>
  <!-- Grid row -->
  
   <!-- Grid row -->
   <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Price</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
        <input type="text" class="form-control" name="price" id="inputEmail3MD"  placeholder="Price" required="required" >
      </div>
    </div>
  </div>
  <!-- Grid row -->

    <!-- Grid row -->
    <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Country</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
        <input type="text" class="form-control" name="country" id="inputEmail3MD"  placeholder="Country Made" required="required" >
      </div>
    </div>
  </div>
  <!-- Grid row -->

   <!-- Grid row -->
   <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Status</label>
    <div class="col-lg-8 col-sm-10">
    <select name="status" class="form-control" required="required">
        <option value="" >...</option>
        <option value="1" >New</option>
        <option value="2" >Like New</option>
        <option value="3" >Used</option>
        <option value="4" >Old</option>
    </select>
      </div>
      </div>
  <!-- Grid row -->

 <!-- Grid row -->
 <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Member</label>
    <div class="col-lg-8 col-sm-10">
    <select name="member" class="form-control" required="required">
    <option value="0" >...</option>
    <?php
      $stmt = $con->prepare("SELECT * FROM users");
      $stmt->execute();
     $users = $stmt->fetchAll();
      foreach($users as $user){
        echo '<option value="'.$user['id'].'" >'.$user['username'].'</option>';
      }
      ?>
    </select>
      </div>
      </div>
  <!-- Grid row -->

   <!-- Grid row -->
 <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Category</label>
    <div class="col-lg-8 col-sm-10">
    <select name="category" class="form-control" required="required">
    <option value="0" >...</option>
    <?php
      $stmt = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY name ASC");
      $stmt->execute();
     $cats = $stmt->fetchAll();
      foreach($cats as $cat){
        echo '<option value="'.$cat['id'].'" >'.$cat['name'].'</option>';
        $stmt = $con->prepare("SELECT * FROM categories WHERE parent = $cat[id] ORDER BY name ASC");
        $stmt->execute();
        $children = $stmt->fetchAll();
        foreach($children as $child){
          echo '<option value="'.$child['id'].'" > --- '.$child['name'].'</option>';
        }

      }
      ?>
    </select>
      </div>
      </div>
  <!-- Grid row -->
 

  <!-- Grid row -->
  <div class="form-group form-group-lg">
    <div class="col-sm-3 offset-sm-2">
      <input type="submit" class="btn btn-primary" value="Add Item">
    </div>
  </div>
  <!-- Grid row -->
</form>
</div>
<!-- Horizontal material form -->

        <?php


    }elseif($do == 'insert'){

        echo "<h1 class='text-center'>Insert New Item</h1>";
        echo "<div class='container'>";
      
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
      
        $item      = $_POST['item'];
        $desc      = $_POST['desc'];
        $price     = $_POST['price'];
        $country   = $_POST['country'];
        $status    = $_POST['status'];
        $member    = $_POST['member'];
        $category  = $_POST['category'];   
       
        $errors = [];
      
        if(empty($item)){
          $errors[] = 'Item Can Not Be <strong>Emptyr</strong>';
        }
        if(empty($desc)){
          $errors[] = 'Description Can Not Be <strong>Emptyr</strong>';
        }
        if(empty($price)){
          $errors[] = 'Price Can Not Be <strong>Emptyr</strong>';
        }
        if(empty($country)){
          $errors[] = 'Country Can Not Be <strong>Emptyr</strong>';
        }
        if(($status == 0)){
          $errors[] = 'You Must Choose The <strong>Status</strong>';
        }
        if(($member == 0)){
          $errors[] = 'You Must Choose The <strong>Member</strong>';
        }
        if(($category == 0)){
          $errors[] = 'You Must Choose The <strong>Category</strong>';
        }
        foreach($errors as $error){
          $msg = '<div class ="alert alert-danger">' . $error. ' </div>';
          redirecthome($msg,'back');
        }
      
        if(empty($errors)){
      
               
              $stmt = $con->prepare("INSERT INTO items (name, description, price, date, country_made, status, cat_id, member_id)
                                    VALUES (:name, :desc, :price, now(), :made, :status, :cat, :member ) ");
              $stmt->execute(array(
                'name'   => $item,
                'desc'   => $desc,
                'price'  => $price,
                'made'    => $country,
                'status'  => $status,
                'cat'    => $category,
                'member'    => $member


              ));
              $msg = '<div class ="alert alert-success">' .$stmt->rowcount() . " Insert" .'</div>';
              redirecthome($msg,'back',5);
      
        }
             
      }else{
      
        $msg = "<div class='alert alert-danger'>Sorry You Can't Browse Directly</div>";
        redirecthome($msg,'back');
       
      }
      echo '</div>';

    }elseif($do == 'edit'){

      $itemid =   isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :0;
      $stmt = $con->prepare('SELECT * FROM items WHERE id = ?');
      $stmt->execute(array($itemid));
      $item = $stmt->fetch();
      $count = $stmt->rowcount();
      if($count > 0){?>
                      
          <h1 class="text-center">Edit Item</h1>

      <div class="container">

  <!-- Horizontal material form -->
<form action="?do=update" method="POST">

<input type="hidden" name="id" value="<?php echo $itemid ?>">

<!-- Grid row -->
<div class="form-group row">
<!-- Grid row -->

<!-- Material input -->
<label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Item</label>
<div class="col-lg-8 col-sm-10">
  <div class="md-form mt-0">
    <input type="text" class="form-control" value="<?php echo $item['name'] ?>" name="item" id="inputEmail3MD"  placeholder="Item Name" >
  </div>
</div>
</div>
<!-- Grid row -->

<!-- Grid row -->
<div class="form-group row">
<!-- Material input -->
<label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Description</label>
<div class="col-lg-8 col-sm-10">
  <div class="md-form mt-0">
    <input type="text" class="form-control"  value="<?php echo $item['description'] ?>" name="desc" id="inputEmail3MD"  placeholder="Description Name" >
  </div>
</div>
</div>
<!-- Grid row -->

<!-- Grid row -->
<div class="form-group row">
<!-- Material input -->
<label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Price</label>
<div class="col-lg-8 col-sm-10">
  <div class="md-form mt-0">
    <input type="text" class="form-control"  value="<?php echo $item['price'] ?>" name="price" id="inputEmail3MD"  placeholder="Price" required="required" >
  </div>
</div>
</div>
<!-- Grid row -->

<!-- Grid row -->
<div class="form-group row">
<!-- Material input -->
<label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Country</label>
<div class="col-lg-8 col-sm-10">
  <div class="md-form mt-0">
    <input type="text" class="form-control" value="<?php echo $item['country_made'] ?>" name="country" id="inputEmail3MD"  placeholder="Country Made" required="required" >
  </div>
</div>
</div>
<!-- Grid row -->

<!-- Grid row -->
<div class="form-group row">
<!-- Material input -->
<label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Status</label>
<div class="col-lg-8 col-sm-10">
<select name="status" class="form-control" required="required">
    <option value="1" <?php if( $item['status'] == 1){echo 'selected'; } ?> >New</option>
    <option value="2" <?php if( $item['status'] == 2){echo 'selected'; } ?> >Like New</option>
    <option value="3" <?php if( $item['status'] == 3){echo 'selected'; } ?> >Used</option>
    <option value="4" <?php if( $item['status'] == 4){echo 'selected'; } ?> >Old</option>
</select>
  </div>
  </div>
<!-- Grid row -->

<!-- Grid row -->
<div class="form-group row">
<!-- Material input -->
<label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Member</label>
<div class="col-lg-8 col-sm-10">
<select name="member" class="form-control" required="required">
<?php
  $stmt = $con->prepare("SELECT * FROM users");
  $stmt->execute();
 $users = $stmt->fetchAll();
  foreach($users as $user){
    echo '<option value="'.$user['id'].'"';
     if( $item['member_id'] == $user['id']){echo 'selected'; }
      echo '>'.$user['username'].'</option>';
  }
  ?>
</select>
  </div>
  </div>
<!-- Grid row -->

<!-- Grid row -->
<div class="form-group row">
<!-- Material input -->
<label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Category</label>
<div class="col-lg-8 col-sm-10">
<select name="category" class="form-control" required="required">
<?php
  $stmt = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY name ASC");
  $stmt->execute();
  $cats = $stmt->fetchAll();
  foreach($cats as $cat){
    echo '<option value="'.$cat['id'].'"';
     if($item['cat_id'] == $cat['id'] ) { echo 'selected';}
     echo '>'.$cat['name'].'</option>';

     $stmt = $con->prepare("SELECT * FROM categories WHERE parent = $cat[id] ORDER BY name ASC");
     $stmt->execute();
     $children = $stmt->fetchAll();
     foreach($children as $child){
       echo '<option value="'.$child['id'].'"';
       if($child['id'] == $cat['parent']){echo 'selected';}
       echo '>'. '---'. ''.$child['name'].'</option>';
     }
  }
  ?>
</select>
  </div>
  </div>
<!-- Grid row -->


<!-- Grid row -->
<div class="form-group form-group-lg">
<div class="col-sm-3 offset-sm-2">
  <input type="submit" class="btn btn-primary" value="Save">
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

   }elseif($do == 'update'){

    echo "<h1 class='text-center'>Update Items</h1>";
    echo "<div class='container'>";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
   
         $id        = $_POST['id'];
         $item      = $_POST['item'];
        $desc      = $_POST['desc'];
        $price     = $_POST['price'];
        $country   = $_POST['country'];
        $status    = $_POST['status'];
        $category  = $_POST['category'];   
        $member    = $_POST['member'];
      
        $errors = [];
      
        if(empty($item)){
          $errors[] = 'Item Can Not Be <strong>Emptyr</strong>';
        }
        if(empty($desc)){
          $errors[] = 'Description Can Not Be <strong>Emptyr</strong>';
        }
        if(empty($price)){
          $errors[] = 'Price Can Not Be <strong>Emptyr</strong>';
        }
        if(empty($country)){
          $errors[] = 'Country Can Not Be <strong>Emptyr</strong>';
        }
        if(($status == 0)){
          $errors[] = 'You Must Choose The <strong>Status</strong>';
        }
        if(($member == 0)){
          $errors[] = 'You Must Choose The <strong>Member</strong>';
        }
        if(($category == 0)){
          $errors[] = 'You Must Choose The <strong>Category</strong>';
        }
      foreach($errors as $error){
        echo '<div class ="alert alert-danger">' . $error. ' </div';
      }

      if(empty($errors)){

        $stmt = $con->prepare("UPDATE items SET
                                               name  = ?,
                                               description = ?,
                                               price = ?,
                                               country_made = ?,
                                               status = ?,
                                               cat_id = ?,
                                               member_id = ?
                                             WHERE
                                              id = ?");
        $stmt->execute(array($item,$desc,$price,$country,$status,$category,$member,$id));

        $msg = '<div class ="alert alert-success">' .$stmt->rowcount() . " update" .'</div>';
        redirecthome($msg,'back');
      }
           
    
    
}else{
  $msg = "<div class='alert alert-danger'>Sorry You Can't Browse Directly</div>";
  redirecthome($msg,'back');
 }
echo'</div>';

    }elseif($do == 'delete'){

      echo "<h1 class='text-center'>Delete Memeber</h1>";
       echo "<div class='container'>";
      
      $itemid =   isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :0;
      $check = checkitem('id','items',$itemid);
      if($check > 0){
  
          $stmt = $con->prepare('DELETE FROM items WHERE id = :id');
          $stmt->bindparam('id',$itemid);
          $stmt->execute();
  
          $msg = "<div class='alert alert-danger'>".$stmt->rowcount() . ' Item Deleted' ."</div>";
          redirecthome($msg);
  
      }else{
          
          $msg = "<div class='alert alert-danger'>This Id Is Not Exist</div>";
          redirecthome($msg);
          echo'</div>';

      }

    }elseif($do == 'approve'){

      echo'<h1 class="text-center">Approved Item</h1>';

        echo'<div class="member container">';
  
   $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) :0;
    
    $check = checkitem('id','items',$itemid);
   
    if($check > 0){
       
        $stmt = $con->prepare("UPDATE items SET approve = 1 WHERE id = ?");
        
        $stmt->execute(array($itemid));

        $msg = "<div class='alert alert-success'>".$stmt->rowcount() . ' Item Approved' ."</div>";
        redirecthome($msg,'back');

    }else{
        
        $msg = "<div class='alert alert-danger'>This Id Is Not Exist</div>";
        redirecthome($msg);
    }
    
    echo '</div>';
    }

    include $tpl.'footer.php';

}else{
    header('location:index.php');
    exit();
}

ob_end_flush();

?>