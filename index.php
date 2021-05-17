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
    <link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body class="page">
    <div class="titre">
        <h1>Bonjour, bienvenue dans le jeu du Labyrinthe.</h1>
        <h2>Choisir votre pseudo pour commencer le jeu :</h2>
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