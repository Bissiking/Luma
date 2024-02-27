<?php
if ($_SERVER['REQUEST_URI'] !== '/') {
	header('Location: /');
}
?>

<link rel="stylesheet" href="css/init.css?V0">
<script>
	document.title = "Initialisation de LUMA";
</script>

<div class="container">
	<div class="steps">
		<div id="menu-step1" class="step active">Étape 1: Vérification du domaine</div>
		<i class="fa-solid fa-angles-right"></i>
		<div id="menu-step2" class="step">Étape 2: Renseignement des informations essentielles</div>
		<i class="fa-solid fa-angles-right"></i>
		<div id="menu-step3" class="step">Étape 3: Création des tables essentielles</div>
		<i class="fa-solid fa-angles-right"></i>
		<div id="menu-step4" class="step">Étape 4: Création du fichier de configuration</div>
	</div>
	<div class="content">
		<!-- STEP 1 -->
		<div class="step-content " id="step1">
			<h2>Vérification du domaine</h2>
			<!-- NEW INPUT -->
			<span id="SPAN-URL_HOST" class="info-popup">Le domaine détecté permet de voir sur qu'elle domain, le site va renseigné s'initialisé. Ceci permet au routeur de plus facilement attribué les pages essentielles au bon fonctionnement.</span>
			<div class="input-container">
				<input type="text" type="text" id="URL_HOST" name="URL_HOST" value="<?= $_SERVER['HTTP_HOST'] ?>" disabled>
				<label for="URL_HOST">Domaine détecté</label>
				<span class="underline"></span>
			</div>
			<button class="custom-button" data-step="2">Suivant</button>
		</div>

		<!-- STEP 2 -->
		<div class="step-content" id="step2">

			<h2>Création d'un compte Admin</h2>
			<div class="input-container">
				<input type="text" id="SYS_NAME" name="SYS_NAME" value="system" disabled>
				<label for="SYS_NAME">Compte système</label>
				<span class="underline"></span>
			</div>

			<div class="input-container">
				<input type="text" id="USER_ADMIN" name="USER_ADMIN" placeholder="">
				<label for="USER_ADMIN">Identifiant administrateur</label>
				<span class="underline"></span>
			</div>

			<div class="input-container">
				<input type="password" type="USER_ADMIN_MDP" id="USER_ADMIN_MDP" name="USER_ADMIN_MDP" placeholder="">
				<label for="USER_ADMIN_MDP">Mot de passe administrateur</label>
				<span class="underline"></span>
			</div>

			<h2>Identifiant base de donnée</h2>
			<div class="input-container">
				<input type="text" id="DB_HOST" name="DB_HOST" placeholder="">
				<label for="DB_HOST">IP ou domaine de la BDD: (default: localhost)</label>
				<span class="underline"></span>
			</div>

			<div class="input-container">
				<input type="text" id="DB_PORT" name="DB_PORT" placeholder="">
				<label for="DB_PORT">Port de la BDD: (default: 3306)</label>
				<span class="underline"></span>
			</div>

			<div class="input-container">
				<input type="text" id="DB_NAME" name="DB_NAME" placeholder="">
				<label for="DB_NAME">Nom de la BDD:</label>
				<span class="underline"></span>
			</div>

			<div class="input-container">
				<input type="text" id="DB_USER" name="DB_USER" placeholder="">
				<label for="DB_USER">Utilisateur de la BDD:</label>
				<span class="underline"></span>
			</div>

			<div class="input-container">
				<input type="password" id="DB_PASSWORD" name="DB_PASSWORD" placeholder="">
				<label for="DB_PASSWORD">Mot de passe de la BDD:</label>
				<span class="underline"></span>
			</div>

			<div class="button-block">
				<button class="custom-button cancel" data-step="1">Précédent</button>
				<button class="custom-button" data-step="3">Suivant</button>
			</div>

		</div>

		<!-- STEP 3 -->
		<div class="step-content active" id="step3">
			<h2>Création des tables</h2>
			<table class="action-table">
				<thead>
					<tr>
						<th>Action</th>
						<th width="230px">Statut</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Test de connexion à la base de donnée</td>
						<td class="statut-site" id="step3-etp1">
							<i class="fa-solid fa-hourglass-start"></i>
							<span>En attente</span>
						</td>
					</tr>
					<tr>
						<td>Création de la table du routeur</td>
						<td class="statut-site" id="step3-etp2">
							<i class="fa-solid fa-circle-check"></i><span>En attente</span>
						</td>
					</tr>
					<tr>
						<td>Ajout des routes principales</td>
						<td class="statut-site" id="step3-etp3">
							<i class="fa-solid fa-hourglass-start"></i><span>En attente</span>
						</td>
					</tr>
					<tr>
						<td>Création de la table des utilisateurs</td>
						<td class="statut-site" id="step3-etp4">
							<i class="fa-solid fa-hourglass-start"></i><span>En attente</span>
						</td>
					</tr>
					<tr>
						<td>Création du compte système</td>
						<td class="statut-site" id="step3-etp5">
							<i class="fa-solid fa-hourglass-start"></i><span>En attente</span>
						</td>
					</tr>
					<tr>
						<td>Création du compte administrateur</td>
						<td class="statut-site" id="step3-etp6">
							<i class="fa-solid fa-hourglass-start"></i><span>En attente</span>
						</td>
					</tr>
					<tr>
						<td>Création de la table de Nino</td>
						<td class="statut-site" id="step3-etp7">
							<i class="fa-solid fa-hourglass-start"></i><span>En attente</span>
						</td>
					</tr>
					<tr>
						<td>Création de la table des domaines</td>
						<td class="statut-site" id="step3-etp8">
							<i class="fa-solid fa-hourglass-start"></i><span>En attente</span>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="button-block">
				<button class="custom-button cancel disable" data-step="1">Précédent</button>
				<button id="start-check" class="custom-button" onclick="StartConfig()">Lancement</button>
			</div>
		</div>
	</div>
</div>


<script src="javascripts/init/init.js"></script>