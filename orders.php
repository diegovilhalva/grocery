<?php

include('config.php');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
    <title>Pedidos</title>
</head>
<body>

    <?php include('header.php'); ?>

    <section class="placed-orders">
        <h1 class="title">Seus pedidos</h1>
        <div class="box-container">
            <?php
                $select_orders = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
                $select_orders->execute([$user_id]);
                if ($select_orders->rowCount() > 0) {
                    while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                 
            ?>
            <div class="box">
                <p>Data do Pedido: <span><?= $fetch_orders['placed_on'] ?></span></p>
                <p>Nome: <span><?= $fetch_orders['name'] ?></span></p>
                <p> Número: <span><?= $fetch_orders['number']  ?></span></p>
                <p> E-mail: <span><?= $fetch_orders['email'] ?></span></p>
                <p>Endereço: <span><?= $fetch_orders['address'] ?></span></p>
                <p>Forma de pagamento: <span><?= $fetch_orders['method'] ?></span></p>
                <p>Pedido: <span><?= $fetch_orders['total_products'] ?></span></p>
                <p>Valor: <span> R$ <?= $fetch_orders['total_price'] ?>,00</span></p>
            </div>
            <?php
                           
                        }
                    }else {
                        echo ' <p class="empty">Não há pedidos ainda!</p> ';
                    }  
            
            ?>
        </div>
    </section>














    <?php include('footer.php') ?>
</body>
</html>