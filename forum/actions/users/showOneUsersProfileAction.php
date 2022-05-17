<?php 
 require ('actions/database.php');
// Réqupérer l'identifant de l'utilisateur
 if (isset($_GET['id']) && !empty($_GET['id'])){

    // L'id de l'utlisateur 
    $idOfUser = $_GET['id'];

    // Vérifier si l'utilisatuer existe
     $checkIfUserExists = $bdd->prepare('SELECT pseudo,nom,prenom FROM users WHERE id = ?');
     $checkIfUserExists->execute(array($idOfUser));

     if($checkIfUserExists->rowCount() > 0){

        // Récupérer toutes les données de l'utilisateur 
        $usersInfos = $checkIfUserExists->fetch();

        $user_pseudo = $usersInfos['pseudo'];
        $user_lastname = $usersInfos['nom'];
        $user_firstname = $usersInfos['prenom'];

        // Récupérer toutes les question publiées par l'utilisateur
        $getHisQuestion = $bdd->prepare('SELECT * FROM questions WHERE id_auteur = ? ORDER BY id DESC');
        $getHisQuestion->execute(array($idOfUser));


     }else{
        $errorMsg = "Aucun utlisateur trouvé";
        }
 }else{
     $errorMsg = "Aucun utlisateur trouvé";
 }