<?php
    include('config.php');
    if (isset($_POST['submit'])) {
       $name = $_POST['name'];
       $name = filter_var($name, FILTER_UNSAFE_RAW);
       $email = $_POST['email'];
       $email = filter_var($email, FILTER_UNSAFE_RAW);
       $pass = md5($_POST['pass']);
       $pass = filter_var($pass, FILTER_UNSAFE_RAW);
       $cpass = md5($_POST['cpass']);
       $cpass = filter_var($cpass, FILTER_UNSAFE_RAW);


       $image = $_FILES['image']['name'];
       $image_size = $_FILES['image']['size'];
       $image_tmp_name = $_FILES['image']['tmp_name'];
       $image_folder = 'upload_img/'.$image;

       $select = $conn->prepare("SELECT * FROM `users` WHERE email = :email LIMIT 1");
       $select->bindParam(':email',$email);
       $select->execute();

       if ($select->rowCount() > 0) {
            $message[] = 'este usuário de email ja existe!';
       }else{
            if ($pass != $cpass) {
                $message[] = 'as senhas  não são iguais!';
            }else {
                $insert = $conn->prepare("INSERT INTO users(name,email,password,image)
                VALUES (?,?,?,?)");
                $insert->execute([$name, $email, $pass, $image]);
                if ($insert) {
                    if($image_size > 2000000){
                        $message[] = 'imagem muito grande';
                    }else {
                        move_uploaded_file($image_tmp_name, $image_folder);
                        $message[] = 'Registrado com sucesso!';
                        header('location:login.php');
                    }
                }
            }

       }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registre-se agora</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/components.css">
</head>
<body>
   
    <?php
        if (isset($message)) {
            foreach ($message as $message) {
             echo '<div class="message">
                        <span>'.$message.'</span>
                        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                    </div>';
            }
        } 
    ?>
    <section class="form-container">
        <form action="" enctype="multipart/form-data" method="post">
            <h3>Crie uma conta agora!</h3>
            <input type="text" name="name" class="box" placeholder="digite o seu nome" required>
            <input type="email" name="email" class="box" placeholder="digite o seu email" required>
            <input type="password" name="pass" class="box" placeholder="digite uma senha" required>
            <input type="password" name="cpass" class="box" placeholder="confirme a senha" required>
            <input type="file" name="image" class="box" required accept="image/jpg,image/jpeg, image/png">
            <input type="submit" value="registrar" class="btn" name="submit">
            <p>Já possui uma conta? <a href="login.php">Criar Conta</a></p>
        </form>
    </section>
</body>
</html>