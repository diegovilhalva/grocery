<?php
        if (isset($message)) {
            foreach ($message as $message) {
             echo '<div class="message">
                        <span>'.$message.'</span>
                        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                    </div>';
            };
        }; 
?>
<header class="header">
    <div class="flex">
        <a href="admin_page.php" class="logo"><span>Merc</span>.</a>
        <nav class="navbar">
            <a href="home.php">Inicio</a>
            <a href="shop.php">Produtos</a>
            <a href="orders.php">Pedidos</a>
            <a href="about.php">Sobre</a>
            <a href="contact.php">Contato</a>
        </nav>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <?php
                $count_cart_items =  $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
                $count_cart_items->execute([$user_id]);
                $count_wishlist_items =  $conn->prepare("SELECT * FROM wishlist WHERE user_id = ?");
                $count_wishlist_items->execute([$user_id]);
            ?>
            <a href="wishlist.php"><i class="fas fa-heart"></i> (<span><?= $count_wishlist_items->rowCount(); ?></span>)</a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i> (<span><?= $count_cart_items->rowCount(); ?></span>)</a>
            
        </div>
        <div class="profile">
            <?php
                $select_profile = $conn->prepare('SELECT * FROM users WHERE id =?');
                $select_profile->execute([$user_id]);
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <img src="upload_img/<?= $fetch_profile['image'] ?>" alt="profile pic">
            <p><?= $fetch_profile['name'] ?></p>
            <a href="user_profile_update.php" class="btn">Atualizar perfil</a>
            <a href="logout.php" class="delete-btn">Sair</a>
            <div class="flex-btn">
                <a href="login.php" class="option-btn">Login</a>
                <a href="register.php" class="option-btn">Registrar</a>
            </div>
        </div>
    </div>
</header>