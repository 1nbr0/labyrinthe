<?php
session_start();
if (!(isset($_SESSION['mysqli']))) {
    $_SESSION['mysqli']= new mysqli("localhost", "labyrinthe", "labyrinthe", "labyrinthe");
}


if ($_SESSION['mysqli']->connect_errno) {
    printf("Échec de la connexion : %s\n", $_SESSION['mysqli']->connect_error);
    exit();
}
?>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Le Labyrinthe</title>
    <style>
        body {
            margin: auto;
        }

        div {
            font-family: Helvetica;
            display: block;
        }

        h1 {
            display: block;
            font-weight: bold;
        }

        .page {
            background-image: url('image/page_index.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }

        .titre {
            text-align: center;
            padding: 400px;
        }
    </style>

</head>

<body class="page">
    <div class="titre">
        <h1>Bonjour, bienvenue dans le jeu du Labyrinthe.</h1>
        <h2>Choix du pseudo :</h2>
        <!-- formulaire pseudo -->
        <form action="jeu.php" method="post">
            <div>
                <input type="text" name="pseudo">
                <button type="submit" name="nickname">Selectionner ce surnom</button>
            </div>
        </form>
    </div>
</body>

</html>