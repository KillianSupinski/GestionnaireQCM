<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="../JQuery/jquery-3.1.1.min.js"></script>
        <script src="../Bootstrap/js/bootstrap.min.js"></script>
        <script src="../Bootstrap/js/bootstrap.js"></script>
        <link href="../Bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../Bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
        session_start();
        include 'cnx.php';

        $email = $_SESSION['email'];
        $sql = $cnx->prepare("select idProf, nom, prenom from professeurs where email='" . $email . "'");
        $sql->execute();
        foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $session) {
            $_SESSION['idProfesseur'] = $session['idProf'];
            $_SESSION['nom'] = $session['nom'];
            $_SESSION['prenom'] = $session['prenom'];
        }
        include 'cnx.php';
        if (isset($_POST['btnDeconnexion'])) {
            session_destroy();
            header('location: ../index.php');
        }

        //$rqt = $cnx->prepare("SELECT idProf, professeurs.nom , professeurs.prenom , professeurs.email FROM professeurs WHERE professeurs.email = '" . $_GET['email'] . "'");
        //$rqt->execute();
        //$res = $rqt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <form method="POST">
            <div align="right">
                <input type="submit" value="<?php echo $_SESSION['email']; ?>" name="btnUserName"><br>
                <input type="submit" value="deconnexion" name="btnDeconnexion">
            </div>
            <h1 align="center">Bonjour <?php echo $_SESSION['prenom'] ?></h1>
            <div align="center">
                <a href="gAccueil.php">Acceder au gestionnaire de création - </a>   
                <a href="rAccueil.php">Accedez aux résultats des élèves</a><br>
            </div>
        </form>
    </body>
</html>
