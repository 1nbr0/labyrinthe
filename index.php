<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Le Labyrinthe</title>
    <style>
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

<body>
    <h1>Bonjour, bienvenue dans le jeu du Labyrinthe.</h1>
    <div>
        <h2>Choix du pseudo :</h2>
        <form action="" method="POST">
            <input type="text" name="pseudo">
            <button type="submit">Confirmer votre pseudo et commencer le jeu</button>
        </form>
        <br>
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