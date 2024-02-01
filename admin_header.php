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

<header class="header">
    <div class="flex">
        <a href="admin_page.php" class="logo"><span>Painel</span> de Controle</a>
        <nav class="navbar">
            <a href="admin_page.php">Inicio</a>
            <a href="admin_products.php">Produtos</a>
            <a href="admin_orders.php">Pedidos</a>
            <a href="admin_users.php">Usuários</a>
            <a href="admin_contacts.php">Mensagens</a>
        </nav>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>
        <div class="profile">
            <?php
                $select_profile = $conn->prepare('SELECT * FROM users WHERE id =?');
                $select_profile->execute([$admin_id]);
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <img src="upload_img/<?= $fetch_profile['image'] ?>" alt="profile pic">
            <p><?= $fetch_profile['name'] ?></p>
            <a href="admin_update_profile.php" class="btn">Atualizar perfil</a>
            <a href="logout.php" class="delete-btn">Sair</a>
            <div class="flex-btn">
                <a href="login.php" class="option-btn">Login</a>
                <a href="register.php" class="option-btn">Registrar</a>
            </div>
        </div>
    </div>
</header>