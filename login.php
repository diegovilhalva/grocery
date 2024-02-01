<?php
    include('config.php');
    session_start();
    if (isset($_POST['submit'])) {
    
       $email = $_POST['email'];
       $email = filter_var($email, FILTER_SANITIZE_STRING);
       $pass = md5($_POST['pass']);
       $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    

       $select = $conn->prepare("SELECT * FROM users WHERE email =? AND password =?");
       $select->execute([$email,$pass]);
       $row = $select->fetch(PDO::FETCH_ASSOC);

       if ($select->rowCount() > 0) {
             if ($row['user_type'] == 'admin') {
                $_SESSION['admin_id'] = $row['id'];
                header('location:admin_page.php');
             }elseif ($row['user_type'] == 'user') {
                $_SESSION['user_id'] = $row['id'];
                header('location:home.php');
             }else {
                $message[] = 'Usuário não encontrado';
             }
       }else {
        $message[] = 'Email ou senha incorreta';    
       }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            <h3>Faça o seu Login agora!</h3>
            <input type="email" name="email" class="box" placeholder="digite o seu email" required>
            <input type="password" name="pass" class="box" placeholder="digite uma senha" required>
            <input type="submit" value="Login" class="btn" name="submit">
            <p>ainda não possui uma conta? <a href="register.php">Registre-se</a></p>
        </form>
    </section>
</body>
</html>