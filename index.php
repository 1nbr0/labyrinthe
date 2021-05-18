<?php
session_start();
if (!(isset($_SESSION['mysqli']))) {
    $_SESSION['mysqli']= new mysqli("localhost", "labyrinthe", "labyrinthe", "labyrinthe");
}

if ($_SESSION['mysqli']->connect_errno) {
    printf("Échec de la connexion : %s\n", $_SESSION['mysqli']->connect_error);
    exit();
}

if(isset($_POST['pseudo']) AND !empty($_POST['pseudo'])) {
    $_SESSION['pseudo'] = $_POST['pseudo'];
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
        <form action="jeu.php" method="POST">
                <input type="text" name="pseudo" placeholder="Pseudo">
                <input type="submit" name="value" value="Selectionner ce Pseudo">
        </form>
    </div>
</body>

</html>