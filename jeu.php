<?php   //connection à la BDD  en session pour pouvoir eviter de la re ecrire dans chaque fonction
session_start();
$_SESSION['mysqli'] = new mysqli("localhost", "labyrinthe", "labyrinthe", "labyrinthe");
$_SESSION['joueur_id'] = $_SESSION['mysqli']->query("INSERT INTO jeu (joueur_id) VALUES ()");


if ($_SESSION['mysqli']->connect_errno) {
    printf("Échec de la connexion : %s\n", $_SESSION['mysqli']->connect_error);
    exit();
}

$_SESSION['mysqli']->query("USE labyrinte");
function insertJoueur($joueur)
{       //Creation du Joueur
    $sql = "INSERT INTO joueur (nom) VALUES ('" . $joueur . "')";

    if ($_SESSION['mysqli']->query($sql) === TRUE) {
        return $joueur;
    } else {
        echo "Error: " . $sql . "<br>" . $_SESSION['mysqli']->error;
    }
}

function getJoueur($joueur)
{      //affichage du joueur sur l'ecran
    $data = [];
    if ($result = $_SESSION['mysqli']->query("SELECT * FROM joueur WHERE nom = '" . $joueur . "'")) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row["nom"];
        }
        $result->close();
        if (count($data) === 0) {
            return NULL;
        } else {
            return $data[0];
        }
    }
}

$joueur = getJoueur($_POST['pseudo']);
if (is_null($joueur)) {
    $joueur = insertJoueur($_POST["pseudo"]);
}

function modifBDD($tabLab) {
    $hauteur = 0;
    foreach($tabLab as $ligne){
        $lignestr = implode($ligne);
        $query = "INSERT INTO jeu (joueur_id, hauteur, ligne) VALUES (?, ?, ?)";
        $stmt = $_SESSION['mysqli']->prepare($query);
        $stmt->bind_param("");
    }
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

        .title {
            text-align: center;
        }

        .restart {
            text-align: center;
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

        .laby {
            margin-left: 650px;
        }

        .direction {
            margin-left: 950px;
        }

        .flecheHaut {
            margin-left: 62px;
            margin-bottom: 6px;
        }
    </style>

</head>

<body class="page">
    <div class="title">
        <h1>Salut <?php echo ($joueur) ?> ! Echappe toi si tu peux ...</h1>
        <form action="" method="POST">
            <input type="text" name="pseudo">
            <button type="submit">Changer de pseudo</button>
        </form>
    </div>
    <br> <br> <br> <br> <br>
    <div class="restart">
        <a href="index.php">
            <button type="submit">Recommencer</button>
        </a>
    </div>
    <br>
    <div class="laby">
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
    <div class="direction">
        <form method="post">
            <div class="flecheHaut"> <input type="submit" name="haut" class="button" value="haut" /></div>
            <input type="submit" name="gauche" class="button" value="gauche" />
            <input type="submit" name="bas" class="button" value="bas" />
            <input type="submit" name="droite" class="button" value="droite" />
        </form>
    </div>
</body>

</html>