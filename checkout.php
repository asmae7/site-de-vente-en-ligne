<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_POST['order_btn'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = mysqli_real_escape_string($conn, 'flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code']);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($conn, "SELECT * FROM `panier` WHERE utilisateur_id = '$user_id'") or die('erreur');
   if (mysqli_num_rows($cart_query) > 0) {
      while ($cart_item = mysqli_fetch_assoc($cart_query)) {
         $cart_products[] = $cart_item['nom'] . ' (' . $cart_item['quantité'] . ') ';
         $sub_total = ($cart_item['prix'] * $cart_item['quantité']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ', $cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `commandes` WHERE nom = '$name' AND numéro = '$number' AND email = '$email' AND méthode = '$method' AND adresse = '$address' AND produits_total = '$total_products' AND prix_total = '$cart_total'") or die('erreur');

   if ($cart_total == 0) {
      $message[] = 'votre panier est vide';
   } else {
      if (mysqli_num_rows($order_query) > 0) {
         $message[] = 'déjà ajouté!';
      } else {
         mysqli_query($conn, "INSERT INTO `commandes`(utilisateur_id, nom, numéro, email, méthode, adresse, produits_total, prix_total, livraison) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('erreur');
         $message[] = 'ajouté au panier!!';
         mysqli_query($conn, "DELETE FROM `panier` WHERE utilisateur_id = '$user_id'") or die('erreur');
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>commander!</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>commander!</h3>
      <p> <a href="home.php">accueil</a> / commander </p>
   </div>

   <section class="display-order">

      <?php
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `panier` WHERE utilisateur_id = '$user_id'") or die('erreur');
      if (mysqli_num_rows($select_cart) > 0) {
         while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            $total_price = ($fetch_cart['prix'] * $fetch_cart['quantité']);
            $grand_total += $total_price;
      ?>
            <p> <?php echo $fetch_cart['nom']; ?> <span>(<?php echo  $fetch_cart['prix'] . 'dh' . ' x ' . $fetch_cart['quantité']; ?>)</span> </p>
      <?php
         }
      } else {
         echo '<p class="empty">votre panier est vide! </p>';
      }
      ?>
      <div class="grand-total"> total : <span></span><?php echo $grand_total; ?>dh</span> </div>

   </section>

   <section class="checkout">

      <form action="" method="post">
         <h3>valider votre commande</h3>
         <div class="flex">
            <div class="inputBox">
               <span>votre nom :</span>
               <input type="text" name="name" required placeholder="entrer votre nom">
            </div>
            <div class="inputBox">
               <span>votre numéro :</span>
               <input type="number" name="number" required placeholder="entrer votre numéro">
            </div>
            <div class="inputBox">
               <span>votre email :</span>
               <input type="email" name="email" required placeholder="entrer votre email">
            </div>
            <div class="inputBox">
               <span>méthode de payement :</span>
               <select name="method">
                  <option value="cash lors de livraison">cash lors de livraison</option>
                  <option value="carte bancaire">carte bancaire</option>
                  <option value="paypal">paypal</option>
               </select>
            </div>
            <div class="inputBox">
               <span>address line 01 :</span>
               <input type="number" min="0" name="flat" required>
            </div>
            <div class="inputBox">
               <span>adresse:</span>
               <input type="text" name="street" required>
            </div>
            <div class="inputBox">
               <span>ville :</span>
               <input type="text" name="city" required>
            </div>
            <div class="inputBox">
               <span>pays :</span>
               <input type="text" name="country" required>
            </div>
            <div class="inputBox">
               <span> code pin :</span>
               <input type="number" min="0" name="pin_code" required>
            </div>
         </div>
         <input type="submit" value="commander maintenant" class="btn" name="order_btn">
      </form>

   </section>









   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>