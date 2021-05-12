<?php   //connection à la BDD
$mysqli = new mysqli("localhost", "labyrinthe", "labyrinthe", "labyrinthe");

if ($mysqli->connect_errno) {
    printf("Échec de la connexion : %s\n", $mysqli->connect_error);
    exit();
}

$mysqli -> query("USE labyrinte");
function insertUser($mysqli, $user) {       //Creation du user
    $sql = "INSERT INTO utilisateurs (nom) VALUES ('".$user."')";
        
    if ($mysqli->query($sql) === TRUE) {
    return $user;
    } else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}

function getUser($mysqli, $user) {      //affichage du user sur l'ecran
    $data = [];
    if ($result = $mysqli->query("SELECT * FROM utilisateurs WHERE nom = '".$user."'")) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row["nom"];
        }
        $result->close();
        if (count($data) === 0) {
            return NULL;
        }else {
            return $data[0];
        }
    }
}

$user = getUser($mysqli, $_POST['pseudo']);
if ( is_null($user)) {
    $user = insertUser($mysqli, $_POST["pseudo"]);
}
?>

<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Le Labyrinthe</title>
    <style>
        .page {
            background-image: url('image/page_index.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }

        .mur {
            background-image: url("image/mur.jpg");
        }

        .chemin {
            background-image: url("image/chemin.jpg");
        }

        .sortie {
            background-image: url("image/sortie.jpg");
        }

        .perso {
            background-image: url("image/perso.jpg");
        }

        td {
            width: 50px;
            height: 50px;
        }
    </style>

</head>

<body class="page">
    <div>
        <h1>Salut <?php echo($user) ?> !</h1>
        <form action="" method="POST">
            <input type="text" name="pseudo">
            <button type="submit">Changer de pseudo</button>
        </form>
    </div>
    <br>
    <div>
        <button type="submit">Recommencer</button>
    </div>
    <div>
        <?php
        $labyrinthe = fopen('labyrinthe.txt', 'r+');

        $tabLab = [];
        while (!feof($labyrinthe)) {
            $ligne = fgets($labyrinthe);
            $tabLab[] = explode(" ", $ligne);
        }
        // var_dump($tabLab);

        fclose($labyrinthe);
        ?>
        <table>
            <?php foreach ($tabLab as $ligne) : ?>
                <tr>
                    <?php foreach ($ligne as $case) : ?>
                        <?php if ($case == 0) : ?>
                            <td class="mur">
                            <?php endif; ?>
                            <?php if ($case == 1) : ?>
                            <td class="chemin">
                            <?php endif; ?>
                            <?php if ($case == 2) : ?>
                            <td class="sortie">
                            <?php endif; ?>
                            <?php if ($case == 3) : ?>
                            <td class="perso">
                            <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div>
        <button type="submit">Haut</button>
        <button type="submit">Bas</button>
        <button type="submit">Gauche</button>
        <button type="submit">Droite</button>
    </div>
</body>

</html>