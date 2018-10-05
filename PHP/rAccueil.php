
<html>
    <head>
        <meta charset="UTF-8">
        <title>Inscription</title>
        <script src="../Bootstrap/js/bootstrap.min.js"></script>
        <script src="../Bootstrap/js/bootstrap.js"></script>
        <script scr="../JS/fonction.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../CSS/style.css">
        <script src="../JQuery/jquery-3.1.1.min.js"></script>
        <link href="../Bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../Bootstrap/css/boostrap-theme.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
        session_start();
        include "cnx.php";
        if (isset($_POST['btnDeconnexion'])) {
            session_destroy();
            header('location: ../index.php');
        }
        ?>
        <form method="POST" action='pAccueil.php'>
            <div align="right">
                <input type="submit" value="<?php echo $_SESSION['email'];?>" name="btnUserName"><br>
                <input type="submit" value="deconnexion" name="btnDeconnexion">
            </div>
        </form>
        <h1>Choisissez votre questionnaire</h1>
<?php
$sql = $cnx->prepare("select idQuestionnaire ,libelleQuestionnaire FROM questionnaire");
$sql->execute();
echo "<form method='GET' action='gModification.php'>";
echo "<table class='table table-striped' width='50%'>";

foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $ligne) {
    echo "<tr>";
    echo "<td>" . $ligne['libelleQuestionnaire'] . " </td>";
    echo "<td><a href='rAfficher.php?idQuestionnaires=".$ligne['idQuestionnaire']." &nomDuQuestionnaire=".$ligne['libelleQuestionnaire']."'>Afficher les resultats</a></td>";
    echo"</tr>";
}
echo "</table>";
echo "</form>";
?>
    </body>
</head>
</html>