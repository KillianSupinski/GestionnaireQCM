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
        $sql = $cnx->prepare("select idEtudiant, nom, prenom from etudiants where email='".$email."'");
        $sql->execute();
        foreach($sql->fetchAll(PDO::FETCH_ASSOC) as $session)
        {
        $_SESSION['idEtudiant'] = $session['idEtudiant'];
        $_SESSION['nom']= $session['nom'];
        $_SESSION['prenom'] = $session['prenom'];
        }
        if (isset($_POST['btnDeconnexion'])) {
            session_destroy();
            header('location: ../index.php');
        }

        $rqt = $cnx->prepare("SELECT questionnaire.idQuestionnaire, questionnaire.libelleQuestionnaire FROM questionnaire ");
        $rqt->execute();
        echo "<table class='table table-hover'>";
        foreach ($rqt->fetchAll(PDO::FETCH_ASSOC) as $ligne) {
            echo "<tr>";
            echo "<td>" . $ligne['libelleQuestionnaire'] . "</td>";
            echo "<td><a href='eQuestion.php?idQuestionnaire=" . $ligne['idQuestionnaire'] . "'>Afficher Le questionnaire</td>";
            echo "</tr>";
        }
        ?>
        <form method="POST" action="eProfil2.php">
            <div align="right">
                <input type="submit" value="<?php echo $_SESSION['email']; ?>" name="btnUserName"><br>
                <input type="submit" value="deconnexion" name="btnDeconnexion">
            </div>


            <h1>Bonjour <?php echo $_SESSION['prenom'] ?>.</h1>
            <h1>Veuillez choisir un questionnaire</h1>



        </form>
    </body>
</html>
