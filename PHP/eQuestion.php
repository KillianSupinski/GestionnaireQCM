<?php
session_start();
?>
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
    </head>
    <body>
        <form method="POST" action="eAccueil.php.">
            <div align="right">
                <input type="submit" value="<?php echo $_SESSION['email']; ?>" name="btnUserName"><br>
                <input type="submit" value="deconnexion" name="btnDeconnexion">
            </div>
        </form>
        <?php
        include 'cnx.php';
        $sql = $cnx->prepare("select libelleQuestionnaire from questionnaire where idQuestionnaire=" . $_GET['idQuestionnaire']);
        $sql->execute();
        $date = date("d-m-Y");
        if (isset($_POST['btnDeconnexion'])) {
            session_destroy();
            header('location: ../index.php');
        }
        foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $name) 
            echo "<h1 style='color:red' align='center'>" . $name['libelleQuestionnaire'] . "</h1>";
        echo "<table class='table table-striped'>";
        echo "<form action='eResultat.php?idQuestionnaire=" . $_GET['idQuestionnaire'] . " &date=".$date."' method='post'> ";
        $sql = $cnx->prepare("select libelleQuestion, questionquestionnaire.idQuestion from question, questionquestionnaire where question.idQuestion=questionquestionnaire.idQuestion and questionquestionnaire.idQuestionnaire =" . $_GET['idQuestionnaire']);
        $sql->execute();
        foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $ligne) {


            echo "<li>";
            echo "<h3>" . $ligne['libelleQuestion'] . "</h3>";
            $sql = $cnx->prepare("select DISTINCT questionreponse.idReponse, questionreponse.bonne, valeur from reponse, questionreponse, questionquestionnaire, questionnaire, question where reponse.idReponse = questionreponse.idReponse and questionreponse.idQuestion = question.idQuestion and question.idQuestion=questionquestionnaire.idQuestion and questionquestionnaire.idQuestionnaire =" . $_GET['idQuestionnaire'] . " and question.idQuestion =" . $ligne['idQuestion'] . " group by reponse.idReponse");
            $sql->execute();

            foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $question) {
                echo "<li>";
                echo "<input type='radio' name=" . $ligne['idQuestion'] . " id=" . $question['idReponse'] . " value=" . $question['bonne'] . " />";
                echo "<label>" . $question['valeur'] . "</label>";
                echo "</li>";
            }
        }
        echo "</table><br>";

        echo "<input type='submit' value='Validez' />";
        echo "</form>";
        ?>
    </body>
</html>
