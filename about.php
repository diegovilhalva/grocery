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
    <title>Sobre</title>
</head>
<body>

    <?php include('header.php'); ?>
    <section class="about">
        <div class="row">
            <div class="box">
                <img src="img/about-img-1.png" alt="about-img 1">
                <h3>Quem Somos ?</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quasi optio possimus odit voluptates fuga quae, quos deserunt reprehenderit vero praesentium odio consequatur officiis? Laboriosam incidunt culpa iste cum dolorum maxime.</p>
                <a href="contact.php" class="btn">Entre em contato</a>
            </div>
            <div class="box">
                <img src="img/about-img-2.png" alt="about-img 2">
                <h3>Quais as vantagens ?</h3>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quasi optio possimus odit voluptates fuga quae, quos deserunt reprehenderit vero praesentium odio consequatur officiis? Laboriosam incidunt culpa iste cum dolorum maxime.</p>
                <a href="shop.php" class="btn">Veja Nossas Ofertas </a>
            </div>
        </div>
    </section>
    <section class="reviews">
        <h1 class=title>Opinião dos nossos clientes</h1>
        <div class="box-container">
            <div class="box">
                <img src="img/pic-1.png" alt="Client Review">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id rerum ullam doloremque nam libero ea.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>João Da Silva</h3>
            </div>
            <div class="box">
                <img src="img/pic-2.png" alt="Client Review">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id rerum ullam doloremque nam libero ea.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>João Da Silva</h3>
            </div>
            <div class="box">
                <img src="img/pic-3.png" alt="Client Review">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id rerum ullam doloremque nam libero ea.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>João Da Silva</h3>
            </div>
            <div class="box">
                <img src="img/pic-4.png" alt="Client Review">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id rerum ullam doloremque nam libero ea.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>João Da Silva</h3>
            </div>
            <div class="box">
                <img src="img/pic-5.png" alt="Client Review">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id rerum ullam doloremque nam libero ea.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>João Da Silva</h3>
            </div>
            <div class="box">
                <img src="img/pic-6.png" alt="Client Review">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id rerum ullam doloremque nam libero ea.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>João Da Silva</h3>
            </div>
        </div>
    </section>














    <?php include('footer.php') ?>
</body>
</html>