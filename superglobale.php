<?php

/*

 Variable super globale:
 -> Créée par le serveur
 -> Contient toujours un tableau
 -> syntaxe, commence toujours par $_ et est en majuscule exemple $_COOKIE
 -> est accessible partout dans le code
 -> 8

*/

//Création d'un cookie
//setcookie("pseudo", "super prof");
 //echo "Bonjour ".$_COOKIE['pseudo'];



 session_start();

 //$_SESSION['email'] = "y.skrzypczyk@gmail.com";


 echo $_SESSION['email'];