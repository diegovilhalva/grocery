<?php

include('config.php');
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

if (isset($_POST['add_to_cart'])) {
    $pid = $_POST['pid'];
    $pid = filter_var($pid,FILTER_SANITIZE_STRING);
    $p_name =  $_POST['p_name'];
    $p_name = filter_var($p_name,FILTER_SANITIZE_STRING);
    $p_price =  $_POST['p_price'];
    $p_price = filter_var($p_price,FILTER_SANITIZE_STRING);
    $p_image =  $_POST['p_image'];
    $p_image = filter_var($p_image,FILTER_SANITIZE_STRING);
    $p_qty = $_POST['p_qty'];
    $p_qty = filter_var($p_qty,FILTER_SANITIZE_STRING);


    $check_cart_numbers = $conn->prepare("SELECT * FROM cart WHERE name = ? AND user_id = ?");
    $check_cart_numbers->execute([$p_name,$user_id]);

    if ($check_cart_numbers->rowCount() > 0) {
        $message[] = 'Item já adicionado ao carrinho';
    }else {
        $check_checklist_numbers = $conn->prepare("SELECT * FROM wishlist WHERE name = ? AND user_id = ?");
        $check_checklist_numbers->execute([$p_name,$user_id]);
        if ($check_checklist_numbers->rowCount() > 0) {
            $delete_checklist_numbers = $conn->prepare("DELETE FROM wishlist WHERE name = ? AND user_id = ?");
            $delete_checklist_numbers->execute([$p_name,$user_id]);
        }

        $insert_cart = $conn->prepare("INSERT INTO cart(user_id,pid,name,price,quantity,image) VALUES(?,?,?,?,?,?)");
        $insert_cart->execute([$user_id,$pid,$p_name,$p_price,$p_qty,$p_image]);
        $message[] = 'Item adicionado ao carrinho!';
    };
};
 if (isset($_GET['delete'])) {
    $delete_id =  $_GET['delete'];
    $delete_wishlist_item = $conn->prepare("DELETE FROM wishlist WHERE id = ?");
    $delete_wishlist_item->execute([$delete_id]); 
    header('location:wishlist.php');
 }
 if (isset($_GET['delete_all'])) {
  
    $delete_wishlist_item = $conn->prepare("DELETE  FROM wishlist WHERE user_id = ?");
    $delete_wishlist_item->execute([$user_id]); 
    header('location:wishlist.php');
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
    <title>Favoritos</title>
</head>
<body>

    <?php include('header.php'); ?>
    <section class="wishlist">
        <h1 class="title">Lista de Favoritos</h1>
        <div class="box-container">
            <?php
                $grand_total = 0;
                $select_wishlist = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ?");
                $select_wishlist->execute([$user_id]);
                if ($select_wishlist->rowCount() > 0) {
                     while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
                        
            ?>
                <form action="" method="post" class="box">
                    <a href="wishlist.php?delete=<?= $fetch_wishlist['id'] ?>" class="fas fa-times" onclick="return confirm('Deletar dos Favoritos ?');"></a>
                    <a href="view_page.php?pid=<?= $fetch_wishlist['pid'] ?>" class="fas fa-eye"></a>
                   
                    <img src="upload_img/<?= $fetch_wishlist['image']; ?>" alt="image">
                    <div class="name"><?= $fetch_wishlist['name'] ?></div>
                    <div class="price">R$ <?= $fetch_wishlist['price'] ?>,00</div>
                    <input type="number" name="p_qty" min="1" value="1" class="qty">
                    <input type="hidden" name="pid" value="<?= $fetch_wishlist['id'] ?>">
                    <input type="hidden" name="p_name" value="<?= $fetch_wishlist['name'] ?>">
                    <input type="hidden" name="p_price" value="<?= $fetch_wishlist['price'] ?>">
                    <input type="hidden" name="p_image" value="<?= $fetch_wishlist['image'] ?>">
                    <input type="submit" value="Adicionar ao carrinho" name="add_to_cart" class="btn">

                </form>

            <?php

                        $grand_total += $fetch_wishlist['price'];
                        }
                    }else {
                        echo ' <p class="empty">Ainda não há produtos!</p> ';
                    }
            ?>
        </div>
        <div class="wishlist-total">
            <p>Preço total: <span>R$<?= $grand_total ?>,00</span></p>
            <a href="shop.php" class="option-btn">Continuar Comprando</a>
            <a href="wishlist.php?delete_all" class="delete-btn <?=($grand_total > 1)?'':'disabled'; ?>">Deletar Tudo</a>
        </div>
    </section>
   














    <?php include('footer.php') ?>
</body>
</html>