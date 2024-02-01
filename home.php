<?php

include('config.php');
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

if (isset($_POST['add_to_wishlist'])) {
    $pid = $_POST['pid'];
    $pid = filter_var($pid,FILTER_SANITIZE_STRING);
    $p_name =  $_POST['p_name'];
    $p_name = filter_var($p_name,FILTER_SANITIZE_STRING);
    $p_price =  $_POST['p_price'];
    $p_price = filter_var($p_price,FILTER_SANITIZE_STRING);
    $p_image =  $_POST['p_image'];
    $p_image = filter_var($p_image,FILTER_SANITIZE_STRING);

    $check_checklist_numbers = $conn->prepare("SELECT * FROM wishlist WHERE name = ? AND user_id = ?");
    $check_checklist_numbers->execute([$p_name, $user_id]);

    $check_cart_numbers = $conn->prepare("SELECT * FROM cart WHERE name = ? AND user_id = ?");
    $check_cart_numbers->execute([$p_name,$user_id]);

    if ($check_checklist_numbers->rowCount() > 0) {
        $message[] = 'Item já adicionado na lista de favoritos';
    }elseif ($check_cart_numbers->rowCount() > 0) {
        $message[] = 'Item já adicionado ao carrinho';
    }else {
        $insert_wishlist = $conn->prepare("INSERT INTO wishlist(user_id,pid,name,price,image) VALUES (?,?,?,?,?)");
        $insert_wishlist->execute([$user_id,$pid,$p_name,$p_price,$p_image]);
        $message[] = 'Item adicionado na lista de favoritos';
    }
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
    <title>Home</title>
</head>
<body>

    <?php include('header.php'); ?>
    <div class="home-bg">
        <section class="home">
            <div class="content">
                <span>Coma bem,Viva Bem!</span>
                <h3> Os melhores alimentos saudáveis para você</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores harum quia iure fugit, cupiditate officiis.</p>
                <a href="about.php" class="btn">Saiba Mais</a>

            </div>
        </section>
    </div>
    <setion class="home-category">
        <h1 class="title">Comprar por Categoria</h1>
        <div class="box-container">
            <div class="box">
                <img src="img/cat-1.png" alt="category 1">
                <h3>Frutas</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Omnis, labore!</p>
                <a href="category.php?category=fruits" class="btn">Frutas</a>
            </div>
            <div class="box">
                <img src="img/cat-2.png" alt="category 2">
                <h3>Carnes</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Omnis, labore!</p>
                <a href="category.php?category=meat" class="btn">Carnes</a>
            </div>
            <div class="box">
                <img src="img/cat-3.png" alt="category 3">
                <h3>Verduras</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Omnis, labore!</p>
                <a href="category.php?category=vegitables" class="btn">Verduras</a>
            </div>
            <div class="box">
                <img src="img/cat-4.png" alt="category 4">
                <h3>Peixes</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Omnis, labore!</p>
                <a href="category.php?category=fish" class="btn">Peixes</a>
            </div>
        </div>
    </setion>
    <section class="products">
        <h1 class="title">Últimos Produtos adicionados</h1>
        <div class="box-container">
            <?php
                $select_products = $conn->prepare("SELECT * FROM products LIMIT 6 ");
                $select_products->execute();
                if ($select_products->rowCount() > 0) {
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                        
              
            ?>

            <form action="" method="post" class="box">
                <div class="price">R$ <?= $fetch_products['price'] ?>,00</div>
                <a href="view_page.php?pid=<?= $fetch_products['id'] ?>" class="fas fa-eye"></a>
                <img src="upload_img/<?= $fetch_products['image'] ?>" alt="image">
                <div class="name"><?= $fetch_products['name'] ?></div>
                <input type="hidden" name="pid" value="<?= $fetch_products['id'] ?>">
                <input type="hidden" name="p_name" value="<?= $fetch_products['name'] ?>">
                <input type="hidden" name="p_price" value="<?= $fetch_products['price'] ?>">
                <input type="hidden" name="p_image" value="<?= $fetch_products['image'] ?>">
                <input type="number" min="1" value="1" name="p_qty" class="qty">
                <input type="submit" value="Adicionar aos favoritos" class="option-btn" name="add_to_wishlist">
                <input type="submit" value="Adicionar ao carrinho" class="btn" name="add_to_cart">
            </form>        
            <?php 
                          }
                }else {
                    echo ' <p class="empty">Ainda não há produtos!</p> ';
                }
            ?>
        </div>
    </section>














    <?php include('footer.php') ?>
</body>
</html>