<?php
session_start();
?>
<body>
    <form method="POST" action="eAccueil.php">
        <div align="right">
            <input type="submit" value="<?php echo $_SESSION['email']; ?>" name="btnUserName"><br>
            <input type="submit" value="deconnexion" name="btnDeconnexion">
        </div>
    </form>
</body>
<?php
include "cnx.php";
$sql = $cnx->prepare("select DISTINCT questionquestionnaire.idQuestionnaire, questionquestionnaire.idQuestion, questionreponse.idReponse,questionreponse.bonne from questionquestionnaire, question, questionreponse where questionquestionnaire.idQuestionnaire = question.idQuestion and question.idQuestion = questionreponse.idQuestion and questionquestionnaire.idQuestionnaire =" . $_GET['idQuestionnaire'] . " group by questionquestionnaire.idQuestion");
$sql->execute();
if (isset($_POST['btnDeconnexion'])) {
    session_destroy();
    header('location: ../index.php');
}
$i = 0;
$n = 0;
foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $reponse) {
    // echo $NomDeLaRadio pour recuperer le truc du radio
    if ($_POST[$reponse['idQuestion']])
        ; {
        $n++;
    }
    if ($_POST[$reponse['idQuestion']] == "1") {
        $i++;
    }
}
$idEtudiant = $_SESSION['idEtudiant'];
$rqt = $cnx->prepare("select idEtudiant, idQuestionnaire from qcmfait where idEtudiant=" . $idEtudiant . " AND idQuestionnaire=" . $_GET['idQuestionnaire']);
$rqt->execute();
$res = $rqt->fetchAll(PDO::FETCH_ASSOC);
if ($res == FALSE) {
    $rqt = $cnx->prepare("insert into qcmfait values ($idEtudiant,'" . $_GET['idQuestionnaire'] . "', '".$_GET['date']."',$i)");
    $rqt->execute();
} else {
    $rqt = $cnx->prepare("update qcmfait set dateFait='".$_GET['date']."', point='" . $i . "' where idQuestionnaire=" . $_GET['idQuestionnaire'] . " AND idEtudiant=" . $idEtudiant);
    $rqt->execute();
}

echo "votre note est de " . $i . "/" . $n . "";
?>

