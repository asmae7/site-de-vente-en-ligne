<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_order'])){

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `commandes` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('ereur');
   $message[] = 'le payment a été mis à jour!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `commandes` WHERE id = '$delete_id'") or die('erreur');
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>commandes</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">COMMANDES</h1>

   <div class="box-container">
      <?php
      $select_orders = mysqli_query($conn, "SELECT * FROM `commandes`") or die('erreur');
      if(mysqli_num_rows($select_orders) > 0){
         while($fetch_orders = mysqli_fetch_assoc($select_orders)){
      ?>
      <div class="box">
         <p> utlisateur id : <span><?php echo $fetch_orders['utilisateur_id']; ?></span> </p>
         <p> place : <span><?php echo $fetch_orders['livraison']; ?></span> </p>
         <p> nom : <span><?php echo $fetch_orders['nom']; ?></span> </p>
         <p> numero : <span><?php echo $fetch_orders['numéro']; ?></span> </p>
         <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> adresse : <span><?php echo $fetch_orders['adresse']; ?></span> </p>
         <p> total des produits : <span><?php echo $fetch_orders['produits_total']; ?></span> </p>
         <p>  prix total : <span><?php echo $fetch_orders['prix_total']; ?>dh</span> </p>
         <p> méthode de payment : <span><?php echo $fetch_orders['méthode']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="update_payment">
               <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
               <option value="en cours">en cours</option>
               <option value="complet">complet</option>
            </select>
            <input type="submit" value="mise à jour" name="update_order" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('vous voulez supprimer cette commande?');" class="delete-btn">supprimer</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">aucune commande!</p>';
      }
      ?>
   </div>

</section>










<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>