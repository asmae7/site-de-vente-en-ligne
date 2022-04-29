<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['send'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = $_POST['number'];
   $msg = mysqli_real_escape_string($conn, $_POST['message']);

   $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE nom = '$name' AND email = '$email' AND numéro = '$number' AND message = '$msg'") or die('erreur');

   if(mysqli_num_rows($select_message) > 0){
      $message[] = 'message déjà envoyé!';
   }else{
      mysqli_query($conn, "INSERT INTO `message`(utilisateur_id, nom, email, numéro, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('erreur');
      $message[] = 'message est envoyé!';
   }

}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>contacter nous</h3>
   <p> <a href="home.php">accueil</a> / contact </p>
</div>

<section class="contact">

   <form action="" method="post">
      <input type="text" name="name" required placeholder="entrer votre nom" class="box">
      <input type="email" name="email" required placeholder="entrer votre email" class="box">
      <input type="number" name="number" required placeholder="entrer votre numéro" class="box">
      <textarea name="message" class="box" placeholder="entrer votre message" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="envoyer" name="send" class="btn">
   </form>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>