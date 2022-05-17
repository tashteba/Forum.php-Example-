<?php 
session_start();
require("actions/database.php");
// Validation du formulaire
if(isset($_POST["validate"])){

    // make sure if the user enter all the champs 
    if(!empty($_POST['pseudo']) && !empty($_POST['lastname']) && !empty($_POST['firstname']) && !empty($_POST['password'])){

        // Data of user
        $user_pseudo = htmlspecialchars($_POST['pseudo']);
        $user_lastname = htmlspecialchars($_POST['lastname']);
        $user_firstname = htmlspecialchars($_POST['firstname']);
        $user_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        

        // make sure if the user is exist in site
        $checkIfUserAlreadyExists = $bdd->prepare('SELECT pseudo FROM users WHERE pseudo = ?');
        $checkIfUserAlreadyExists->execute(array($user_pseudo));

        if($checkIfUserAlreadyExists->rowCount() == 0){

            // Inter the user in database
            $insertUserOnWebsite = $bdd->prepare('INSERT INTO users(pseudo, nom, prenom, mdp)VALUES (?, ?, ?, ?) ');
            $insertUserOnWebsite-> execute(array($user_pseudo,$user_lastname,$user_firstname,$user_password));
             
            // get the informations user from database
            $getInfoOfThisUserReq = $bdd->prepare('SELECT id, pseudo, nom, prenom FROM users WHERE nom = ? && prenom = ? && pseudo = ?');
            $getInfoOfThisUserReq->execute (array( $user_lastname, $user_firstname , $user_pseudo));
            $usersInfos = $getInfoOfThisUserReq->fetch();

            // Authentifer user dans site et get thier data from session globales
            $_SESSION['auth'] = true ;
            $_SESSION['id'] = $usersInfos['id'];
            $_SESSION['lastname'] = $usersInfos ['nom'];
            $_SESSION['firstname'] = $usersInfos ['prenom'];
            $_SESSION['pseudo'] = $usersInfos ['pseudo'];


            // send the user for page accueil
            header('Location: index.php ');
        }else{
            $errorMsg = "L'utilisateur existe déjà sur le site";

        }
    }else{
        $errorMsg = "Veuillez compléter tous les champs...";
    }
}