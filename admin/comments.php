<?php

ob_start();
session_start();
$pagetitle = 'Comments';

if(isset($_SESSION['login'])){

    include 'init.php';
    include $tpl .'header.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'mange';

    if($do == 'mange'){
        $stmt = $con->prepare("SELECT
                                        comments.*,
                                        items.name AS item_name,
                                        users.username
                                FROM
                                        comments
                                INNER JOIN
                                        items
                                    ON
                                        items.id = item_id
                                INNER JOIN
                                        users
                                    ON
                                    users.id = user_id
                                    ORDER BY id  DESC");
$stmt->execute();
$coms = $stmt->fetchall();
?>
<h1 class="text-center">Mange Comments</h1>
<div class="container">

<table class="table table-striped text-center">
<thead class="thead">
<tr>
<th scope="col">#</th>
<th scope="col">Comments</th>
<th scope="col">Item Name</th>
<th scope="col">User Name</th>
<th scope="col">Added Date</th>
<th scope="col">Control</th>

</tr>
</thead>

<tbody>
<?php foreach($coms as $com){
echo "<tr>";

echo "<th scope='row'>". $com['id']."</th>";
echo"<td>".   $com['comment']  ."</td>";
echo"<td>".   $com['item_name']  ."</td>";
echo"<td>".   $com['username']  ."</td>";
echo"<td>".   $com['date']  ."</td>";
echo'<td><a href="comments.php?do=edit&comid='.$com["id"].'" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a>
<a href="comments.php?do=delete&comid='.$com["id"].'" class="btn btn-danger confirm"><i class="fa fa-trash"></i>Delete</a>';

if($com['status'] == 0){
echo'<a href="comments.php?do=approve&comid='.$com["id"].'" class="btn btn-info Activate"><i class="fa fa-check"></i>Approve</a></td>';
}

echo "</tr>";
} ?>

</tbody>

</table>
</div>
   <?php }elseif($do == 'add'){

    }elseif($do == 'insert'){

    }elseif($do == 'edit'){

        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) :0;
        $stmt = $con->prepare('SELECT * FROM comments WHERE id = ?');
        $stmt->execute(array($comid));
        $com = $stmt->fetch();
        $count = $stmt->rowcount();
        if($count > 0){?>
                        
        <h1 class="text-center">Edit Comments</h1>
    
    <div class="members container">
    
          <!-- Horizontal material form -->
    <form action="?do=update" method="POST">
    <!-- Grid row -->
    <input type="hidden" name="id" value="<?php echo $comid ?>">
    <div class="form-group row">
        <!-- Material input -->
        <label for="inputEmail3MD" class="col-sm-2 col-form-label font-weight-bold">Comments</label>
        <div class="col-sm-10 col-lg-8">
          <div class="md-form mt-0">
            <textarea class="form-control" name="comment" id="inputEmail3MD" placeholder="Comment" required="required"><?php echo $com['comment'] ?></textarea>
          </div>
        </div>
      </div>
      <!-- Grid row -->
      
      <!-- Grid row -->
      <div class="form-group">
        <div class="col-sm-2 offset-sm-0">
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

    }elseif($do == 'update'){

        echo "<h1 class='text-center'>Update Comments</h1>";
        echo "<div class='container'>";
    
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
          $id = $_POST['id'];
          $comment = $_POST['comment'];
         
          $errors = [];
         
          if(empty($comment)){
            $errors[] = 'comment cant be <strong>empty</strong>';
          }
          
          foreach($errors as $error){
            echo '<div class ="alert alert-danger">' . $error. ' </div';
          }
    
          if(empty($errors)){
    
            $stmt = $con->prepare('UPDATE comments SET comment = ?  WHERE id = ?');
            $stmt->execute(array($comment,$id));
    
            $msg = '<div class ="alert alert-success">' .$stmt->rowcount() . " update" .'</div>';
            redirecthome($msg,'back',6);
          }
               
        }else{
            $msg = "<div class='alert alert-danger'>Sorry You Can't Browse Directly</div>";
            redirecthome($msg,'back');
            echo'</div>';
           }

    }elseif($do == 'delete'){

        echo "<h1 class='text-center'>Delete Comment</h1>";
        echo "<div class='container'>";

   $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) :0;
   $check = checkitem('id','comments',$comid);
   if($check > 0){

       $stmt = $con->prepare('DELETE FROM comments WHERE id = :id');
       $stmt->bindparam('id',$comid);
       $stmt->execute();

       $msg = "<div class='alert alert-danger'>".$stmt->rowcount() . ' Comment Deleted' ."</div>";
       redirecthome($msg);

   }else{
       
       $msg = "<div class='alert alert-danger'>This Id Is NOt Exist</div>";
       redirecthome($msg);
   }
   
   echo'</div>';
        
    } elseif($do == 'approve'){
        
        echo'<h1 class="text-center">Approved Comments</h1>';

        echo'<div class="member container">';
  
   $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) :0;
    
    $check = checkitem('id','comments',$comid);
   
    if($check > 0){
       
        $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE id = ?");
        
        $stmt->execute(array($comid));

        $msg = "<div class='alert alert-success'>".$stmt->rowcount() . ' Comment Approved' ."</div>";
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