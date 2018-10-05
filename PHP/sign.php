<html>
    <head>
        <meta charset="UTF-8">
        <title>Inscription</title>
        <script src="../Bootstrap/js/bootstrap.min.js"></script>
        <script src="../Bootstrap/js/bootstrap.js"></script>
        <script scr="../JS/fonction.js"></script>
        <script src="../JQuery/jquery-3.1.1.min.js"></script>
        <link href="../CSS/style.css" rel="stylesheet">
        <link href="../Bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../Bootstrap/css/boostrap-theme.min.css" rel="stylesheet">
    </head>
    <body>
        <?php
        include "cnx.php";
        if (isset($_POST['btn'])) {             
                if (!$_POST['txtNom'] == "") { // on verifie que le nom est bien noté
                    if (!$_POST['txtPrenom'] == "") { // on verifie que le prenom est bien noté
                        if (!$_POST['txtMail'] == "") { // on verifie que l'email est bien noté
                            if (!$_POST['txtMdp'] == "") { // on verifie que le le mot de passe est bien noté
                                if ($_POST['txtMdp2'] == $_POST['txtMdp']) { // on verifie que le mot de passe confirmé correspond
                                    if (!$_POST['txtCodeProf']) { //Si le codeProf n'existe pas alors le compte est Eleve
                                        $sql = $cnx->prepare("insert into etudiants values('','" . $_POST['txtMdp'] . "', '" . $_POST['txtNom'] . "', '" . $_POST['txtPrenom'] . "', '" . $_POST['txtMail'] . "')");
                                        $sql->execute();
                                        header('location:../index.php');
                                    } else { // Si le codeProf existe alors on verifie si il est bon pour crée un compte prof
                                        if ($_POST['txtCodeProf'] == "110") { 
                                            $sql = $cnx->prepare("insert into professeurs values('' ,'" . $_POST['txtMdp'] . "', '" . $_POST['txtNom'] . "', '" . $_POST['txtPrenom'] . "', '" . $_POST['txtMail'] . "')");
                                            $sql->execute();
                                            header('location:../index.php');
                                        } else {
                                            echo "Erreur code prof";
                                        }
                                    }
                                } else {
                                    echo "Veuillez confirmer votre mot de passe";
                                }
                            } else {
                                echo "Veuillez rentrer votre mot de passe";
                            }
                        } else {
                            echo "Veuillez rentrer votre Email";
                        }
                    } else {
                        echo "Veuillez rentrer votre prenom";
                    }
                } else {
                    echo "Veuillez rentrer votre nom";
                }
            } 
      
        ?>
        <form method="POST" method="../index.php">
            <div align="center">
                <h2>Inscription</h2>
            </div> <br> <br><br> <br>
            <div id="DivInscription" >
                <input id="nomEleve" type="text" name="txtNom" placeholder="Nom" class="placeholder">
                <input id="prenomEleve" type="text" name="txtPrenom" placeholder="Prenom" class="placeholder"> <br/><br/>
                <input id="emailEleve" type="email" name="txtMail" placeholder="Email" class="placeholder"> <br/><br/>
                <input id="mdpEleve"type="password" name="txtMdp" placeholder="Mot de passe" class="placeholder">
                <input id="mdpEleve2"type="password" name="txtMdp2" placeholder="Confirmer Mot de passe" class="placeholder"><br/> <br/>
                <label>Etes vous un professeur?</label>
                <input type="text" id="codeProf" name="txtCodeProf" placeholder="Code Professeur" class="placeholder">
                <input type="submit" name="btn" class="btn btn-primary">
            </div>

        </form>
    </body>
</head>
</html>