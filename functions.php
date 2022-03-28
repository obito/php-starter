<?php
require "config.inc.php";

function connectDB()
{
	//création d'une nouvelle connexion à notre bdd
	try {

		$pdo = new PDO(DB_DRIVER . ":host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PWD);

		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (Exception $e) {
		die("Erreur SQL " . $e->getMessage());
	}


	return $pdo;
}

/*
	$token = createToken();
	updateToken($results["id"], $token);
*/

function createToken()
{
	$token = sha1(md5(rand(0, 100) . "gdgfm432") . uniqid());
	return $token;
}


function updateToken($userId, $token)
{

	$pdo = connectDB();
	$queryPrepared = $pdo->prepare("UPDATE iw_user SET token=:token WHERE id=:id");
	$queryPrepared->execute(["token" => $token, "id" => $userId]);
}


function isConnected()
{

	if (!isset($_SESSION["email"]) || !isset($_SESSION["token"])) {
		return false;
	}

	$pdo = connectDB();
	$queryPrepared = $pdo->prepare("SELECT id FROM iw_user WHERE email=:email AND token=:token");
	$queryPrepared->execute(["email" => $_SESSION["email"], "token" => $_SESSION["token"]]);

	return $queryPrepared->fetch();
}
