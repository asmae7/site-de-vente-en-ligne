<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="flex">

      <a href="admin_page.php" class="logo">Page<span>Admin</span></a>

      <nav class="navbar">
         <a href="admin_page.php">Acceuil</a>
         <a href="admin_products.php">Produits</a>
         <a href="admin_orders.php">Commandes</a>
         <a href="admin_users.php">Utilisateurs</a>
         <a href="admin_contacts.php">Messages</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="account-box">
         <p>nom d'utilisateur : <span><?php echo $_SESSION['admin_name']; ?></span></p>
         <p>email : <span><?php echo $_SESSION['admin_email']; ?></span></p>
         <a href="logout.php" class="delete-btn">Se déconnecter
         </a>
         <div>nouveau <a href="login.php">compte</a> | <a href="register.php">créer un compte</a></div>
      </div>

   </div>

</header>