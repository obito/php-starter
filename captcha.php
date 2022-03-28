<?php

	header("Content-Type: Image/png");


	$image = imagecreate(300, 150);


	$back = imagecolorallocate($image, rand(0,100), rand(0,100), rand(0,100));

	$listOfFonts = glob("font/*.ttf");	


	$char = "abcdefghijklmnopqrstuvwxyz0123456789";
	$char = str_shuffle($char);
	$captcha = substr($char, 0, rand(6,8));


	//imagestring($image, 5, 100, 70, $captcha, $black);

	$x = rand(20,30);
	for($cpt=0; $cpt<strlen($captcha) ; $cpt++){

		$colors[] = imagecolorallocate($image, rand(150,255), rand(150,255), rand(150,255));
		$font = $listOfFonts[array_rand($listOfFonts)];
		imagettftext($image, rand(20,25), rand(-15,15), $x, rand(50,125), $colors[$cpt], $font, $captcha[$cpt]);
		$x += rand(30,35);
	}
	


	$nbGeometry = rand(5, 8);

	for($cpt = 0; $cpt<$nbGeometry; $cpt++){

		$geometry = rand(1,3);
		switch ($geometry) {
			case '1':
				imagerectangle($image, rand(0,300), rand(0,150), rand(0,300), rand(0,150), $colors[array_rand($colors)]);
				break;
			case '2':
				imageline($image, rand(0,300), rand(0,150), rand(0,300), rand(0,150), $colors[array_rand($colors)]);
				break;
			default:
				imageellipse($image, rand(0,300), rand(0,150), rand(0,300), rand(0,150), $colors[array_rand($colors)]);
				break;
		}
		
	}


	/*
		Consignes :
			- Créer un dossier "font" avec dedans 3 polices au format ttf (dafont)
			- Intégrer dans l'image le texte en respectant :
				-> Une couleur aléatoire pour le fond
				-> Une couleur aléatoire par caractère
				-> Un angle  aléatoire par caractère
				-> Une taille et une position aléatoires par caractère
				-> Une police aléatoire par caractère en cherchant dans le dossier font, si j'ajoute une police elle doit être prise en compte automatiquement sans modifier le code
				-> Des formes aléatoires derrière les caractères avec des couleurs déjà utilisées (Nb aléatoire)

			Attention à la lisibilité (et du code)

	*/




	imagepng($image);