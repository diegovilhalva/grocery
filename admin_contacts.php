<?php

include('config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $delete_message = $conn->prepare("DELETE FROM message WHERE id  = ?");
  $delete_message->execute([$delete_id]);
  header('location:admin_contacts.php');
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
    <title>Contatos</title>
</head>
<body>
  <?php
    include('admin_header.php');
  ?>
 
  <section class="messages">
      <h1 class="title">Mensagens</h1>
      <div class="box-container">
          <?php
            $select_message = $conn->prepare("SELECT * FROM message");
            $select_message->execute();  
            if ($select_message->rowCount() > 0) {
                while ($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)) {
                  
            
          ?>
          <div class="box">
            <p>Id do Usuário:<span><?= $fetch_message['user_id']; ?></span></p>
            <p>Nome: <span><?= $fetch_message['name'];?></span></p>
            <p>Telefone: <span><?= $fetch_message['number']; ?></span></p>
            <p>Email: <span><?= $fetch_message['email']; ?></span></p>
            <p>Mensagem:<span> <?= $fetch_message['message']; ?></span></p>
            <a href="admin_contacts.php?delete=<?= $fetch_message['user_id']; ?>" onclick="return confirm('Deletar essa mensagem ?')" class="delete-btn">Deletar</a>
          </div>
          <?php
                  }
            }else {
              echo ' <p class="empty">Ainda não há Mensagens!</p> ';
            }
          ?>
      </div>

  </section>
 
</body>
</html>