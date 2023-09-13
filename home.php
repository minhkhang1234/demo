<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_wishlist_numbers->rowCount() > 0){
      $message[] = 'already added to wishlist!';
   }elseif($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }

}

if(isset($_POST['add_to_cart'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
      $message[] = 'added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/okno.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="home-bgg">

   <section class="home">

      <div class="content">
         <span>C-Class: This is my world</span>
         <h3>The car is the best in the world, everyone needs to know my common name "Mecerdes"</h3>
         <!-- <p>Please choose us because this is the best selling place in Vietnam.</p> -->
         <a href="about.php" class="btn">about us</a>
      </div>

   </section>

</div>

<section class="home-category">

   <h1 class="title">shop by EoEmKay</h1>

   <div class="box-container">

      <div class="box">
         <img src="https://assets.oneweb.mercedes-benz.com/iris/iris.jpg?COSY-EU-100-1713d0VXq0hdqtyO67PobzIr3eWsrrCsdRRzwQZv9IZbMw3SGtGyMtsd2vtcUfp8cXGEuiRJ0l34AOB2NQnbApj7bI5ux52QC31vTkzNBTnm7jA6IhKV5Kh%25vqCBlyLRznyYax7oxrH1KMun8wsOcoiZU7pM4FGTJTg906V6PDBGlSeWAhItsd5kdcUfSA1XGEvTSJ0lL6qOB2abRbApHYpI5usoJQC3UC1kzNGtNm7j0O3hKVB%25t%25vqA8TyLRiO6Yax4JOroYhfldsbbAp7oMIkb1ECQmIFUrkzNUU6m7jscWhKVzsM%25vq7UcyLRKOyYaxvODrH1peKn8wiA2oiZ45gM4zuA1YtEWpTuP6CPDAFIT9ZxeedNtjD%259j6hVNpLpIZIGwC7Ux0wPfejr9j&imgt=P27&bkgnd=9&pov=BE140&uni=c&im=Crop,rect=(-50,-25,1370,770),gravity=Center;Resize,width=300" alt="">
         <h3>Sedans</h3>
         <p>Please choose us because this is the best selling place in Vietnam.</p>
         <a href="category.php?category=sedans" class="btn">Sedans</a>
      </div>

      <div class="box">
         <img src="https://assets.oneweb.mercedes-benz.com/iris/iris.jpg?COSY-EU-100-1713d0VXqNpFqtyO67PobzIr3eWsrrCsdRRzwQZxe4ZbMw3SGtGyMtsd2sDcUfp8qXGEubSJ0l3IrOB2NS1bApRARI5uxeMQC30CQkzNBPKm7jAyvhKV5XN%25vqCJcyLRgcDYaxPa9rH1eMOn8wsV3oiZUMXM4FnCwTg9otn6PDC7NSeWza3tsd7oTcUfKmfXGE4ySJ0lg0VOB2PQqbApeToI5uscDQC3UkTkzNGLwm7j0afhKVHKh%25vq8JcyLRiXJYnymdEWeOOB2znobQOxf5IkbZsYQC3sEOkzNelfm7jCyShKVfi5%25vqLUkyLRaGHYaxHoErH18IOn8wiVyoiZ4%25EM4FgTwTg735wrcldu63ejznj59Q6DF1ssfjcVWyDVS%25qjuauQFQ0ZzKG1BZeEsVnDV&imgt=P27&bkgnd=9&pov=BE140&uni=c&im=Crop,rect=(-50,-25,1370,770),gravity=Center;Resize,width=300" alt="">
         <h3>SUV</h3>
         <p>Please choose us because this is the best selling place in Vietnam.</p>
         <a href="category.php?category=SUV" class="btn">SUV</a>
      </div>

      <div class="box">
         <img src="https://assets.oneweb.mercedes-benz.com/iris/iris.jpg?COSY-EU-100-1713d0VXqN8FqtyO67PobzIr3eWsrrCsdRRzwQZvVIZbMw3SGtGyItsd2JdcUfpAyXGEjymJ0leIAOB2sSnbApvPyI5uOo2QC3bsOkzNGTnm7j07ZhKVBYF%25vq8cXyr%25kWfDPJJ0lCrnOIJRdAbQOznRI5ue4YQC3PExkzN5%256m7jCtEhKVfj9%25vqLU9yLRaGfYaxHoWrH18jOn8wioxoiZ4egM4zuA1YtEWpTuz6ULquFIT9ZxeedNtjD%259j6hVNpLpIZIGwC7Ux0wPfejr9j&imgt=P27&bkgnd=9&pov=BE140&uni=c&im=Crop,rect=(-50,-25,1370,770),gravity=Center;Resize,width=300" alt="">
         <h3>Coupe</h3>
         <p>Please choose us because this is the best selling place in Vietnam.</p>
         <a href="category.php?category=coupe" class="btn">Coupe</a>
      </div>

      <div class="box">
         <img src="https://assets.oneweb.mercedes-benz.com/iris/iris.jpg?COSY-EU-100-1713d0VXqbSeqtyO67PobzIr3eWsrrCsdRRzwQZhkHZbMw3SGtGyMtsd2vtcUfpLfXGEuiXJ0l34AOB2NQnbApjtwI5uVczQC3qkOkzNRLkm7jxafhKVFSQ%25vq9tayLRDcVYaxWaqrH1dBtn8wfAyoiZLbXM4FaIrTg9HQe6PD8P6SeWiaMtsd4HDcUfg8yXGEPbXJ0leIZOB2sQnbApUTyI5uG6JQC30SQkzNHTnm7j8yZhKViYh%25vq4uTyLRg3mYaxPrhrH1enun8wY8WoiZrMlM4FAIcTg95zp6PDCLNSeWzn3tsd8hTcUfiUkXGE4bjJ0lgolOB2PWEbApetpI5usc2QC3UkrkzNGmbm7j0hShKVBHM%25vqA8jyLRjcHYaxVXprH1qM%25n8wPO2oiZeIQM6oY2ul0kkzNL6Sm%25kFpKhymWBM%25vqBBjyLR0GWYaxv0SrH1LIrn8wiO3oiZ4iZM4FgCuTg9Pv36PKNCZnX2f3SNsQ3BxNDkSW9wUUEVXqdYWqtyRV3H3k9kBF7v0wAFslUqoWq&imgt=P27&bkgnd=9&pov=BE140&uni=c&im=Crop,rect=(-50,-25,1370,770),gravity=Center;Resize,width=300" alt="">
         <h3>Maybach</h3>
         <p>Please choose us because this is the best selling place in Vietnam.</p>
         <a href="category.php?category=maybach" class="btn">Maybach</a>
      </div>

   </div>

</section>

<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" class="box" method="POST">
      <div class="price">$<span><?= $fetch_products['price']; ?></span></div>
      <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
      <input type="number" min="1" value="1" name="p_qty" class="qty">
      <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

   </div>

</section>







<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>