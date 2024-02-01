<?php

include('config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $delete_users = $conn->prepare("DELETE FROM users WHERE id  = ?");
  $delete_users->execute([$delete_id]);
  header('location:admin_users.php');
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
    <title>Usuários</title>
</head>
<body>
  <?php
    include('admin_header.php');
  ?>
  <section class="user-accounts">
    <h1 class="title">Gerenciar Usuários</h1>
    <div class="box-container">
      <?php
        $select_users = $conn->prepare("SELECT * FROM users");
        $select_users->execute();
        while ($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC) ) {     
      ?>
      <div class="box" style="<?php  if ($fetch_users['id'] == $admin_id) {
        echo 'display:none';
      } ?>">
          <img src="upload_img/<?= $fetch_users['image']?>" alt="user img">
          <p>Id do usuário: <span><?= $fetch_users['id']?></span></p>
          <p>Nome do usuário: <span><?= $fetch_users['name']?></span></p>
          <p>Email: <span><?= $fetch_users['email']?></span></p>
          <p>Tipo de conta: <span style="color:<?php  if($fetch_users['user_type'] == 'admin'){ echo 'orange'; } ?>;"><?= $fetch_users['user_type']?></span></p>
          <a href="admin_users.php?delete=<?= $fetch_users['id'] ?>" onclick="return confirm('Deletar usuário?');" class="delete-btn">Deletar</a>
      </div>
      <?php
        }   
      ?>
    </div>
  </section>
 
</body>
</html>