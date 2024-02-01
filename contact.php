<?php

include('config.php');
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
};
if (isset($_POST['send'])) {
    
    $name =  $_POST['name'];
    $name = filter_var($name,FILTER_SANITIZE_STRING);
    $email =  $_POST['email'];
    $email = filter_var($email,FILTER_SANITIZE_STRING);
    $number =  $_POST['number'];
    $number = filter_var($number,FILTER_SANITIZE_STRING);
    $msg =  $_POST['msg'];
    $msg = filter_var($msg,FILTER_SANITIZE_STRING);

    $select_message = $conn->prepare("SELECT * FROM message WHERE name = ?,  email = ?,number = ?, message = ?");
    $select_message->execute([$name,$email,$number,$msg]);

    if ($select_message->rowCount() > 0) {
        $message[] = 'Mensagem já enviada';    
    }else {
        
        $insert_message = $conn->prepare("INSERT INTO message (user_id,name,email,number,message) VALUES (?,?,?,?,?)");
        $insert_message->execute([$user_id,$name,$email,$number,$msg]);

        $message[] = 'Mensagem enviada com sucesso!';
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
    <title>Contato</title>
</head>
<body>

    <?php include('header.php'); ?>
    <section class="contact">
        <h1 class="title">Fale Conosco</h1>
        <form action="" method="post">
            <input type="text" name="name" class="box" required placeholder="Digite seu nome">
            <input type="email" name="email" class="box" required placeholder="Digite seu e-mail">
            <input type="number" name="number" min="0"  class="box" required placeholder="Digite seu número">
            <textarea name="msg" class="box" cols="30" required rows="10" placeholder="Digite sua mensagem"></textarea>
            <input type="submit" value="Enviar mensagem" class="btn" name="send">
        </form>
    </section>















    <?php include('footer.php') ?>
</body>
</html>