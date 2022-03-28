<?php

	session_start();
	unset($_SESSION['email']);
	unset($_SESSION['token']);
	header("Location: index.php");
