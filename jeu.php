<?php   //connection à la BDD  en session pour pouvoir eviter de la re ecrire dans chaque fonction
session_start();
$_SESSION['mysqli'] = new mysqli("localhost", "labyrinthe", "labyrinthe", "labyrinthe");

if ($_SESSION['mysqli']->connect_errno) {
    printf("Échec de la connexion : %s\n", $_SESSION['mysqli']->connect_error);
    exit();
}

if (isset($_POST['pseudo']) and !empty($_POST['pseudo'])) {
    $_SESSION['pseudo'] = $_POST['pseudo'];
}
// Recuperation du fichier labyrinthe.txt puis mise en tableau multidimensionnel pour affichage html
$tabLab = [];
$labyrinthe = fopen('labyrinthe.txt', 'r+');
if ($labyrinthe) {
    $a = 0;
    $b = 0;
    while (!feof($labyrinthe)) {
        $ligne = fgets($labyrinthe);
        for ($i = 0; $i < strlen($ligne); $i++) {
            if ($ligne[$i] != "\n" && $ligne[$i] != " ") {
                $tabLab[$a][$b] = $ligne[$i];
                $b++;
            }
        }
        $a++;
        $b = 0;
    }
    fclose($labyrinthe);
}
function gererDirections($tabLab) {
    if(array_key_exists('haut', $_POST)){
        haut($tabLab);
    } else if (array_key_exists('bas', $_POST)) {
        bas($tabLab);
    }else if (array_key_exists('gauche', $_POST)) {
        gauche($tabLab);
    } else if (array_key_exists('droite', $_POST)) {
        droite($tabLab);
    }
}

function findJoueur($tabLab) {
    $i = 0;
    foreach ($tabLab as $key => $ligne) {
        foreach ($ligne as $key2 => $case) {
            if ($key = array_search("3", $case)) {
                return [$key, $i];
            } else if ($key2 = array_search("3", $case)) {
                return [$i, $key2];
            }
            $i++;
        }
    }
}

function haut($tabLab)  {
    echo"Vers le haut";
    $key = findJoueur($tabLab);
    $key2 = findJoueur($tabLab);
    if ($tabLab[$key[0] - 1][$key2[1]] == "v") {
        $tabLab[$key[0]][$key2[1]] = "v";
        $tabLab[$key[0] - 1][$key2[1]] = "j";
    }
    modifBDD($tabLab);
}

function bas($tabLab)  {
    echo"Vers le bas";
    $key = findJoueur($tabLab);
    $key2 = findJoueur($tabLab);
    if ($tabLab[$key[0] + 1][$key2[1]] == "v") {
        $tabLab[$key[0]][$key2[1]] = "v";
        $tabLab[$key[0] - 1][$key2[1]] = "j";
    }
    modifBDD($tabLab);
}

function gauche($tabLab)  {
    echo"Vers la gauche";
    $key = findJoueur($tabLab);
    $key2 = findJoueur($tabLab);
    if ($tabLab[$key[0]][$key2[1] - 1] == "v") {
        $tabLab[$key[0]][$key2[1]] = "v";
        $tabLab[$key[0]][$key2[1] - 1] = "j";
    }
    modifBDD($tabLab);
}

function droite($tabLab)  {
    echo"Vers la droite";
    $key = findJoueur($tabLab);
    $key2 = findJoueur($tabLab);
    if ($tabLab[$key[0]][$key2[1] + 1] == "v") {
        $tabLab[$key[0]][$key2[1]] = "v";
        $tabLab[$key[0]][$key2[1] + 1] = "j";
    }
    modifBDD($tabLab);
}



// y, x, case
// 0, 0, x
// 0, 1, x
// ..., ..., ...
// 14, 1, x
if ($reponse = $_SESSION['mysqli']->query("SELECT y, x, case FROM jeu")) {
    while ($row = $reponse->fetch_assoc()) {
        $tabLab[] = str_split($row['case']);
    }
}

function modifBDD($tabLab)
{
    foreach ($tabLab as $ligne) {
        $query = "TRUNCATE TABLE jeu";
        $_SESSION['mysqli']->query($query);
    }
    foreach ($tabLab as $key => $ligne) {
        foreach ($ligne as $key2 => $case) {
            if ($case == "8" || $case == "1" || $case=="3" || $case=="2") {
                $query = "INSERT INTO jeu (`y`, `x`, `case`) VALUES (?, ?, ?)";
                $stmt = $_SESSION['mysqli']->prepare($query);
                $stmt->bind_param("iis", $key, $key2, $case);
                $stmt->execute();
            }
        }
    }
}
// modifBDD($tabLab);
?>

<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Le Labyrinthe</title>
    <link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body class="page">
    <div class="title">
        <h1>Salut <?php echo $_SESSION['pseudo']; ?> ! Echappe toi si tu peux ...</h1>
        <form action="" method="POST">
            <input type="text" name="pseudo" placeholder="Changer de Pseudo">
            <input type="submit" name="nickname" value="Valider le changement">
        </form>
    </div>
    <div class="restart">
        <a href="index.php">
            <button type="submit">Recommencer</button>
        </a>
    </div>
    <div class="laby">
        <table>
            <?php foreach ($tabLab as $ligne) : ?>
                <tr>
                    <?php foreach ($ligne as $case) : ?>
                        <?php if ($case == 8) : ?>
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