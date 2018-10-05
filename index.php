<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Connection</title>
        <script src="./JQuery/jquery-3.1.1.min.js"></script>
        <script src="./Bootstrap/js/bootstrap.min.js"></script>
        <script src="./Bootstrap/js/bootstrap.js"></script>
        <link href="./Bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="./Bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
        /* page de connexion */
        //j'ai traite ici le cas ou l'utilisateur est etudiants; faut t'il créer une case a cocher pour le statut permettant un if etudiant / professeur
        //ou alors il existe une requete qui permet de traiter les deux cas en meme temps 
        session_start(); //sert a maintenir la connexion
        if (isset($_POST['connexion'])) {//si bouton "connexion" appuyé
            if (empty($_POST['email'])) { //empty verifie si le champ est vide
                echo "le champ Email est vide.";
            } else { //on verifie si le champ mot de passe n'est pas vide
                if (empty($_POST['password'])) {
                    echo "Le champ mot de passe est vide.";
                } else {
                    //connection a la base de données 
                    include './php/cnx.php'; //il faudra peut etre changer l'arborescence ici !!!!!!!!
                    $rqt = $cnx->prepare("SELECT idEtudiant, etudiants.nom , etudiants.prenom , etudiants.email FROM etudiants WHERE etudiants.email = '" . $_POST['email'] . "' AND etudiants.motDePasse = '" . $_POST['password'] . "'");
                    $rqt->execute();
                    $res = $rqt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($res) == 0) {
                        $rqt1 = $cnx->prepare("SELECT idProf, professeurs.nom , professeurs.prenom , professeurs.email FROM professeurs WHERE professeurs.email = '" . $_POST['email'] . "' AND professeurs.motDePasse = '" . $_POST['password'] . "'"); //rqt dans prof
                        $rqt1->execute();
                        $res1 = $rqt1->fetchAll(PDO::FETCH_ASSOC);
                        if (count($res1) == 0) {
                            ?>
                            <h5> <span class="label label-danger">le mot de passe ou l'adresse mail est éronné(e)</span></h5>
                            <?php
                            // pas trouvé ni dans prof ni dans etudiant
                        } else {
                            //trouvé dans prof
                            $_SESSION['email'] = $_POST['email'];
                            echo "Vous êtes connectés";
                            header('location: ./php/pAccueil.php'); // redirection vers la page d'acceuil
                        }
                    } else {
                        //trouvé dans etudiant
                        $_SESSION['email'] = $_POST['email'];
                        echo "Vous êtes connectés";
                        header('location:./php/eAccueil.php'); //redirection vers la page d'acceuil eleve.
                    }
                }
            }
        }
        ?>
        <div class="container">


            <form action="index.php" method="post">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input id="email" type="text" class="form-control" name="email" placeholder="Email">
                </div><br><br>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                </div><br><br>
                <div class="input-group">
                    <input type="submit" value="connexion" name="connexion" class = "btn btn-primary"><br>
                    <a href="./PHP/sign.php">Créer un compte</a>
                    <br>
                </div>
            </form>  
        </div>  




    </body>
</html>
