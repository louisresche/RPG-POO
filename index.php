<!DOCTYPE html>
<html lang="en">
<head>
    <title>RPG-POO</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">


    <?php

    function chargerClasse($classname)
    {
        require $classname.'.php';
    }

    spl_autoload_register('chargerClasse');

    session_start();

    if (isset($_GET['deconnexion'])){
        session_destroy();
        header('Location: .');
        exit();
    }

    if (isset($_SESSION['perso'])){
        $perso = $_SESSION['perso'];
    }

    $db = new PDO('mysql:host=localhost;dbname=php_tp1','root','');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $manager = new PersonnagesManager($db);

    if (isset($_POST['creer']) && isset($_POST['nom'])){
        $perso = new Personnage(['nom' => $_POST['nom']]);

        if (!$perso->nomValide()){
            $message = 'Le nom choisi est invalide.';
            unset($perso);
        } elseif ($manager->exists($perso->nom())){
            $message = 'Le nom du personnage est déjà pris.';
            unset($perso);
        } else {
            $manager->add($perso);
        }

    } elseif (isset($_POST['utiliser']) && isset($_POST['nom'])){
        if ($manager->exists($_POST['nom']))
        {
            $perso = $manager->get($_POST['nom']);
        } else {
            $message = 'Ce personnage n\'existe pas !';
        }

    } elseif (isset($_GET['frapper'])){

        if (!isset($perso)){
            $message = 'Merci de créer un personnage ou de vous identifier.';
        } else {
            if (!$manager->exists((int) $_GET['frapper'])){
                $message = 'Le personnage que vous voulez frapper n\'existe pas!';
            } else {

                $persoAFrapper = $manager->get((int) $_GET['frapper']);
                $retour = $perso->frapper($persoAFrapper);

                switch($retour)
                {
                    case Personnage::CEST_MOI :
                        $message = 'Mais... pouquoi voulez-vous vous frapper ???';
                        break;
                    case Personnage::PAS_AUJOURDHUI :
                        $message = 'Vous avais déjà frappé 3 fois aujourd\'hui. Revenez demain !';
                        break;
                    case Personnage::PERSONNAGE_FRAPPE :
                        $message = 'Le personnage a bien été frappé !';

                        $perso->gagnerExperience();

                        $manager->update($perso);
                        $manager->update($persoAFrapper);

                        break;
                    case Personnage::PERSONNAGE_TUE;
                        $message = 'Vous avez tué ce personnage !';

                        $perso->gagnerExperience();

                        $manager->update($perso);
                        $manager->delete($persoAFrapper);

                        break;
                }
            }
        }
    }

    $manager = new MonstresManager($db);

    if (isset($_POST['creer']) && isset($_POST['nom'])){
        $monster = new Monstre(['nom' => $_POST['nom']]);

        if (!$monster->nomValide()){
            $message = 'Le nom choisi est invalide.';
            unset($monster);
        } elseif ($manager->exists($monster->nom())){
            $message = 'Le nom du monstre est déjà pris.';
            unset($monster);
        } else {
            $manager->add($monster);
        }

    } elseif (isset($_POST['utiliser']) && isset($_POST['nom'])){
        if ($manager->exists($_POST['nom']))
        {
            $monster = $manager->get($_POST['nom']);
        } else {
            $message = 'Ce monstre n\'existe pas !';
        }

    } elseif (isset($_GET['frapper'])){

        if (!isset($monster)){
            $message = 'Merci de créer un monstre ou de vous identifier.';
        } else {
            if (!$manager->exists((int) $_GET['frapper'])){
                $message = 'Le Monstre que vous voulez frapper n\'existe pas!';
            } else {

                $monsterAFrapper = $manager->get((int) $_GET['frapper']);
                $retour = $monster->frapper($monsterAFrapper);

                switch($retour)
                {
                    case Monstre::CEST_MOI :
                        $message = 'Mais... pouquoi voulez-vous vous frapper ???';
                        break;
                    case Monstre::PAS_AUJOURDHUI :
                        $message = 'Vous avais déjà frappé 3 fois aujourd\'hui. Revenez demain !';
                        break;
                    case Monstre::MONSTRE_FRAPPE :
                        $message = 'Le Monstre a bien été frappé !';

                        $monster->gagnerExperience();

                        $manager->update($monster);
                        $manager->update($monsterAFrapper);

                        break;
                    case Monstre::MONSTRE_TUE;
                        $message = 'Vous avez tué ce Monstre !';

                        $monster->gagnerExperience();

                        $manager->update($monster);
                        $manager->delete($monsterAFrapper);

                        break;
                }
            }
        }
    }
    ?>


    <p> Nombre de personnages créés : <?= $manager->count() ?></p>
    <?php
    if (isset($message)){
        echo '<p>'. $message . '</p>';
    }

    if (isset($perso)){
        ?>

        <p><a href="?deconnexion=1">Déconnexion</a></p>

        <fieldset>
            <legend>Mes informations</legend>
            <p>
                Nom : <?=  htmlspecialchars($perso->nom()) ?><br />
                PV : <?= $perso->pv() ?>
                Expérience : <?= $perso->experience() ?>
                Niveau : <?= $perso->niveau() ?>
                Nombre des coups : <?= $perso->nbCoups() ?>

            </p>
        </fieldset>
        <fieldset>
            <legend>Qui frapper?</legend>
            <p>
                <?php

                $persos = $manager->getList($perso->nom());
                if (empty($persos)) {
                    echo 'Personne à frapper!';
                } else {
                    foreach($persos as $unPerso){
                        echo '<a href="?frapper='.$unPerso->id().'">'.htmlspecialchars($unPerso->nom()).'</a> (pv : '.$unPerso->pv().', expérience : '.$unPerso->experience().', niveau : '.$unPerso->niveau().', nombre des coups : '.$unPerso->nbCoups().'<br />';

                    }
                }

                ?>
            </p>
        </fieldset>


        <?php

    } else {

        ?>
        <form action="" method = "post">
            <p>
                Nom : <input type="text" name="nom" maxlength="50" />
                <input type="submit" value = "Créer ce personnage" name="creer" />
                <input type="submit" value = "Utiliser ce personnage" name="utiliser" />
            </p>
        </form>
        <?php
    }
    ?>



    <p> Nombre de monstres créés : <?= $manager->count() ?></p>
    <?php
    if (isset($message)){
        echo '<p>'. $message . '</p>';
    }

    if (isset($monster)){
        ?>

        <p><a href="?deconnexion=1">Déconnexion</a></p>

        <fieldset>
            <legend>Mes informations</legend>
            <p>
                Nom : <?=  htmlspecialchars($monster->nom()) ?><br />
                PV : <?= $monster->pv() ?>
                Expérience : <?= $monster->experience() ?>
                Niveau : <?= $monster->niveau() ?>
                Nombre des coups : <?= $monster->nbCoups() ?>

            </p>
        </fieldset>
        <fieldset>
            <legend>Qui frapper?</legend>
            <p>
                <?php

                $monsters = $manager->getList($monster->nom());
                if (empty($monsters)) {
                    echo 'Pas de monstre  à frapper!';
                } else {
                    foreach($monsters as $unmonster){
                        echo '<a href="?frapper='.$unmonster->id().'">'.htmlspecialchars($unmonster->nom()).'</a> (pv : '.$unmonster->pv().', expérience : '.$unmonster->experience().', niveau : '.$unmonster->niveau().', nombre des coups : '.$unmonster->nbCoups().'<br />';

                    }
                }

                ?>
            </p>
        </fieldset>


        <?php

    } else {

        ?>
        <form action="" method = "post">
            <p>
                Nom : <input type="text" name="nom" maxlength="50" />
                <input type="submit" value = "Créer ce Monstre" name="creer" />
                <input type="submit" value = "Utiliser ce Monstre" name="utiliser" />
            </p>
        </form>
        <?php
    }
    ?>



</div>
</body>
</html>
<?php
if (isset($perso)){
    $_SESSION['perso'] = $perso;
}
?>