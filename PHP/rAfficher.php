
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

        if (isset($_POST['btnDeconnexion'])) {
            session_destroy();
            header('location: ../index.php');
        }

        //$rqt = $cnx->prepare("SELECT idProf, professeurs.nom , professeurs.prenom , professeurs.email FROM professeurs WHERE professeurs.email = '" . $_GET['email'] . "'");
        //$rqt->execute();
        //$res = $rqt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <form method="POST" action="pAccueil.php">
            <div align="right">
                <input type="submit" value="<?php echo $_SESSION['email'] ?>" name="btnUserName"><br>
                <input type="submit" value="deconnexion" name="btnDeconnexion">
            </div>
        </form>
        <?php
        include 'cnx.php';
        $rqt = $cnx->prepare("select libelleQuestionnaire FROM questionnaire where idQuestionnaire=".$_GET['idQuestionnaires']);
        $rqt->execute();
        echo "<h2>";
        foreach($rqt->fetchAll(PDO::FETCH_ASSOC) as $nomQuestionnaire)
        {
            echo "Les resultats du questionnaire: ".$nomQuestionnaire['libelleQuestionnaire'];
        }
        echo "</h2>";
        $sql = $cnx->prepare("select etudiants.idEtudiant, etudiants.nom, etudiants.prenom , qcmfait.dateFait, qcmfait.point from qcmfait, etudiants where etudiants.idEtudiant = qcmfait.idEtudiant AND qcmfait.idQuestionnaire=" . $_GET['idQuestionnaires']);
        $sql->execute();
        echo "<table class='table table-striped'>";
        foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $ligne) {
            echo "<tr>";
            echo "<td> <a href='eProfil.php?idEtudiants=" . $ligne['idEtudiant'] . "'>" . $ligne['nom'] . "</a> - " . $ligne['prenom'] . " - " . $ligne['dateFait'] . " - " . $ligne['point'] . "</td><br>";
            
            echo "</tr>";
        }
        echo "</table>";
        ?>

    </body>
</html>