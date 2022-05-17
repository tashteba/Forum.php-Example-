<?php require ('actions/database.php');

// Vérifier si l'id de la question est  bien passé en paramétre dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){

    $idOfQuestion = $_GET['id'];

    // Véreifer si la question existe
    $checkIfQuestionExists = $bdd->prepare ('SELECT * FROM questions WHERE id = ?');
    $checkIfQuestionExists->execute(array($idOfQuestion));

    if($checkIfQuestionExists->rowCount()>0){


        $questionInfo = $checkIfQuestionExists->fetch();
        if($questionInfo['id_auteur']== $_SESSION['id']){
            // Récupérer les données de la question
            $question_title = $questionInfo['titre'];
            $question_description = $questionInfo['description'];
            $question_content = $questionInfo['contenu'];

            $question_description =str_replace ('<br/>','',$question_description);
            $question_content = str_replace ('<br/>','',$question_content);

        }else{
            $errorMsg = "Vous n'êtes pas l'auteur de cette question";
        }



    }else{
        $errorMsg = "Aucune question n'a été trouvée";
    }

}else {
    $errorMsg = "Aucune question n'a été trouvée";
    
}