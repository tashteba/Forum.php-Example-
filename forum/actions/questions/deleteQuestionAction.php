<?php

//Verfier si la utlisteur bien connecte
session_start();
if(!isset($_SESSION['auth'])){
    header('Location: ../../login.php');
}
require('../database.php');

if(isset($_GET['id']) && !empty($_GET['id'])){

    $idOftheQuestion = $_GET['id'];

    $checkIfQuestionExists=$bdd->prepare('SELECT id_auteur FROM questions WHERE id = ?');
    $checkIfQuestionExists->execute(array($idOftheQuestion));

    if($checkIfQuestionExists->rowCount() > 0){
        $questionsInfos = $checkIfQuestionExists->fetch();
        if($questionsInfos['id_auteur'] == $_SESSION['id']){

            $deleteThisQuestion = $bdd->prepare('DELETE FROM questions WHERE id = ?');
            $deleteThisQuestion->execute(array($idOftheQuestion));

            header('Location: ../../my-questions.php');
        }else{
            echo "Vous n'avez pas le droit de supprimer une question qui ne vous appatient !";
        }

    }else{
        echo "Aucune question n'été trouvé";

    }

}else{
    echo "Aucune question n'été trouvé";
}