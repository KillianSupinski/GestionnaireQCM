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
        <form method="POST" action="eAccueil.php">
            <div align="right">
                <input type="submit" value='Home'name="btnUserName"><br>
                <input type="submit" value="deconnexion" name="btnDeconnexion">
            </div>
        </form>
        <h1 align='center'>Profil de l'élève</h1>
        <br>
        <?php
        echo $_SESSION['nom'] . "<br>";
        echo $_SESSION['prenom'];
        ?>

        <?php
        include 'cnx.php';

        $sql = $cnx->prepare("select questionnaire.libelleQuestionnaire, etudiants.idEtudiant, etudiants.nom, etudiants.prenom , qcmfait.dateFait, qcmfait.point from qcmfait, etudiants, questionnaire where qcmfait.idQuestionnaire = questionnaire.idQuestionnaire AND etudiants.idEtudiant = qcmfait.idEtudiant AND etudiants.idEtudiant =" . $_SESSION['idEtudiant']);
        $sql->execute();
        echo "<table class='table table-striped'>";
        echo"<tr>";
        echo "<td>Nom du Questionnaire</td>";
        echo "<td>Date</td>";
        echo "<td>Point</td>";
        echo "</tr>";
        foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $ligne) {
            echo "<tr>";
            echo "<td>" . $ligne['libelleQuestionnaire'] . " </td><br>";
            echo "<td>" . $ligne['dateFait'] . "</td>";
            echo "<td>" . $ligne['point'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>

    </body>
</html>