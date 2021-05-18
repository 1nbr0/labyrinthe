<?php   //connection à la BDD  en session pour pouvoir eviter de la re ecrire dans chaque fonction
session_start();

// Recuperation du fichier labyrinthe.txt puis mise en tableau multidimensionnel pour affichage html
$tabLab = [];
$labyrinthe = fopen('labyrinthe.txt', 'r+');
if ($labyrinthe) {
    $a = 0;
    $b = 0;
    while (!feof($labyrinthe)) {
        $ligne = fgets($labyrinthe);
        for ($i = 0; $i < strlen($ligne); $i++) {
            if($ligne[$i] != "\n" && $ligne[$i] != " ") {
                $tabLab[$a][$b] = $ligne[$i];
                $b++;
            }
        }
        $a++;
        $b = 0;
    }
    // var_dump($tabLab);
    fclose($labyrinthe);
}

// $lab = [];
// $fh = fopen("lab.txt", "r");
// if ( $fh ) {
//     $a = 0;
//     $b = 0;
//     while ( !feof($fh) ) {
//         $line = fgets($fh);
//         for ($i = 0; $i < strlen($line); $i++) {
//             if($line[$i] != "\n") {
//                 $lab[$a][$b] = $line[$i];
//                 $b++;
//             }
//         }
//         $a++;
//         $b = 0;
//     }
//     fclose($fh);
//     dd($lab);
// }

?>

<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Le Labyrinthe</title>
    <link href="style.css" rel="stylesheet" type="text/css" />

</head>

<body class="page">
    <div class="title">
        <!-- <h1>Salut <?php echo ($joueur) ?> ! Echappe toi si tu peux ...</h1> -->
        <form action="" method="POST">
            <input type="text" name="pseudo">
            <button type="submit" name="nickname_change">Changer de pseudo</button>
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