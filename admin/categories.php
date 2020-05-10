<?php

ob_start();
session_start();
$pagetitle = 'Categories';

if(isset($_SESSION['login'])){

    include 'init.php';
    include $tpl .'header.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';

    if($do == 'mange'){

      $sort = '';
      $sort_array = array('ASC','DESC');
      if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
        $sort = $_GET['sort'];

      }

      $stmt = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY ordering $sort");
      $stmt->execute();
      $cats = $stmt->fetchAll(); ?>

      <div class="container categories">
        <div class="row">
<div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">Mange Categories 
                <div class="sort pull-right">
                Ordering : [
                <a class="<?php if($sort == 'ASC' ) {echo 'Activate';}  ?>" href="?sort=ASC">Asc</a> |
                <a class="<?php if($sort == 'DESC'){echo 'Activate';} ?>" href="?sort=DESC">Desc</a> ]
                View : [
                <span data-view="full" class="Activate">Full</span> |
                <span data-view="classic">Classic</span> ]
              </div>
                </div>
                <div class="card-body">
                  <?php 
                  foreach($cats as $cat){
                    
                    echo '<div class="cat">';
                    echo '<div class="button-hidden">';
                    echo '<a href="?do=edit&catid= '.$cat["id"].'" class="btn btn-outline-success btn-sm"><i class="fa fa-edit"></i>Edit</a>';
                    echo '<a href="?do=delete&catid='.$cat["id"].'" class="btn btn-outline-danger btn-sm confirm"><i class="fa fa-trash"></i>Delete</a>';
                    echo '</div>';
                    echo '<h3 class="card-text">'.$cat["name"].'</h3>';
                    echo '<div class = "full-view">';
                    echo '<p class="card-text">'.$cat["description"].'</p>';
                    echo '</div>';
                    echo '</div>';
                    
                    
              
                    $stmtx = $con->prepare("SELECT * FROM categories WHERE parent = $cat[id]");
                    $stmtx->execute();
                    $children = $stmtx->fetchAll();
                    $row = $stmtx->rowCount();

                    if(! empty($row)){
                        echo "<h6 class='child'>Children Categories</h6>";
                      foreach($children as $child){
                        echo '<ul class="list-unstyled children">';
                         echo '<li><a class="edit-child" href="?do=edit&catid='.$child["id"].'">'.$child["name"].'</a>
                          <a class="delete confirm" href="?do=delete&catid='.$child["id"].'">Delete</a></li>';
                         echo '</ul>';
                    }
                  }
                  echo '  <hr>';
                  }
                 
                 ?>

                </div>
             </div>
           </div>
        </div>
        <a href="?do=add" class="add btn btn-primary col-md-3 offset-md-2"><i class="fa fa-plus"></i>Add New Category </a>

        </div>


<?php
}elseif($do == 'add'){?>

<h1 class="text-center">Add New Category</h1>

<div class="container">

      <!-- Horizontal material form -->
<form action="?do=insert" method="POST">
<!-- Grid row -->
<div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Category</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
        <input type="text" class="form-control" name="category" id="inputEmail3MD"  placeholder="Category Name" required="required">
      </div>
    </div>
  </div>
  <!-- Grid row -->
  <!-- Grid row -->
<div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Parent</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
        <select name="parent">
          <option value="0">None</option>
          <?php
            $stmt = $con->prepare('SELECT * FROM categories WHERE parent = 0 ORDER BY id ASC');
            $stmt->execute();
            $cats = $stmt->fetchAll();
            foreach($cats as $cat){
                echo "<option value='.$cat[id].'>$cat[name]</option>";
            }
          ?>
        </select>

      </div>
    </div>
  </div>
  <!-- Grid row -->
  <!-- Grid row -->
  <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-sm-2 col-form-label font-weight-bold">Description</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
        <input type="text" class="form-control" name="desc" id="inputEmail3MD"  placeholder="description" >
      </div>
    </div>
  </div>
  <!-- Grid row -->

  <!-- Grid row -->
  <div class="form-group row">
    <!-- Material input -->
    <label for="inputPassword3MD" class="col-sm-2 col-form-label font-weight-bold">Oredering</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
          <input type="text" class="password form-control" name="oreder" id="inputPassword3MD" placeholder="oredering">
        </div>
    </div>
  </div>
  <!-- Grid row -->
  <!-- Grid row -->
  <div class="form-group row">
    <!-- Material input -->
    <label for="inputPassword3MD" class="col-sm-2 col-form-label font-weight-bold">Visibility</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
          <div>
        <input type="radio"  name="visib" id="visib-yes" value="0" checked>
        <label for="visib-yes">YES</label>
        </div>
        <div>
        <input type="radio"  name="visib" id="visib-no" value="1">
        <label for="visib-no">No</label>
        </div>
      </div>
    </div>
  </div>
  <!-- Grid row -->

   <!-- Grid row -->
   <div class="form-group row">
    <!-- Material input -->
    <label for="inputPassword3MD" class="col-sm-2 col-form-label font-weight-bold">Allow Commitment</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
          <div>
        <input type="radio"  name="com" id="com-yes" value="0" checked>
        <label for="com-yes">YES</label>
        </div>
        <div>
        <input type="radio"  name="com" id="com-no" value="1">
        <label for="com-no">No</label>
        </div>
      </div>
    </div>
  </div>
  <!-- Grid row -->

 <!-- Grid row -->
 <div class="form-group row">
    <!-- Material input -->
    <label for="inputPassword3MD" class="col-sm-2 col-form-label font-weight-bold">Allow ADS</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
          <div>
        <input type="radio"  name="ads" id="ads-yes" value="0" checked>
        <label for="ads-yes">YES</label>
        </div>
        <div>
        <input type="radio"  name="ads" id="ads-no" value="1">
        <label for="ads-no">No</label>
        </div>
      </div>
    </div>
  </div>
  <!-- Grid row -->

  <!-- Grid row -->
  <div class="form-group form-group-lg">
    <div class="col-md-3 offset-md-2">
      <input type="submit" class="btn btn-primary" value="Add Category">
    </div>
  </div>
  <!-- Grid row -->
</form>
</div>
<!-- Horizontal material form -->

        <?php
    }elseif($do == 'insert'){

      echo "<h1 class='text-center'>Insert New Category</h1>";
      echo "<div class='container'>";
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
     
      $name     = $_POST['category'];
      $parent  = $_POST['parent'];
      $desc    = $_POST['desc'];
      $oreder  = $_POST['oreder'];
      $visib   = $_POST['visib'];
      $com     = $_POST['com'];
      $ads     = $_POST['ads'];
         
        
       $check =  checkitem('name','categories',$name);
        if($check == 1){
    
          $error =  'Sorry This Name Already Exist';
          $msg = '<div class ="alert alert-danger">' . $error. ' </div>';
          redirecthome($msg,'back',3);
          
        }else{
    
            $stmt = $con->prepare("INSERT INTO categories (name, parent, description, ordering, visibility, allow_comment ,allow_ads)
                                  VALUES ( ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute(array(
               $name,
               $parent, 
               $desc,
               $oreder,
               $visib,
               $com,
               $ads

            ));
            $msg = '<div class ="alert alert-success">' .$stmt->rowcount() . " Insert" .'</div>';
            redirecthome($msg,'back');
          }
                      
    }else{
    
      $msg = "<div class='alert alert-danger'>Sorry You Can't Browse Directly</div>";
      redirecthome($msg,'back',6);
     
    }
    echo '</div>';

    }elseif($do == 'edit'){


      $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) :0;
      $stmt = $con->prepare('SELECT * FROM categories WHERE id = ?');
      $stmt->execute(array($catid));
      $cats = $stmt->fetch();
      $count = $stmt->rowcount();
      if($count > 0){?>
                      


      <h1 class="text-center">Edit Category</h1>

<div class="container">

      <!-- Horizontal material form -->
<form action="?do=update" method="POST">
<input type="hidden" name="id" value="<?php echo $catid ?>">

<!-- Grid row -->
<div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Category</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
        <input type="text" class="form-control" name="category" id="inputEmail3MD"  placeholder="Category Name" required="required" value="<?php echo $cats['name'] ?>">
      </div>
    </div>
  </div>
  <!-- Grid row -->

    <!-- Grid row -->
    <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-lg-2 col-sm-2 col-form-label font-weight-bold">Parent</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
        <select name="parent">
          <option value="0">None</option>
          <?php
            
            $stmtx = $con->prepare('SELECT * FROM categories WHERE parent = 0 ORDER BY id ASC');
            $stmtx->execute();
            $allcats = $stmtx->fetchAll();
            foreach($allcats as $c){?>
              
               <option value='<?php echo $c['id'];?>' <?php if($cats['parent'] == $c['id']){echo 'Selected';} ?> ><?php echo $c['name']; ?></option>
              
               <?php
          }
        ?>
        </select>

      </div>
    </div>
  </div>
  <!-- Grid row -->

  <!-- Grid row -->
  <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-sm-2 col-form-label font-weight-bold">Description</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
        <input type="text" class="form-control" name="desc" id="inputEmail3MD"  placeholder="description"  value="<?php echo $cats['description'] ?>">
      </div>
    </div>
  </div>
  <!-- Grid row -->

  <!-- Grid row -->
  <div class="form-group row">
    <!-- Material input -->
    <label for="inputPassword3MD" class="col-sm-2 col-form-label font-weight-bold">Ordering</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
          <input type="text" class="password form-control" name="oreder" id="inputPassword3MD" placeholder="ordering"  value="<?php echo $cats['ordering'] ?>">
        </div>
    </div>
  </div>
  <!-- Grid row -->
  <!-- Grid row -->
  <div class="form-group row">
    <!-- Material input -->
    <label for="inputPassword3MD" class="col-sm-2 col-form-label font-weight-bold">Visibility</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
          <div>
        <input type="radio"  name="visib" id="visib-yes" value="0" <?php if($cats['visibility'] == 0){echo 'checked';} ?> >
        <label for="visib-yes">YES</label>
        </div>
        <div>
        <input type="radio"  name="visib" id="visib-no" value="1"  <?php if($cats['visibility'] == 1){echo 'checked';} ?>>
        <label for="visib-no">No</label>
        </div>
      </div>
    </div>
  </div>
  <!-- Grid row -->

   <!-- Grid row -->
   <div class="form-group row">
    <!-- Material input -->
    <label for="inputPassword3MD" class="col-sm-2 col-form-label font-weight-bold">Allow Commitment</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
          <div>
        <input type="radio"  name="com" id="com-yes" value="0" <?php if($cats['allow_comment'] == 0){echo 'checked';} ?> >
        <label for="com-yes">YES</label>
        </div>
        <div>
        <input type="radio"  name="com" id="com-no" value="1" <?php if($cats['allow_comment'] == 1){echo 'checked';} ?>>
        <label for="com-no">No</label>
        </div>
      </div>
    </div>
  </div>
  <!-- Grid row -->

 <!-- Grid row -->
 <div class="form-group row">
    <!-- Material input -->
    <label for="inputPassword3MD" class="col-sm-2 col-form-label font-weight-bold">Allow ADS</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
          <div>
        <input type="radio"  name="ads" id="ads-yes" value="0" <?php if($cats['allow_ads'] == 0){echo 'checked';} ?> >
        <label for="ads-yes">YES</label>
        </div>
        <div>
        <input type="radio"  name="ads" id="ads-no" value="1" <?php if($cats['allow_ads'] == 1){echo 'checked';} ?>>
        <label for="ads-no">No</label>
        </div>
      </div>
    </div>
  </div>
  <!-- Grid row -->

  <!-- Grid row -->
  <div class="form-group form-group-lg">
    <div class="col-md-3 offset-md-2">
      <input type="submit" class="btn btn-primary" value="Update Category">
    </div>
  </div>
  <!-- Grid row -->
</form>
</div>

     
  <?php
  
  }else{
  
    $msg = "<div class='alert alert-danger'>There Is Not Found ID</div>";
    redirecthome($msg,'back');
  }

    }elseif($do == 'update'){


      echo "<h1 class='text-center'>Update Category</h1>";
    echo "<div class='container'>";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
   
      $id     =  $_POST['id'];
      $name   = $_POST['category'];
      $parent  = $_POST['parent'];
      $desc    = $_POST['desc'];
      $oreder  = $_POST['oreder'];
      $visib   = $_POST['visib'];
      $com     = $_POST['com'];
      $ads     = $_POST['ads'];

      $stmt = $con->prepare('UPDATE
                                   categories
                             SET 
                                    name = ?,
                                    parent = ?,
                                   description = ?,
                                    ordering = ?,
                                     visibility = ?,
                                      allow_comment = ?,
                                       allow_ads = ?
                              WHERE
                               id = ?');
        $stmt->execute(array($name,$parent,$desc,$oreder,$visib,$com,$ads,$id));

        $msg = '<div class ="alert alert-success">' .$stmt->rowcount() . " update" .'</div>';
        redirecthome($msg,'back');
             
    }else{
      $msg = "<div class='alert alert-danger'>Sorry You Can't Browse Directly</div>";
      redirecthome($msg,'back');
     }
    echo'</div>';
    

    }elseif($do == 'delete'){

      echo "<h1 class='text-center'>Delete Category</h1>";
      echo "<div class='container'>";

      $catid =   isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) :0;
      $check = checkitem('id','categories',$catid);
      if($check > 0){
  
          $stmt = $con->prepare('DELETE FROM categories WHERE id = :id');
          $stmt->bindparam('id',$catid);
          $stmt->execute();
  
          $msg = "<div class='alert alert-danger'>".$stmt->rowcount() . ' Category Deleted' ."</div>";
          redirecthome($msg,'back');
  
      }else{
          
          $msg = "<div class='alert alert-danger'>This Id Is NOt Exist</div>";
          redirecthome($msg);
      }

      echo'</div>';

        
    }

    include $tpl.'footer.php';

}else{
    header('location:index.php');
    exit();
}

ob_end_flush();

?>