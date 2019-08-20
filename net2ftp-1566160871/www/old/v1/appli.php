<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Dicoti</title>
		<link rel="stylesheet" href="./css/appli.css"/>
		<link rel="stylesheet" href="./css/appli2.css"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<div id="global_menu_bouton">
			<svg width="50" height="50">
				<rect x="5" y="10" width="40" height="7"/>
				<rect x="5" y="22" width="40" height="7"/>
				<rect x="5" y="34" width="40" height="7"/>
			</svg>
		</div>
		<div class="page active" id="p_dico">
			<div id="dico_menu">
				<span id="dico_title">Dictionnaire général</span>
				<input type="text" id="dico_search" placeholder="Rechercher..."/>
				<span id="dico_loupe"></span>
				
			</div>
			<div id="dico_content">
			
			</div>
			<div class="btn_fixed" id="btn_random"><img src="media/random.png" alt="btn_random"></div>
			<div class="btn_fixed" id="dico_addword"><img src="media/add.png" alt="btn_random"></div>
		</div>
		<div class="page" id="p_addword">
			<div class="last_page" data-page="dico">Retour</div>
			<h2>Mot</h2>
			<input type="text" name="word" id="addword_word" placeholder="Entrez un mot..."/>
			<div id="addword_completion"></div>
			<!--<div class="btn_valid" id="valid_addword">Ok</div>
		</div>
		<div class="page" id="p_addtrad">
			<div class="last_page" data-page="addword">Retour</div>-->
			<h2>Traduction française</h2>
			<!--<div id="addtrad_word"></div>-->
			<div id="addtrad_suggest"></div>
			<div id="addtrad_personal">
			</div>
			<!--<input type="text" name="addtrad_personal" id="addtrad_personal" placeholder="Entrez une traduction..."/>-->
			<div class="page" id="addtrad_formu"></div>
			<span id="addtrad_addtrad" class="plus">+</span>
			<div class="btn_valid" id="addtrad_valid">Ajouter</div>
		</div>
		<div class="page" id="p_load">
			<h2 id="title_load">Chargement...</h2>
			<div id="load_container_anim">
				<div id="load_anim">
				</div>
			</div>
		</div>
		<div class="page" id="p_changeword">
			<div class="last_page" data-page="dico">Retour</div>
			<div class="remove_page" id="remove_word">Supprimer</div>
			<h2>Modification du mot</h2>
			<input id="changeword_word">
			<span id="changeword_trad"></span>
			<span id="changeword_addtrad" class="plus">+</span>
			<textarea id="changeword_comm" placeholder="Note sur le mot..."></textarea>
			<span class="btn_valid" id="changeword_valid">Ok</span>
		</div>
		<div class="page" id="p_startquiz">
			<div class="last_page" data-page="dico">Retour</div>
			<h2>Test de mémoire</h2>
			<h3>Durée</h3>
			<select id="sq_time">
				<option value="30">30 sec</option>
				<option value="60">60 sec</option>
				<option value="90">90 sec</option>
				<option value="120">120 sec</option>
			</select>
			<div class="btn_valid" id="sq_start">Démarrer</div>
		</div>
		<div class="page" id="p_quizz">
			<div class="last_page" data-page="dico">Retour</div>
			<article id="quizz_content">

			</article>
			<div id="quizz_time">
				
			</div> 
		</div>
		<div class="page" id="p_one_color"></div>
		<div class="page" id="p_param">
			<div class="last_page" data-page="dico">Retour</div>
			<h2>Reglages</h2>
			<div id="param_list">
				<div class="param_oneparam" onclick="changePage('compte');"><img src="./media/user.png"/>Compte</div> <!-- ******** Faire la classe css param_oneparam ********* -->
				<div class="param_oneparam" onclick="changePage('perso')"><img src="./media/crayon.png"/>Personnalisation</div>
				<div class="param_oneparam" onclick="changePage('securite')"><img src="./media/securite.png"/>Sécurité</div>
				<div class="param_oneparam" onclick="changePage('qdn')">Quoi de neuf ?</div>
				<div class="param_oneparam" onclick="changePage('support')">Support</div>
				<div class="param_oneparam" onclick="changePage('compte')"><img src="./media/charte.png"/>Charte de confidentialité</div>
			</div>
		</div>
		<div class="page" id="p_stats">
			<div class="last_page" data-page="dico">Retour</div>
			<h2>Statistiques</h2>
			<div id="st_content">

			</div>
			<canvas id="st_can"></canvas>
		</div>
		<div class="page" id="p_listes">
			<div class="last_page" data-page="dico">Retour</div>
			<div id="li_content">

			</div>
		</div>
		<div class="page" id="p_playlists">
			<div class="last_page" data-page="dico">Retour</div>
			<div id="new_pl">+</div>
			<div id="pl_content">
				
			</div>
			<div id="error_pl" class="error"></div>
		</div>
		
		<div id="global_menu_container">
		</div>
		<div id="global_menu">
			<h2 id="gm_prenom"></h2>
			<div id="gm_accueil">GENERAL</div>
			<div id="gm_dico">Dictionnaires</div>
			<div id="elem_gm_dico" class="sub_menu">
				<div id="gm_alldico"></div>
				<h2 id="gm_adddico" class="plus">+</h2>
				<div id="gm_adddico_form">
					<h3>Ajouter un dictionnaire</h3>
					<select id="gm_adddico_form_lg1">
						<option value="en">Anglais</option>
						<option value="fr">Français</option>
						<option value="es">Espagnol</option>
						<option value="al">Allemand</option>
						<option value="it">Italien</option>
					</select>
					<select id="gm_adddico_form_lg2">
						<option value="en">Anglais</option>
						<option value="fr" selected>Français</option>
						<option value="es">Espagnol</option>
						<option value="al">Allemand</option>
						<option value="it">Italien</option>
					</select>
					<div id="gm_adddico_form_valid">Ok</div>
				</div>
			</div>
			<div></div>
			<div id="gm_listes">Listes</div>
			<div id="elem_gm_listes" class="sub_menu">
				<div id="ajr" class="listes"><p>Ajout Récent</p></div>
				<div id="rv" class="listes"><p>Récemment vus</p></div>
				<div id="mi" class="listes"><p>Les 25 inconnus</p></div>
				<div id="mpl" class="listes"><p>Mes playlists</p></div>
 			</div>
			<div id="gm_stats">Statistiques</div>
			<div id="gm_experience">Mon experience</div>
			<div id="gm_param">Paramètres</div>
		</div>
		<div id="global_alert"></div>

		<script src="./js/appli.js">
			
		</script>
	</body>
</html>