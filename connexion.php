<?php 
session_start();

if(isset($_SESSION['connect'])){
    header('location: ../FormulaireConnexion/index.php');
}

require('src/database.php');

if(!empty($_POST['email']) && !empty($_POST['password'])){

    $email =  $_POST['email'];
    $password = $_POST['password'];

    $password = "aq1".sha1($password."1254")."25";
    $error = 1;


    $req = $db->prepare('SELECT * FROM users WHERE email = ?');

    $req->execute(array($email));

    while($user = $req->fetch()){

        if($password == $user['password']){
            $error = 0;
            $_SESSION['connect'] = 1;
            $_SESSION['pseudo'] = $user['pseudo'];

            header('location: ../FormulaireConnexion/connexion.php?succes=1');
    }
}
if($error == 1){
    header('location: ../FormulaireConnexion/connexion.php?error=1');
}

}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
    <link rel="stylesheet" href="./design/style.css">
</head>
<body>
    <header >
        <h1>Connexion</h1>
    </header>
    <div class="container">
        <p id="info">Bienvenue sur mon site, pour en voir plus, si vous n'êtes pas inscrit, <a href="./index.php">inscrivez-vous </a></p>
        <?php
        
        if(isset($_GET['error'])){
            echo'<p id="error">Nous ne pouvons pas vous authentifiez</p>';
        }else if(isset($_GET['succes'])){
            echo'<p id="succes">Vous êtes maintenant connecté</p>';
        }
        
        
        ?>
        
        
        <div id="form">
            <form method="post" action="connexion.php">
                <table>
                    <tr>
                        <td>Email</td>
                        <td><input type="email" name="email" placeholder="Ex: test@test.com" required></td>
                    </tr>
                    <tr>
                        <td>Mot de passe</td>
                        <td><input type="password" name="password" placeholder="*****" required></td>
                    </tr>
                    </table>
                    <p><label>
                        <input type="checkbox" name="connect" id="" checked>
                        Connexion automatique
                    </label>
                    </p> 
                    <div id="button">
                        <button>Inscription</button>

                    </div>
        
            </form>

        </div>
    </div>
</body>
</html>