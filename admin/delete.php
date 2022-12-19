<?php
if(!isset($_SESSION)) { //démarre la gestion des sessions PHP
	session_start();
}

if(isset($_GET['id'])) {
	$mysqli = new mysqli("localhost", "demoutilisateur", "Mdp@Ass3zSécuris3", "demobd"); // Connexion BDD (utilisateur et mot de passe définis dans demobd.sql)
	if ($mysqli->connect_errno) {
		die("Échec de la connexion : " . $mysqli->connect_error);
	}
	$rows=$mysqli->query("DELETE FROM `articles` WHERE id=" . $_GET['id']);//ATTENTION: Injection SQL et faille CSRF
	//exemple de correction : mettre en place un jeton unique et un message de confirmation de suppression
	//voir fichier contre-mesure-CSRF.php dans les ressources de la vidéo sur la faille CSRF
	header("Location:/demo/admin");
}
?>
