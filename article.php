<!DOCTYPE HTML>
<html>
<head>
	<title>VulnéWeb by Cyberini</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
	<link rel="stylesheet" href="assets/css/main.css" />
	<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
</head>
<body>

	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Main -->
		<div id="main">
			<div class="inner">

				<!-- Header -->
				<header id="header">
					<a href="index.php" class="logo"><strong>VulnéWeb</strong> by Cyberini</a>
					<ul class="icons">
						<li><a href="https://www.twitter.com/LeBlogduHacker" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="https://www.facebook.com/LeBlogDuHacker" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="https://www.youtube.com/c/MichelKartner" class="icon fa-youtube"><span class="label">Youtube</span></a></li>
					</ul>
				</header>

				<?php 
					if(isset($_POST['query'])) { //Gère les recherches depuis le champ en question
						echo "Vous avez cherché : " . $_POST['query']; //ATTENTION: pas d'échappement de caractères (faille XSS)
						//exemple de correction : echo "Vous avez cherché : " . htmlentities($_POST['query']);
					} else { ?>
					
				<!-- Section -->
				<section>
					<header class="major">
						<h2>Article du jour</h2>
					</header>
					
					<article>
						<div class="content">
						<?php

							if(!isset($_GET['id'])) {
								if(isset($_GET['page'])) {//on regarde si une page doit être incluse
									include($_GET['page']);//ATTENTION: on peut inclure n'importe quel fichier (faille include)
									//exemple de correction : if($_GET['page']==="galerie") { include("/var/www/html/demo/galerie.php"); }
									//ou éventuellement str_replace(array("\n","\r",PHP_EOL),'',$_GET['page'])==="galerie") { include("/var/www/html/demo/galerie.php"); }
								}
								else {
									die("Aucun article ou page sélectionné(e).");
								}
							} else {
								$mysqli = new mysqli("localhost", "demoutilisateur", "Mdp@Ass3zSécuris3", "demobdd"); // Connexion BDD (utilisateur et mot de passe définis dans demobdd.sql)
								if ($mysqli->connect_errno) {
									die("Échec de la connexion - Veuillez réessayer plus tard : " . $mysqli->connect_error); //affiche l'erreur
								}
								$mysqli->set_charset("utf8");
								$rowsarticles=$mysqli->query("SELECT * FROM `articles` WHERE id=" . $_GET['id'] . " LIMIT 1"); //ATTENTION: pas d'échappement dans la requête SQL (Injection SQL) 
								//exemple de correction avec les guillemets simples: $rowsarticles=$mysqli->query("SELECT * FROM `articles` WHERE id='" . $mysqli->real_escape_string($_GET['id']) ."' LIMIT 1");
								//exemple de correction sans les guillemets simples mais avec la suppression de tout caractère différent d'un nombre : $rowsarticles=$mysqli->query("SELECT * FROM `articles` WHERE id=" . preg_replace("/[^0-9]/", "", $_GET['id']) . " LIMIT 1"); 
								if ($rowsarticles->num_rows==0) {
									echo "Aucun article à afficher.";
								}   
								else if($row = $rowsarticles->fetch_array()) {
									
									?>
									<?php 
										echo "<h3>" . $row['titre'] . "</h3>"; //ATTENTION: pas d'échappement de caractères (XSS stocké)
										echo $row['contenu']; //ATTENTION: pas d'échappement de caractères (XSS stocké)
										//exemple de correction : echo htmlentities($row['contenu']); et echo "<h3>" . htmlentities($row['titre']) . "</h3>";
									?>
						  <?php }?>
				      <?php } ?>
						</div>
					</article>
					<hr>
					<div>
						<h3>Commentaires</h3>
						<?php 
							if (isset($_POST['pseudo']) && isset($_POST['commentaire'])) {
								
								$queryinsert = "INSERT INTO `commentaires`(`id`, `idarticle`, `pseudo`, `commentaire`) VALUES (NULL, '".$_GET['id']."', '" . $_POST['pseudo'] . "', '" . $_POST['commentaire'] . "')";//ATTENTION: pas d'échappement dans la requête (Injection SQL)
								//exemple de correction avec les guillemets simples : utiliser $mysqli->real_escape_string()  autour de $_GET['id'], $_POST['pseudo'] et $_POST['commentaire'] 			
                        //autre exemple de correction, en utilisant preg_replace et en enlevant les guillemets simples autour de $_GET['id'] comme vu ci-dessous							
								$mysqli->query($queryinsert);
							} 
							
							$rowscommentaires=$mysqli->query("SELECT * FROM `commentaires` WHERE idarticle=" . $_GET['id']);//ATTENTION: pas d'échappement dans la requête SQL
							//exemple de correction avec les guillemets simples : $rowscommentaires=$mysqli->query("SELECT * FROM `commentaires` WHERE idarticle='" . $mysqli->real_escape_string($_GET['id']) . "'");
							//exemple de correction sans les guillemets simples mais avec la suppression de tout caractère différent d'un nombre : $rowscommentaires=$mysqli->query("SELECT * FROM `commentaires` WHERE idarticle=" . preg_replace("/[^0-9]/", "", $_GET['id']));
							if ($rowscommentaires->num_rows==0) {
								echo "Aucun commentaire";
							} else {
								while($row = $rowscommentaires->fetch_array())
								{
									echo $row['pseudo'] . " dit : <br>"; //ATTENTION: pas d'échappement de caractères (XSS stocké)
									echo "&nbsp;&nbsp;&nbsp;" . $row['commentaire'];//ATTENTION: pas d'échappement de caractères (XSS stocké)
									//exemple de correction : echo htmlentities($row['pseudo']); et echo htmlentities($row['commentaire']);
									echo "<br><br>";
								}														
							}
						?>
						<form method="post" action="#">
							<input type="text" name="pseudo" placeholder="Votre pseudo"/>
							<textarea name="commentaire" placeholder="Votre commentaire"></textarea>
							<input type="submit" value="Envoyer"/> <!-- ATTENTION: aucune vérification JavaScript, possibilité de spam et de bugs -->
							<!-- exemple de correction : utiliser des bibliothèques de validation (https://jqueryvalidation.org/) et vérifier côté serveur -->
						</form>
					</div>
						
				</section>

				<?php } ?>
			
			</div>
		</div>

		<!-- Sidebar -->
		<div id="sidebar">
			<div class="inner">

				<!-- Search -->
					<section id="search" class="alt">
						<form method="post" action="#">
							<input type="text" name="query" id="query" placeholder="Rechercher" />
						</form>
					</section>

				<!-- Menu -->
					<nav id="menu">
						<header class="major">
							<h2>Menu</h2>
						</header>
						<ul>
							<li><a href="index.php">Accueil</a></li>
							<li><a href="admin">Admin</a></li>
							<li>
								<span class="opener">Sous-menu</span>
								<ul>
									<li><a href="article.php?page=galerie.php">Galerie</a></li>
									<li><a href="#">Ipsum Adipiscing</a></li>
								</ul>
							</li>
							<li><a href="#">À propos</a></li>
							<li><a href="#">Contact</a></li>
							<li><a href="#">Mentions légales</a></li>
						</ul>
					</nav>

				<!-- Section -->
					<section>
						<header class="major">
							<h2>Ante interdum</h2>
						</header>
						<div class="mini-posts">
							<article>
								<a href="#" class="image"><img src="images/pic07.jpg" alt="" /></a>
								<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore aliquam.</p>
							</article>
							<article>
								<a href="#" class="image"><img src="images/pic08.jpg" alt="" /></a>
								<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore aliquam.</p>
							</article>
						</div>
						<ul class="actions">
							<li><a href="#" class="button">Lire plus</a></li>
						</ul>
					</section>

				<!-- Section -->
					<section>
						<header class="major">
							<h2>Nous contacter</h2>
						</header>
						<p>Sed varius enim lorem ullamcorper dolore aliquam aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin sed aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
						<ul class="contact">
							<li class="fa-envelope-o"><a href="#">information@entreprise.fr</a></li>
							<li class="fa-phone">(+33) 712345678</li>
							<li class="fa-home">1234 Rue de la Ville<br />
							Paris, 75000</li>
						</ul>
					</section>

				<!-- Footer -->
					<footer id="footer">
						<p class="copyright">&copy; MonSite. Tous Droits Réservés. Images Unsplash + Pixabay. Design: <a href="https://html5up.net">HTML5 UP</a> + <a href="https://cyberini.com">Cyberini</a>.</p>
					</footer>

				</div>
			</div>

	</div>

	<!-- Scripts -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/skel.min.js"></script>
	<script src="assets/js/util.js"></script>
	<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
	<script src="assets/js/main.js"></script>

</body>
</html>
