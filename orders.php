<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>vos commandes</h3>
   <p> <a href="home.php">accueil</a> / commandes </p>
</div>

<section class="placed-orders">

   <div class="box-container">

      <?php
         $order_query = mysqli_query($conn, "SELECT * FROM `commandes` WHERE utilisateur_id = '$user_id'") or die('erreur');
         if(mysqli_num_rows($order_query) > 0){
            while($fetch_orders = mysqli_fetch_assoc($order_query)){
      ?>
      <div class="box">
         <p> date de livraison : <span><?php echo $fetch_orders['livraison']; ?></span> </p>
         <p> nom : <span><?php echo $fetch_orders['nom']; ?></span> </p>
         <p> numéro : <span><?php echo $fetch_orders['numéro']; ?></span> </p>
         <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> adresse : <span><?php echo $fetch_orders['adresse']; ?></span> </p>
         <p> méthode de payement : <span><?php echo $fetch_orders['méthode']; ?></span> </p>
         <p> vos commandes : <span><?php echo $fetch_orders['produits_total']; ?></span> </p>
         <p> prix total : <span><?php echo $fetch_orders['prix_total']; ?>dh</span> </p>
         <p> status de payment  : <span style="color:<?php if($fetch_orders['payment_status'] == 'en cours'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
         </div>
      <?php
       }
      }else{
         echo '<p class="empty">pas de commandes!</p>';
      }
      ?>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>