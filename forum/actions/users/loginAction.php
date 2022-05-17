<?php 
session_start();
require ('actions/database.php');

// Validation du formulaire
if(isset($_POST["validate"])){

    // make sure if the user enter all the champs 
    if(!empty($_POST['pseudo']) && !empty($_POST['password'])){

        // Data of user
        $user_pseudo = htmlspecialchars($_POST['pseudo']);
        $user_password = htmlspecialchars($_POST['password']);
        // Make sure if user is exicte (if pseudo is correct)
        $checkIfUserExists = $bdd->prepare ('SELECT * FROM users WHERE pseudo = ?');
        $checkIfUserExists->execute(array($user_pseudo));

        if($checkIfUserExists->rowCount() > 0){

            // getting data of user 
            $usersInfos = $checkIfUserExists->fetch();

            // make sure if password is correct
            if(password_verify($user_password, $usersInfos['mdp'])){
                
                // Authentifer user dans site et get thier data from session globales
            $_SESSION['auth'] = true ;
            $_SESSION['id'] = $usersInfos['id'];
            $_SESSION['lastname'] = $usersInfos ['nom'];
            $_SESSION['firstname'] = $usersInfos ['prenom'];
            $_SESSION['pseudo'] = $usersInfos ['pseudo'];
                // send user to homepage
            header ('location: index.php');

            }else{
                $errorMsg = 'Votre mot de passe est incorrect...';
            }
           
            }else {
                $errorMsg = 'Votre pseudo est incorrect...';
            }

       
        
    }else{
     $errorMsg = "Veuillez compléter tous les champs...";
    }
}
