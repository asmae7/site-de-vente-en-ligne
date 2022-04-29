<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>accueil</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>
   <section class="products">

      <h1 class="title">nouveautés</h1>

      <div class="box-container">

         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `produits` LIMIT 6") or die('erreur');
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
                  <input type="submit" value="consulter le produit" name="consult" class="btn">
               </form>
         <?php
            }
         } else {
            echo '<p class="empty">aucun produit!</p>';
         }
         ?>
      </div>

      <div class="load-more" style="margin-top: 2rem; text-align:center">
         <a href="shop.php" class="option-btn">chargez plus</a>
      </div>

   </section>

   <section class="about">

      <div class="flex">

         <div class="image">
            <img src="images/TX6JJ7A2UGX2USY3EG5BHBOGDA.jpg" alt="">
         </div>

         <div class="content">
            <h3>à savoir</h3>
            <p>E-SPORTS est la boutique en ligne du Raja et Wydad, présentant les dernières nouveautés et produits des clubs. La boutique E-SPORTS propose un choix complet de polos & casquettes pour hommes et femmes ainsi que d’autres articles qui vont suivre prochainement</p>
            <a href="about.php" class="btn">lire plus</a>
         </div>

      </div>

   </section>

   <section class="home-contact">

      <div class="content">
         <h3>vous avez des questions?</h3>
         <p> Habillez-vous avec style grâce à des polos et casquettes à la fois chics & verts et rouges pour montrer votre dévouement pour les équipes et pour célébrer ensemble le gloire des clubs. Exclusivement sur E-SPORTS Maroc, les polos et les casquettes du Raja Club Athletic et Wydad Club Athletic sont disponibles en édition ilimitée. Commandez dès maintenant les polos et casquettes du Raja Club Athletic et Wydad Club Athletic à des prix promo. Soyez les premiers à célébrer le gloire des deux clubs ! Soyez les premiers à porter les polos officiels des deux clubs !</p>
         </p>
         <a href="contact.php" class="white-btn">contactez nous</a>
      </div>

   </section>





   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>