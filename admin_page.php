<?php

include('config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
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
    <link rel="stylesheet" href="css/admin_style.css">
    <script src="js/script.js" defer></script>
    <title>Página de Administração</title>
</head>
<body>
  <?php
    include('admin_header.php');
  ?>
  <section class="dashboard">
    <h1 class="title">Dashboard</h1>
    <div class="box-container">
      <div class="box">
        <?php
          $total_pendings = 0;
          $select_pendings = $conn->prepare("SELECT * FROM orders  WHERE payment_status = ?");
          $select_pendings->execute(['pending']);
          while ( $fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)) {
            $total_pendings += $fetch_pendings['total_price'];
          }
              
        ?>
        <h3><?=  $total_pendings ?></h3>
        <p>Total de pedidos Pendentes</p>
        <a href="admin_orders.php" class="btn">Ver Pedidos</a>
      </div>
      <div class="box">
        <?php
          $total_completed = 0;
          $select_completed = $conn->prepare("SELECT * FROM orders  WHERE payment_status = ?");
          $select_completed->execute(['completed']);
          while ( $fetch_completed = $select_completed->fetch(PDO::FETCH_ASSOC)) {
            $total_completed += $fetch_completed['total_price'];
          }
              
        ?>
        <h3><?=  $total_completed ?></h3>
        <p>Total de Pedidos Finalizados</p>
        <a href="admin_orders.php" class="btn">Ver Pedidos</a>
      </div>
      <div class="box">
        <?php
          $select_orders = $conn->prepare("SELECT * FROM orders");
          $select_orders->execute();
          $number_of_orders = $select_orders->rowCount();
        ?>
        <h3><?=  $number_of_orders ?></h3>
        <p>Total de Pedidos</p>
        <a href="admin_orders.php" class="btn">Ver Pedidos</a>
      </div>
      <div class="box">
        <?php
          $select_products = $conn->prepare("SELECT * FROM products");
          $select_products->execute();
          $number_of_products = $select_products->rowCount();
        ?>
        <h3><?=  $number_of_products ?></h3>
        <p>Produtos Novos</p>
        <a href="admin_products.php" class="btn">Ver Produtos</a>
      </div>
      <div class="box">
        <?php
          $select_users = $conn->prepare("SELECT * FROM users WHERE  user_type = ?");
          $select_users->execute(['user']);
          $number_of_users = $select_users->rowCount();
        ?>
        <h3><?=  $number_of_users ?></h3>
        <p>Total de Usuários</p>
        <a href="admin_users.php" class="btn"> ver Usuários</a>
      </div>
      <div class="box">
        <?php
          $select_admin = $conn->prepare("SELECT * FROM users WHERE user_type = ?");
          $select_admin->execute(['admin']);
          $number_of_admin = $select_admin->rowCount();
        ?>
        <h3><?=  $number_of_admin ?></h3>
        <p>Total de Adminstradores</p>
        <a href="admin_users.php" class="btn"> ver Usuários</a>
      </div>
      <div class="box">
        <?php
          $select_accounts = $conn->prepare("SELECT * FROM users ");
          $select_accounts->execute();
          $number_of_accounts = $select_accounts->rowCount();
        ?>
        <h3><?=  $number_of_accounts ?></h3>
        <p>Total de Contas</p>
        <a href="admin_users.php" class="btn"> ver Contas</a>
      </div>
      <div class="box">
        <?php
          $select_messages = $conn->prepare("SELECT * FROM message");
          $select_messages->execute();
          $number_of_messages = $select_messages->rowCount();
        ?>
        <h3><?=  $number_of_messages ?></h3>
        <p>Total de Mensagens</p>
        <a href="admin_contacts.php" class="btn"> ver Mensagens</a>
      </div>
    </div>
  </section>
 
</body>
</html>