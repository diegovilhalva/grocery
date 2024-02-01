<?php

include('config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};

if (isset($_POST['update_order'])) {
  $order_id = $_POST['order_id'];
  $update_payment= $_POST['update_payment'];
  $update_payment = filter_var($update_payment,FILTER_SANITIZE_STRING);
  $update_orders = $conn->prapare("UPDATE orders SET payment_status = ? WHERE id = ?");
  $update_orders->execute([$update_payment, $order_id]);
  $message[] = 'Pedido Atualizado com sucesso!';
};

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_orders = $conn->prepare("DELETE FROM orders WHERE id  = ?");
    $delete_orders->execute([$delete_id]);
    header('location:admin_orders.php');
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
    <title>Pedidos</title>
</head>
<body>
  <?php
    include('admin_header.php');
    
  ?>
  

  <section class="placed-orders">
  <h1 class="title"> Gerenciar Pedidos</h1>
    <div class="box-container">
          <?php
              $select_orders = $conn->prepare("SELECT * FROM orders ");
              $select_orders->execute();
              if ($select_orders->rowCount() > 0) {
                while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                  
              
            ?>
          <div class="box">
                  <p>Id do Usuário: <span><?= $fetch_orders['user_id']; ?></span></p>
                  <p>Nome: <span><?= $fetch_orders['name']; ?></span></p>
                  <p>Data Pedido: <span><?= $fetch_orders['placed_on']; ?></span></p>
                  <p>E-mail: <span><?= $fetch_orders['email']; ?></span></p>
                  <p>Telefone: <span><?= $fetch_orders['number']; ?></span></p>
                  <p>Endereço: <span><?= $fetch_orders['address']; ?></span></p>
                  <p>Total Produtos: <span><?= $fetch_orders['total_products']; ?></span></p>
                  <p>Valor Total: <span> R$ <?= $fetch_orders['total_price']; ?>,00</span></p>
                  <p>Forma de pagamento: <span><?= $fetch_orders['method']; ?></span></p>
                  <form action="" method="post">
                    <input type="hidden" name="order_id" value="<?= $fetch_orders['id'];?>">
                    <select name="update_payment" class="drop-down">
                      <option value="" selected disabled><?= $fetch_orders['payment_status'];?></option>
                      <option value="pending">Pendente</option>
                      <option value="completed">Finalizado</option>
                      <div class="flex-btn">
                        <input type="submit" class="option-btn" name="update_order"  value="Atualizar">
                        <a href="admin_orders.php?=delete<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Deseja excluir esse pedido?')">Excluir</a>
                      </div>
                    </select>
                  </form>
          </div>
          <?php
              }
              }else {
                  echo ' <p class="empty">Ainda não há Pedidos!</p>';
              }
          ?>
    </div>
  </section>
 
</body>
</html>