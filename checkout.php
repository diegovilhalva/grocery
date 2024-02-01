<?php

include('config.php');
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};

if (isset($_POST['order'])) {
    $name =  $_POST['name'];
    $name = filter_var($name,FILTER_SANITIZE_STRING);
    $number =  $_POST['number'];
    $number = filter_var($number,FILTER_SANITIZE_STRING);
    $email =  $_POST['email'];
    $email = filter_var($email,FILTER_SANITIZE_STRING);
    $method =  $_POST['method'];
    $method = filter_var($method,FILTER_SANITIZE_STRING);
    $address =  $_POST['street'] . ','.  $_POST['flat']. ' - '. $_POST['city']. ' - ' . $_POST['state']. ' - ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
    $address = filter_var($address,FILTER_SANITIZE_STRING);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '' ;

    $cart_query = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $cart_query->execute([$user_id]);

    if ($cart_query->rowCount() > 0) {
        while ($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)) {
            $cart_products[] = $cart_item['name']. '(' .$cart_item['quantity']. ')';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
            
        }
    }

    $total_products = implode(', ',$cart_products);

    $order_query = $conn->prepare("SELECT * FROM order WHERE name = ? AND number = ? AND email = ? AND method AND address = ? AND total_products = ? AND total_price = ? ");
    $order_query->execute([$name,$number,$email,$method,$address,$total_products,$cart_total]);

    if ($cart_total == 0) {
        $message[] = 'seu carrinho está vazio!';
        
    }elseif ($order_query->rowCount() > 0 ) {
        $message[] = 'pediodo já feito';
    }else {
        $insert_order = $conn->prepare("INSERT INTO orders (user_id,name,number,email,method,address,total_products,total_price,placed_on) VALUES (?,?,?,?,?,?,?,?,?)");
        $insert_order->execute([$user_id,$name,$number,$email,$method,$address,$total_products,$cart_total,$placed_on]);
        $delete_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $delete_cart->execute([$user_id]);
        $message[] = 'Pedido feito com sucesso!';
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
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
    <title>Checkout</title>
</head>
<body>

    <?php include('header.php'); ?>

   
    <section class="display-orders">
    <h1 class="title">Detalhes do pedido:</h1>
        <?php
            $cart_grand_total = 0;
            $select_cart_items =  $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
            $select_cart_items->execute([$user_id]);
            if ($select_cart_items->rowCount() > 0) {
                while ($fetch_cart_items =  $select_cart_items->fetch(PDO::FETCH_ASSOC)) {
                    $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
                    $cart_grand_total += $cart_total_price;

          
        ?>
        <p><?= $fetch_cart_items['name'] ?><span> (<?= 'R$ ' .$fetch_cart_items['price'].',00 ' .'x '. $fetch_cart_items['quantity'] ?>)</span></p>
        <?php
                  }
                }else {
                    echo ' <p class="empty">O carrinho está vazio!</p> ';
                } 
        ?>
        <div class="grand-total">Total: <span>R$ <?= $cart_grand_total; ?>,00</span></div>
    </section>
    <section class="checkout-orders">
        <form action="" method="post">
            <h3>finalize seu pedido</h3>
            <div class="flex">
                <div class="inputBox">
                    <span>Seu Nome:</span>
                    <input type="text" name="name"  placeholder="escreva seu nome" class="box" required>
                </div>
                <div class="inputBox">
                    <span>Seu Número de Telefone:</span>
                    <input type="number" name="number"  placeholder="escreva seu número" class="box" required>
                </div>
                <div class="inputBox">
                    <span>Seu E-mail:</span>
                    <input type="email" name="email"  placeholder="escreva seu email" class="box" required>
                </div>
                <div class="inputBox">
                    <span>Forma de pagamento:</span>
                    <select name="method" class="box" required>
                        <option value="cash on delivery">Dinheiro</option>
                        <option value="credit card">Cartão de crédito</option>
                        <option value="payTm">Pix</option>
                        <option value="paypal">Paypal</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Endereço:</span>
                    <input type="text" name="street"  placeholder="escreva o endereço para entrega" class="box" required>
                </div>
                <div class="inputBox">
                    <span>Numero :</span>
                    <input type="text" name="flat"  placeholder="escreva o numero do endereço" class="box" required>

                </div>
                <div class="inputBox">
                    <span>Cidade:</span>
                    <input type="text" name="city"  placeholder="escreva nome da cidade" class="box" required>
                </div>
                <div class="inputBox">
                    <span>Estado:</span>
                    <input type="text" name="state"  placeholder="escreva o seu estado" class="box" required>
                </div>                
                <div class="inputBox">
                    <span>País:</span>
                    <input type="text" name="country"  placeholder="escreva seu país" class="box" required>
                </div>
                <div class="inputBox">
                    <span>CEP:</span>
                    <input type="text" name="pin_code"  placeholder="escreva seu cep" class="box" required>
                </div>
                <input type="submit" name="order" class="btn  <?=($cart_grand_total > 1)?'':'disabled'; ?>"  value="Finalizar compra">
            </div>
        </form>
    </section>














    <?php include('footer.php') ?>
</body>
</html>