<?php

include('config.php');
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};
if (isset($_GET['delete'])) {
    $delete_id =  $_GET['delete'];
    $delete_cart_item = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $delete_cart_item->execute([$delete_id]); 
    header('location:cart.php');
 }
 if (isset($_GET['delete_all'])) {
  
    $delete_cart_item = $conn->prepare("DELETE  FROM cart WHERE user_id = ?");
    $delete_cart_item->execute([$user_id]); 
    header('location:cart.php');
 }
 if (isset($_POST['update_qty'])) {
    $cart_id = $_POST['cart_id'];
    $p_qty = $_POST['p_qty'];
    $p_qty =  filter_var($p_qty,FILTER_SANITIZE_STRING);
    $update_qty =  $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
    $update_qty->execute([$p_qty,$cart_id]);
    $message[] = 'Quantidade Atualizada com sucesso!';

 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
    <title>Meu carrinho</title>
</head>
<body>

    <?php include('header.php'); ?>

    <section class="shopping-cart">
        <h1 class="title">Carrinho</h1>
        <div class="box-container">
            <?php
                $grand_total = 0;
                $select_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
                $select_cart->execute([$user_id]);
                if ($select_cart->rowCount() > 0) {
                     while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                        
            ?>
                <form action="" method="post" class="box">
                    <a href="cart.php?delete=<?= $fetch_cart['id'] ?>" class="fas fa-times" onclick="return confirm('Deletar do carrinho ?');"></a>
                    <a href="view_page.php?pid=<?= $fetch_cart['pid'] ?>" class="fas fa-eye"></a>
                   
                    <img src="upload_img/<?= $fetch_cart['image']; ?>" alt="image">
                    <div class="name"><?= $fetch_cart['name'] ?></div>
                    <div class="price">R$ <?= $fetch_cart['price'] ?>,00</div>
                    
                    <input type="hidden" name="cart_id" value="<?= $fetch_cart['id'] ?>">
                    
                    <div class="flex-btn">
                        <input type="number" name="p_qty" min="1" value="<?= $fetch_cart['quantity'] ?>" class="qty">
                        <input type="submit" value="Atualizar" name="update_qty" class="option-btn">
                    </div>
                    <div class="sub-total">sub-total : <span>R$<?= $subtotal = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>,00</span></div>

                </form>

            <?php

                        $grand_total += $subtotal;
                        }
                    }else {
                        echo ' <p class="empty">Ainda não há produtos!</p> ';
                    }
            ?>
        </div>
        <div class="cart-total">
            <p>Preço total: <span>R$<?= $grand_total ?>,00</span></p>
            <a href="shop.php" class="option-btn">Continuar Comprando</a>
            <a href="cart.php?delete_all" class="delete-btn <?=($grand_total > 1)?'':'disabled'; ?>">Deletar Tudo</a>
            <a href="checkout.php" class="btn <?=($grand_total > 1)?'':'disabled'; ?>">Finalizar Compra</a>
        </div>
      
    </section>
   














    <?php include('footer.php') ?>
</body>
</html>