<?php 
session_start();
ob_start();

$pagetitle =  'ShowItem';

include('init.php');

include $tpl .'header.php';

$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
$stmt = $con->prepare("SELECT
                             items.*, categories.name As categorie_name, users.username
                        FROM
                             items
                        INNER JOIN
                             categories
                        ON
                        items.cat_id = categories.id
                        INNER JOIN
                                users
                            ON
                            items.member_id = users.id
                         ORDER BY
                            id DESC ");
 $stmt->execute(array($itemid));
 $count = $stmt->rowCount();
 if($count > 0){

    $item = $stmt->fetch();
 }
 
?>
<h1 class="text-center"><?php echo $item['name'] ?></h1>

<div class="container">
<div class="row">
    <div class="col-md-3">
    <img class="rounded-circle" src="layout/images/love-birds.png" alt="Card image cap" style="border: 1px solid black">
    </div>
    <div class="col-md-9 item-info">
        <h2><?php echo $item['name'] ?></h2>
        <p><?php echo $item['description'] ?></p>
        <ul class="list-unstyled">
            <li>
                <i class="fa fa-calendar fa-fw"></i>
                <span>Add Date</span> : <?php echo $item['date'] ?> </li>
            <li>
                <i class="fa fa-money fa-fw"></i>
                <span>Price</span> : <?php echo $item['price'] ?> </li>
            <li>
                <i class="fa fa-building fa-fw"></i>
                <span>Made In</span> : <?php echo $item['country_made'] ?> </li>
            <li>          
                 <i class="fa fa-tags fa-fw"></i>
                <span>Categorie</span> :<a href="categories.php?catid=<?php echo $item['cat_id'] ?>&name=<?php echo $item['categorie_name'] ?>"> <?php echo $item['categorie_name'] ?> </a></li>
            <li>
                <i class="fa fa-user fa-fw"></i>
                <span>Added By</span> : <?php echo $item['username'] ?></li>

        </ul>
    </div>
  
</div>
<hr class="custom-hr">
<?php
if($_SESSION['user'])
{
 ?>
<div class="row">
    <div class="offset-3 col-9 add-comment">
        <h2>Add Your Comment</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
             <textarea name="comment"></textarea>
            <input type="submit" value="Add Comment" class="btn btn-primary" >
        </form>
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $comment = $_POST['comment'];
            $itemid = $item['id'];
            $userid = $_SESSION['id']; 

            if(! empty($comment) ){
                $stmt = $con->prepare("INSERT INTO
                 comments (comment, status, date, item_id, user_id)
                 VALUES (:comment, 0, now(), :item_id, :user_id) ");

                 $stmt->execute(array(
                    'comment' => $comment,
                    'item_id' => $itemid,
                    'user_id' => $userid
                 ));
                 if($stmt){
                     echo '<div class="alert alert-success">You Add Your Comment</div>';
                 }

            }
        }
        ?>
       
    </div>
    </div>
    <?php
    }else { echo '<a href="login.php">Login</a> Or <a href="login.php">Regester</a>';}
    ?>

<hr class="custom-hr">
<?php
                $stmt = $con->prepare("SELECT
                                comments.*,
                                users.username
                                 FROM
                                     comments
                                INNER JOIN
                                     users
                                ON
                                     users.id = user_id
                                WHERE
                                item_id = ?
                                && 
                                status = 1

                                ORDER BY id  DESC");
            $stmt->execute(array($item['id']));
            $coms = $stmt->fetchall();
?>
    <div class="row">
<div class="col-md-3">
    user image
    </div>

    <div class="col-md-9">
    <?php
    foreach($coms as $coms){
      echo  $coms['username'] . '<br>' ;
      echo  $coms['comment'] . '<br>' ;
    }
    
    ?>
    </div>
    </div>
    
    </div>

 
<?php
include $tpl . 'footer.php';
ob_end_flush();
?>