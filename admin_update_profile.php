<?php

include('config.php');
session_start();

$admin_id = $_SESSION['admin_id'];


if (!isset($admin_id)) {
    header('location:login.php');
}
if (isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $update_profile= $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $update_profile->execute([$name, $email, $admin_id]);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'upload_img/'.$image;
    $old_image = $_POST['old_image'];
    
    if (!empty($image)) {
        if ($image_size > 2000000) {
            $message[] = 'imagem muito grande!';
        }else {
          
            $update_image= $conn->prepare("UPDATE users SET image = ? WHERE id = ?");
            $update_image->execute([$image, $admin_id]);
            if ($update_image) {
                move_uploaded_file($image_tmp_name, $image_folder);
                unlink('upload_img/'.$old_image);
                $message[] = 'Foto atualiada com sucesso!';

                
            };
        };
    };

    $old_pass = $_POST['old_pass'];
    $update_pass = md5('update_pass');
    $update_pass = filter_var($update_pass, FILTER_SANITIZE_STRING);
    $new_pass = md5('new_pass');
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = md5('confirm_pass');
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);
    if (!empty($update_pass) OR !empty($new_pass) OR !empty($confirm_pass)) {
        if($update_pass != $old_pass){
            $message[] = 'Senha incompatível';
        }elseif($new_pass != $confirm_pass){
            $message[] = 'as senhas não batem';
        }else {
            $update_pass_query = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update_pass_query->execute([$confirm_pass, $admin_id]);
            $message[] = 'Senha Atualizada com sucesso!';
        };

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
    <link rel="stylesheet" href="css/components.css">
    <script src="js/script.js" defer></script>
    <title>Atualizar Perfil</title>
</head>
<body>
  <?php include('admin_header.php');  ?>
  <section class="update-profile">
    <h2 class="title">Atualizar Perfil</h2>
   
    <form action="" method="post" enctype="multipart/form-data">
        <img src="upload_img/<?= $fetch_profile['image']; ?>" alt="profile pic">
        <div class="flex">
            <div class="inputBox">
                <span>Nome do  Usuário:</span>
                <input type="text" name="name" placeholder="atualizar nome" value="<?= $fetch_profile['name'];?>"  class="box">
                <span>Email do  Usuário:</span>
                <input type="email" name="email" placeholder="atualizar email" value="<?= $fetch_profile['email'];?>"  class="box">
                <span>Atualizar foto de perfil  :</span>
                <input type="file" name="image"  accept="image/jpg, image/jpeg, image/png"  class="box">
                <input type="hidden" name="old_image" value="<?= $fetch_profile['image']; ?>"> 
            </div>
            <div class="inputBox">
                <input type="hidden" name="old_pass"  value="<?= $fetch_profile['password'];?>">
                <span>Senha Atual:</span>
                <input type="password" name="update_pass" placeholder="digite a senha atual"   class="box">
                <span>Nova Senha:</span>
                <input type="password" name="new_pass" placeholder="digite a nova senha"   class="box">
                <span> Comfirme a Nova Senha:</span>
                <input type="password" name="confirm_pass" placeholder="confirme a nova senha"   class="box">
            </div>
        </div>
        <div class="flex">
            <input type="submit" value="atualizar" class="btn" name="update-profile">
            <a href="admin_page.php" class="option-btn">Voltar</a>
        </div>
    </form>
  </section>
 
</body>
</html>