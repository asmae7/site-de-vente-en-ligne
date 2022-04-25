<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

if (isset($_POST['add_product'])) {

   $name =  $_POST['name'];
   $price = $_POST['price'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/' . $image;

   $select_product_name = mysqli_query($conn, "SELECT nom FROM `produits` WHERE nom = '$name'") or die('erreur');

   if (mysqli_num_rows($select_product_name) > 0) {
      $message[] = 'ce produit est déjà ajouté';
   } else {
      $add_product_query = mysqli_query($conn, "INSERT INTO `produits`(nom, prix, image) VALUES('$name', '$price', '$image')") or die('test');

      if ($add_product_query) {
         if ($image_size > 2000000) {
            $message[] = 'image est trés large';
         } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'produit est ajouté!';
         }
      } else {
         $message[] = 'produit ne peut pas être ajouté!';
      }
   }
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `produits` WHERE id = '$delete_id'") or die('erreur');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/' . $fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `produits` WHERE id = '$delete_id'") or die('erreur');
   header('location:admin_products.php');
}

if (isset($_POST['update_product'])) {

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];

   mysqli_query($conn, "UPDATE `produits` SET nom = '$update_name', prix = '$update_price' WHERE id = '$update_p_id'") or die('erreur');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/' . $update_image;
   $update_old_image = $_POST['update_old_image'];

   if (!empty($update_image)) {
      if ($update_image_size > 2000000) {
         $message[] = 'image est trés large';
      } else {
         mysqli_query($conn, "UPDATE `produits` SET image = '$update_image' WHERE id = '$update_p_id'") or die('erreur');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/' . $update_old_image);
      }
   }
   header('location:admin_products.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

   <?php include 'admin_header.php'; ?>

   <!-- product CRUD section starts  -->

   <section class="add-products">

      <h1 class="title">produits</h1>

      <form action="" method="post" enctype="multipart/form-data">
         <h3>ajouter produit</h3>
         <input type="text" name="name" class="box" placeholder="entrer le nom du produit" required>
         <input type="number" min="0" name="price" class="box" placeholder="entrer le prix" required>
         <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
         <input type="submit" value="ajouter produit" name="add_product" class="btn">
      </form>

   </section>
   <section class="show-products">

      <div class="box-container">

         <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `produits`") or die('erreur');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
         ?>
               <div class="box">
                  <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                  <div class="name"><?php echo $fetch_products['nom']; ?></div>
                  <div class="price"><?php echo $fetch_products['prix']; ?>dh</div>
                  <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">mise à jour</a>
                  <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('supprimer ce produit?');">supprimer</a>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">aucun produit n\'est ajouté!</p>';
         }
         ?>
      </div>

   </section>

   <section class="edit-product-form">

      <?php
      if (isset($_GET['update'])) {
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `produits` WHERE id = '$update_id'") or die('erreur');
         if (mysqli_num_rows($update_query) > 0) {
            while ($fetch_update = mysqli_fetch_assoc($update_query)) {
      ?>
               <form action="" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
                  <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
                  <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
                  <input type="text" name="update_name" value="<?php echo $fetch_update['nom']; ?>" class="box" required placeholder="entrer le nom du produit">
                  <input type="number" name="update_price" value="<?php echo $fetch_update['prix']; ?>" min="0" class="box" required placeholder="entrer le prix">
                  <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
                  <input type="submit" value="mise à jour" name="update_product" class="btn">
                  <input type="reset" value="annuler" id="close-update" class="option-btn">
               </form>
      <?php
            }
         }
      } else {
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
      ?>

   </section>
   <!-- product CRUD section ends -->

   <!-- show products  -->
   <!-- custom admin js file link  -->
   <script src="js/admin_script.js"></script>

</body>

</html>