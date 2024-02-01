<?php

include('config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};
if (isset($_POST['update_product'])) {
  $pid = $_POST['pid'];
  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);
  $price = $_POST['price'];
  $price = filter_var($price, FILTER_SANITIZE_STRING);
  $category = $_POST['category'];
  $category = filter_var($category, FILTER_SANITIZE_STRING);
  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);
  $details = $_POST['details'];
  $details = filter_var($details, FILTER_SANITIZE_STRING);


  $image = $_FILES['image']['name'];
  $image = filter_var($image, FILTER_SANITIZE_STRING);
  $image_size = $_FILES['image']['size'];
  $image_tmp_name = $_FILES['image']['tmp_name'];
  $image_folder = 'upload_img/'.$image;

  $old_image = $_POST['old_image'];
  
  $update_product = $conn->prepare("UPDATE products SET name = ?,category = ?, details = ?, price = ? WHERE id = ?");
  $update_product->execute([$name,$category,$details,$price,$pid]);
  $message[] = 'Produto Atualizado com sucesso!';

  if (!empty($image)) {
      if ($image_size > 2000000) {
        $message[] = 'Imagem muito grande!' ;
      }else {
        $update_image = $conn->prepare("UPDATE products SET image = ? WHERE id ?");
        $update_image->execute([$image, $pid]);

        if ($update_image) {
          
          move_uploaded_file($image_tmp_name, $image_folder);
          unlink('upload_img/'.$old_image);
          $message[] = 'Imagem atualizada com sucesso!';

        }

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/admin_style.css">
    <script src="js/script.js" defer></script>
    <title>Página de Admintração</title>
</head>
<body>
  <?php
    include('admin_header.php');
  ?>
  <section class="update-product">
    <h1 class="title">Atualizar Produto</h1>
  <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM products WHERE id = ?");
              $select_products->execute([$update_id]);
              if ($select_products->rowCount() > 0) {
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {

            
  ?>
    <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden"  name="old_image" value="<?= $fetch_products['image'] ?>">
      <input type="hidden"  name="pid" value="<?= $fetch_products['id'] ?>">
      <img src="upload_img/<?= $fetch_products['image'];?>" alt="Product image">
      <input type="text" name="name" placeholder="Digite o nome do produto" required class="box" value="<?= $fetch_products['name'] ?>">
      <input type="text" name="price" min="0" placeholder="Digite o preço do produto" required class="box" value="<?= $fetch_products['price'] ?>">
      <select name="category" class="box" required>
          <option  selected ><?= $fetch_products['category'];?></option>
          <option value="Vegitables">Verduras</option>
          <option value="fruits">Frutas</option>
          <option value="meat">Carnes</option>
          <option value="fish">Peixes</option>          
        </select>
        <textarea name="details" class="box" required cols="30" rows="10" placeholder="detalhes do produto" ><?= $fetch_products['details'];?></textarea>
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
        <div class="flex-btn">
            <input type="submit" class="btn" value="atualizar produto" name="update_product">
            <a href="admin_products.php" class="option-btn">Voltar</a>
        </div>
     </form> 
  <?php
              }
            }else {
                echo '<div class="empty">Nenhum Produto encontrado</div>';          
            }

  ?>
  </section>
</body>
</html>