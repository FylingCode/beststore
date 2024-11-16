<?php

session_start();

$authenticated = false ;

if(isset($_SESSION["email"])){
    $authenticated = true;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Store</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css
">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js
"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 my-5 bg-white rounded">
        <div class="container">
            <a class="navbar-brand" href="./index.php">🛒 K-STORE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="./index.php">Home</a>
                    </li>
                </ul>

                <?php
                  if($authenticated){
                    ?>
                    <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Admin
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="./profile.php">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="./logout.php">Log Out </a></li>
                        </ul>
                    </li>
                    </ul>
                <?php
                }else{
               ?>
                <ul class="navbar-nav">
                <li class="nav-item">
                        <a href="./register.php" class="btn btn-outline-primary me-2">Register</a>
                    </li>

                    <li class="nav-item">
                        <a href="./login.php" class="btn btn-primary " > LOGIN </a>
                    </li>

                </ul>
             <?php   } ?>
            </div>
        </div>
    </nav>
