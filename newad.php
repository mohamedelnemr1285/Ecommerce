<?php 

session_start();
ob_start();

$pagetitle = 'Create New Item';

include('init.php');

include $tpl .'header.php';

if(isset($_SESSION['user'])){

  $userinfo = $con->prepare("SELECT * FROM users WHERE username = ?");
  $userinfo->execute(array($_SESSION['user']));
  $info = $userinfo->fetch();

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $item = filter_var($_POST['item'],FILTER_SANITIZE_STRING);
      $desc = filter_var($_POST['desc'],FILTER_SANITIZE_STRING);
      $price = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
      $country = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
      $status = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
      $category = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);

      $stmt = $con->prepare("INSERT INTO items
                            (name, description, price, date, country_made, status, cat_id, member_id)
                            VALUES(:name, :description, :price, now(), :country_made, :status, :cat_id, :member_id) ");

      $stmt->execute(array(
        'name' => $item,
        'description' => $desc,
        'price' => $price,
        'country_made' => $country,
        'status' => $status,
        'cat_id' => $category,
        'member_id' => $_SESSION['id']

      ));

      if($stmt){
        echo '<div class="success">Insert New Item </div>';
      }

  }

?>


<div class="my-ads newad" id="New Ads">
<div class="container block"> 
    <h1 class="text-center"><?php echo $pagetitle ?></h1>
    <div class="card  text-white bg-secondary">
        <div class="card-header">My ADS</div>
        <div class="container"> 

        <div class="row">

        <div class="col-md-7">

         <!-- Horizontal material form -->
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
    <!-- Grid row -->
    <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-lg-3 col-sm-3 col-form-label font-weight-bold">Item</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
        <input type="text" class="form-control live" data-class=".live-name" name="item" id="inputEmail3MD"  placeholder="Item Name" required="required">
      </div>
    </div>
  </div>
  <!-- Grid row -->
  
   <!-- Grid row -->
   <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-lg-3 col-sm-3 col-form-label font-weight-bold">Description</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
        <input type="text" class="form-control live" data-class=".live-desc" name="desc" id="inputEmail3MD"  placeholder="Description Name" >
      </div>
    </div>
  </div>
  <!-- Grid row -->
  
   <!-- Grid row -->
   <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-lg-3 col-sm-3 col-form-label font-weight-bold">Price</label>
    <div class="col-lg-8 col-sm-10">
      <div class="md-form mt-0">
        <input type="text" class="form-control live" data-class=".live-price" name="price" id="inputEmail3MD"  placeholder="Price" required="required" >
      </div>
    </div>
  </div>
  <!-- Grid row -->

    <!-- Grid row -->
    <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-lg-3 col-sm-3 col-form-label font-weight-bold">Country</label>
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
    <label for="inputEmail3MD" class="col-lg-3 col-sm-3 col-form-label font-weight-bold">Status</label>
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
    <label for="inputEmail3MD" class="col-lg-3 col-sm-3 col-form-label font-weight-bold">Category</label>
    <div class="col-lg-8 col-sm-10">
    <select name="category" class="form-control" required="required">
    <option value="0" >...</option>
    <?php
      $stmt = $con->prepare("SELECT * FROM categories");
      $stmt->execute();
     $cats = $stmt->fetchAll();
      foreach($cats as $cat){
        echo '<option value="'.$cat['id'].'" >'.$cat['name'].'</option>';
      }
      ?>
    </select>
      </div>
      </div>
  <!-- Grid row -->
 

  <!-- Grid row -->
  <div class="form-group form-group-lg">
    <div class="col-sm-4 offset-sm-3">
      <input type="submit" class="btn btn-primary" value="Add Item">
    </div>
  </div>
  <!-- Grid row -->
</form>
</div>
<!-- Horizontal material form -->

        
<div class="col-md-3">
        <div class="card-body live-preview">
           <div class="col-md-3">
            <div class="card" style="width: 18rem;">
            <span class="price-tag">
                $<span class="live-price">price</span>
            </span>
           <img class="card-img-top" src="layout/images/love-birds.png" alt="Card image cap">
           <div class="card-body">
            <h5 class="card-title live-name">name</h5>
           <p class="card-text live-desc">description</p>
          </div>
     </div> 
     </div>
        </div>
     </div>
        </div>
</div>
</div>
</div>
    </div>

<?php
}else{ header('location:login.php');}
include $tpl . 'footer.php';
ob_end_flush();
?>