<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_POST['add_to_cart'])) {

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `panier` WHERE nom = '$product_name' AND utilisateur_id = '$user_id'") or die('erreur');

   if (mysqli_num_rows($check_cart_numbers) > 0) {
      $message[] = 'déjà ajouté!';
   } else {
      mysqli_query($conn, "INSERT INTO `panier`(utilisateur_id, nom, prix, quantité, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('erreur');
      $message[] = 'ajouté au panier!';
   }
}
if(isset($_POST['consult'])){
   header("location:consult.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>notre market</h3>
      <p> <a href="home.php">acceuil</a> / market </p>
   </div>

   <section class="products">

      <h1 class="title">nouveautés</h1>
      <div class="box-container">

         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `produits`") or die('erreur');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
         ?>
               <form action="consult.php" method="post" class="box">
                  <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                  <div class="name"><?php echo $fetch_products['nom']; ?></div>
                  <div class="price"><?php echo $fetch_products['prix']; ?>dh</div>
                  <input type="hidden" min="1" name="product_quantity" value="1" class="qty">
                  <input type="hidden" name="product_name" value="<?php echo $fetch_products['nom']; ?>">
                  <input type="hidden" name="product_price" value="<?php echo $fetch_products['prix']; ?>">
                  <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                  <input type="submit" value="ajouter au panier" name="add_to_cart" class="btn">
                  <input type="submit" value="consulter le produit" name="consult" class="btn">
               </form>
         <?php
            }
         } else {
            echo '<p class="empty">pas de produit n\'est ajouté!</p>';
         }
         ?>
      </div>

   </section>








   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>