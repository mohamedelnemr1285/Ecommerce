<?php
session_start();
if(isset($_SESSION['login'])){

    $pagetitle = 'Dashboard';

    include 'init.php';
    include($tpl.'header.php');
    ?>

    <div class="container home-stats">
        <h1 class="text-center">Dashboard</h1>
        <div class="row">

        <div class="col-md-3 ">
            <div class="stat Members">
                <i class="fa fa-users"></i>
            <div class="info">
            Total Members
        <span><a href="members.php?do=mange"><?php echo countitems('id', 'users') ?></a></span>
            </div>
        </div>
        </div>

        <div class="col-md-3 ">
        <div class="stat Pending">
        <i class="fa fa-user-plus"></i>
     <div class="info">
     Pending Members
        <span><a href="members.php?do=mange&page=pending"><?php echo checkitem('regstatus', 'users',0) ?></a></span>
     </div>
        </div>
        </div>

        <div class="col-md-3 ">
        <div class="stat Items">
        <i class="fa fa-tag"></i>
      <div class="info">
      Total Items
        <span><a href="items.php?do=mange"><?php echo countitems('id','items'); ?></a></span>
      </div>
        </div>
        </div>

     
        <div class="col-md-3">
        <div class="stat Comments">
        <i class="fa fa-Comments"></i>
      <div class="info">
      Total Comments
        <span><a href="comments.php?do=mange"><?php echo countitems('id','comments'); ?></a></span>
      </div>
        </div>
        </div>


        </div>
    </div>

    <?php
      $limituser = 4;
     $latestuser = getlatest('*','users',$limituser);

     $limititem = 4;
     $latestitem = getlatest('*','items',$limititem);

        ?>

    <div class="container latest">
        <div class="row">

        <div class="col-sm-6">
             <div class="card">
                <div class="card-header">
                    <span class="toggle-info pull-right">
                        <i class="fa fa-plus"></i>
                    </span>
                <i class="fa fa-users"></i>Latset<strong><?php echo ' '.$limituser.' ' ?></strong> Rejester Users</div>
                <div class="card-body">
                 <p class="card-text">
                 <ul class="list-unstyled latsted">
                     <?php
                     
                     foreach($latestuser as $users){
                        
                        echo "<li>" . ucwords($users['username']) ."<a href= 'members.php?do=edit&userid= ".$users['id']."' ><button class='btn btn-success pull-right '>
                        <i class='fa fa-edit'></i>Edit</button> </a>". "</li>" ;
                     }
                     ?>
                     </ul>
                </p>
                </div>
             </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                <span class="toggle-info pull-right">
                        <i class="fa fa-plus"></i>
                    </span>
                <i class="fa fa-home"></i>Latest<strong><?php echo " " .$limititem. " " ?></strong> Items</div>
                    <div class="card-body">
                 <p class="card-text">
                 <ul class="list-unstyled latsted">
                     <?php
                     
                     foreach($latestitem as $item){
                        
                        echo "<li>" . ucwords($item['name']) ."<a href= 'items.php?do=edit&itemid= ".$item['id']."' ><button class='btn btn-success pull-right '>
                        <i class='fa fa-edit'></i>Edit</button> </a>". "</li>" ;
                     }
                     ?>
                     </ul>
                 </p>
                </div>
             </div>
        </div>

       </div>
    </div>



<?php


include $tpl.'footer.php';

} else{
    header('location:index.php');
}
?>