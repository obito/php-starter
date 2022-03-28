<?php
session_start();

require "functions.php";

if (
    empty($_POST["email"]) ||
    !isset($_POST["firstname"]) ||
    !isset($_POST["lastname"]) ||
    empty($_POST["pseudo"]) ||
    count($_POST) < 4
) {

    die("Tentative de Hack ...");
}

if (isConnected()) {
    if (!isset($_GET['userId'])) {
        echo "no user set";

        return;
    }

    $userId = $_GET['userId'];
    //récupérer les données du formulaire
    $email = $_POST["email"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $pseudo = $_POST["pseudo"];



    //nettoyer les données

    $email = strtolower(trim($email));
    $firstname = ucwords(strtolower(trim($firstname)));
    $lastname = mb_strtoupper(trim($lastname));
    $pseudo = ucwords(strtolower(trim($pseudo)));


    $pdo = connectDB();


    //Vérification l'unicité de l'email
    $queryPrepared = $pdo->prepare("SELECT * from iw_user WHERE id=:id");

    $queryPrepared->execute(["id" => $userId]);

    $userData = $queryPrepared->fetch();

    if (empty($userData)) {
        echo "utilisateur n'existe pas";

        die();
    }


    //vérifier les données
    $errors = [];

    //Email OK
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email incorrect";
    } else {
        if ($userData["email"] != $email) {
            //Vérification l'unicité de l'email
            $queryPrepared = $pdo->prepare("SELECT email from iw_user WHERE email=:email");

            $queryPrepared->execute(["email" => $email]);

            if (!empty($queryPrepared->fetch())) {
                $errors[] = "E-mail existe déjà";
            }
        }
    }

    //prénom : Min 2, Max 45 ou empty
    if (strlen($firstname) == 1 || strlen($firstname) > 45) {
        $errors[] = "Le prénom doit faire plus de 2 caractères";
    }

    //nom : Min 2, Max 100 ou empty
    if (strlen($lastname) == 1 || strlen($lastname) > 100) {
        $errors[] = "Le nom doit faire plus de 2 caractères";
    }

    //pseudo : Min 4 Max 60
    if (strlen($pseudo) < 4 || strlen($pseudo) > 60) {
        $errors[] = "Le pseudo doit faire entre 4 et 60 caractères";
    }





    if (!empty($_POST["newPassword"]) && !empty($_POST["passwordConfirm"]) && !empty($_POST["oldPassword"])) {
        $pwd = $_POST["newPassword"];
        $pwdConfirm = $_POST["passwordConfirm"];
        $oldPassword = $_POST["oldPassword"];


        //Mot de passe : Min 8, Maj, Min et chiffre
        if (
            strlen($pwd) < 8 ||
            preg_match("#\d#", $pwd) == 0 ||
            preg_match("#[a-z]#", $pwd) == 0 ||
            preg_match("#[A-Z]#", $pwd) == 0
        ) {
            $errors[] = "Le mot de passe doit faire plus de 8 caractères avec une minuscule, une majuscule et un chiffre";
        }


        //Confirmation : égalité
        if ($pwd != $pwdConfirm) {
            $errors[] = "Le mot de passe de confirmation ne correspond pas";
        }

        if (!password_verify($oldPassword, $userData['pwd'])) {
            $errors[] = "L'ancien mot de passe ne correspond pas";
        }

        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
    }



    if (count($errors) == 0) {



        //$email = "y.skrzypczy@gmail.com";
        //$firstname = "');DELETE FROM users;";


        // if pwd didnt got modified
        if (!isset($pwd)) {
            $pwd = $userData['pwd'];
        }

        $queryPrepared = $pdo->prepare("UPDATE iw_user SET email=:email, firstname=:firstname, lastname=:lastname, pseudo=:pseudo, pwd=:pwd WHERE id=:id;");

        $queryPrepared->execute([
            "email" => $email,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "pseudo" => $pseudo,
            "pwd" => $pwd,
            "id" => $userData["id"],
        ]);

        header("Location: modify.php?userId=" . $userData["id"]);
    } else {

        $_SESSION['errors'] = $errors;
        header("Location: modify.php?userId=" . $userData["id"]);
    }


    //Si aucune erreur insérer l'utilisateur en base de données puis rediriger sur la page de connexion


    //Si il y a des erreurs rediriger sur la page d'inscription et afficher les erreurs

}
