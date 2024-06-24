<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tech Market</title>
    <link href="<?php echo ADMIN_URL; ?>css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">k
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="<?php echo ADMIN_URL?>inicio.php">Tech Market</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="d-none d-md-inline-block navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i><?php echo
                                                                                                                                                                                $_SESSION['user_name'] ?></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?php echo ADMIN_URL; ?>cambiar_password.php?id=<?php echo $_SESSION['user_id'] ?>">Cambiar Contraseña</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="logout.php">Cerrar Sesion</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <!-- <a class="nav-link" href="<?php //echo ADMIN_URL; ?>configuracion">
                            <div class="sb-nav-link-icon"><i class="fas fa-cog fa-2x"></i></div>
                            Configuración
                        </a> -->

                        <a class="nav-link" href="<?php echo ADMIN_URL; ?>categorias">
                            <div class="sb-nav-link-icon"><i class="fas fa-list-alt fa-2x"></i></div>
                            Categorías
                        </a>

                        <a class="nav-link" href="<?php echo ADMIN_URL; ?>productos">
                            <div class="sb-nav-link-icon"><i class="fas fa-box fa-2x"></i></div>
                            Productos
                        </a>

                        <a class="nav-link" href="<?php echo ADMIN_URL; ?>compras">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart fa-2x"></i></div>
                            Ventas
                        </a>

                        <!-- <a class="nav-link" href="<?php //echo ADMIN_URL; ?>usuarios">
                            <div class="sb-nav-link-icon"><i class="fas fa-users fa-2x"></i></div>
                            Usuarios
                        </a> -->

                        <a class="nav-link" href="<?php echo ADMIN_URL; ?>couriers">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-truck fa-2x"></i></div>
                            Couriers
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Usuario: <?php echo $_SESSION['user_name'] ?></div>
                    Tech Market
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">