<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>

<header>
    <div class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="index.php" class="navbar-brand">
                <strong>Tienda Online</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarHeader">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link active">Catálogo</a>
                    </li>
                    <li class="nav-item">
                        <a href="contacto.php" class="nav-link">Contacto</a>
                    </li>
                </ul>

                <form action="index.php" method="get" autocomplete="off">
                    <div class="input-group pe-3">
                        <input type="text" name="q" id="q" class="form-control form-control-sm" placeholder="Buscar..." aria-describedby="icon-buscar">
                        <button type="submit" id="icon-buscar" class="btn btn-outline-info"><i class="fas fa-search"></i></button>
                        
                    </div>
                </form>


                <a href="checkout.php" class="btn btn-primary me-2 btn-sm">
                    <i class="fa-solid fa-cart-shopping"></i>Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart ?></span>
                </a>

                <?php
                if (isset($_SESSION['user_id'])) { ?>
                    <div class="dropdown">
                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="btn_session" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i><?php echo $_SESSION['user_name'] ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btn_session">
                            <li><a class="dropdown-item" href="compras.php">Mis compras</a></li>
                            <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>

                        </ul>
                    </div>
                <?php } else { ?>
                    <a href="login.php" class="btn btn-success btn-sm"><i class="fas fa-user"></i> Ingresar</a>
                <?php } ?>
            </div>
        </div>
    </div>
</header>

<script src="js/all.min.js"></script>