<!DOCTYPE html>
<html lang="fr">

<HEAD>
    <meta charset="utf-8" />
    <style>
        .mur {
            background-color: green;
        }

        .chemin {
            background-color: orange;
        }
        td {
            width: 20px;
            height: 20px;
        }
    </style>

</HEAD>

<body>
    <div>
        <?php
            $labyrinthe = fopen('labyrinthe.txt', 'r+');

            $tabLab = [];
            while(!feof($labyrinthe)) {
                $ligne = fgets($labyrinthe);
                $tabLab[] = explode(" ", $ligne);
                echo $ligne . "<br />";
            }
            // var_dump($tabLab);

            fclose($labyrinthe);
        ?>
        <table>
            <?php foreach( $tabLab as $ligne) :?>
                <tr>
                    <?php foreach( $ligne as $case) :?>
                        <?php if($case == 0) :?>
                            <td class="mur">
                        <?php endif; ?>
                        <?php if($case == 1) :?>
                            <td class="chemin">
                        <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>