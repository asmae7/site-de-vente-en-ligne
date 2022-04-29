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
   <title>savoir plus
   </title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>a savoir</h3>
      <p> <a href="home.php">accueil</a> / savoir plus </p>
   </div>

   <section class="about">

      <div class="flex">

         <div class="image">
            <img src="images/TX6JJ7A2UGX2USY3EG5BHBOGDA.jpg" alt="">
         </div>

         <div class="content">
            <h3>pourquoi choisissez nous?</h3>
            <p>E-SPORTS est la boutique en ligne du Raja et Wydad, présentant les dernières nouveautés et produits des clubs. La boutique E-SPORTS propose un choix complet de polos & casquettes pour hommes et femmes ainsi que d’autres articles qui vont suivre prochainement. Habillez-vous avec style grâce à des polos et casquettes à la fois chics & verts et rouges pour montrer votre dévouement pour les équipes et pour célébrer ensemble le gloire des clubs. Exclusivement sur E-SPORTS Maroc, les polos et les casquettes du Raja Club Athletic et Wydad Club Athletic sont disponibles en édition ilimitée. Commandez dès maintenant les polos et casquettes du Raja Club Athletic et Wydad Club Athletic à des prix promo. Soyez les premiers à célébrer le gloire des deux clubs ! Soyez les premiers à porter les polos officiels des deux clubs !</p>

            <a href="contact.php" class="btn">contacter nous</a>
         </div>

      </div>

   </section>





   <?php include 'footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>