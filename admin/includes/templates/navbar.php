<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ">
      <li class="nav-item active">
        <a class="navbar-brand" href="dashboard.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="categories.php">Categories</a>
      </li>
      <li class="nav-item">
      </li>
      <li class="nav-item">
      <a class="nav-link" href="members.php?do=mange">Members</a>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="comments.php">Comments</a>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="#">Statistics</a>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="items.php">Items</a>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="#">Logs</a>
      </li>
      </ul>
      <ul class="drrop navbar-nav ml-auto">
          <li class="nav-item dropdown s">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo ucwords($_SESSION['login'])  ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="../index.php">Visit Shop</a>
          <a class="dropdown-item" href="members.php?do=edit&userid=<?php echo $_SESSION['id'] ?>">Edit Profile</a>
          <a class="dropdown-item" href="#">Setting</a>
          <a class="dropdown-item" href="logout.php">LogOut</a>
        </div>
      </li>
    </ul>
    
  </div>
</nav>