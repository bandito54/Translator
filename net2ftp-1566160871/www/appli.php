<!DOCTYPE html>
<html>
<head>
	<title>Appli Dicoti</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/all.css">
	<link rel="stylesheet" type="text/css" href="css/appli.css">
</head>
<body>
	<div id="topBar">
		<div id="rechercher">
			<input type="text" name="rechercher" placeholder="Rechercher ici..." id="searchInp">
			<div id="submitSearch">Rechercher</div>
		</div>
	</div>
	<div id="leftBar" class="active">
		<div id="gm_prenom"></div>
		<div class="onglGroup">
			<div id="gm_accueil" class="onglets active pointer">
				<div class="headerOng"><div class="iconMenu">
					<img src="media/icons/home.png" alt="" class="centerXY">
				</div>
				<p class="onglName">Dictionnaire général</p></div>
			</div>
			<div id="gm_recent" class="onglets pointer">
				<div class="headerOng"><div class="iconMenu">
					<img src="media/icons/recent.png" alt="" class="centerXY">
				</div>
				<p class="onglName">Récemment vus</p></div>
			</div>
			<div class="endGroup"></div>
		</div>
		<div class="onglGroup">
			<div id="gm_rssfeed" class="onglets active pointer">
				<div class="headerOng"><div class="iconMenu">
					<img src="media/icons/home.png" alt="" class="centerXY">
				</div>
				<p class="onglName">Charti</p></div>
			<div class="endGroup"></div>
		</div>
		<div class="onglGroup">
			<div id="gm_dico" class="onglets pointer">
				<div class="headerOng"><div class="iconMenu">
					<img src="media/icons/dico.png" alt="" class="centerXY">
				</div>
				<p class="onglName">Dictionnaires</p></div>
				<div id="elem_gm_dico" class="sub_menu">
					<div id="gm_alldico">
						<p>FR/EN</p>
						<p>FR/SP</p>
					</div>
					<h2 id="gm_adddico" class="plus">+</h2>
					<div id="gm_adddico_form">
						<p>Ajouter un dictionnaire</p>
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
			</div>
			<div id="gm_listes" class="onglets pointer">
				<div class="headerOng"><div class="iconMenu">
					<img src="media/icons/list.png" alt="" class="centerXY">
				</div>
				<p class="onglName">Listes</p></div>
				<div id="elem_gm_listes" class="sub_menu">
					<div id="ajr" class="listes"><p>Ajout Récent</p></div>
					<div id="rv" class="listes"><p>Récemment vus</p></div>
					<div id="mi" class="listes"><p>Les 25 inconnus</p></div>
					<div id="mpl" class="listes"><p>Mes playlists</p></div>
	 			</div>
			</div>
			<div class="endGroup"></div>
		</div>
		<div class="onglGroup">
			<div id="gm_stats" class="onglets pointer">
				<div class="headerOng"><div class="iconMenu">
					<img src="media/icons/stats.png" alt="" class="centerXY">
				</div>
				<p class="onglName">Statistiques</p></div>
			</div>
			<div id="gm_experience" class="onglets pointer">
				<div class="headerOng"><div class="iconMenu">
					<img src="media/icons/xp.png" alt="" class="centerXY">
				</div>
				<p class="onglName">Mon expérience</p></div>
			</div>
			<div id="gm_param" class="onglets pointer">
				<div class="headerOng"><div class="iconMenu">
					<img src="media/icons/param.png" alt="" class="centerXY">
				</div>
				<p class="onglName">Paramètres</p></div>
			</div>
			<div class="endGroup"></div>
		</div>
		<div id="decon" class="onglets pointer">
			<div class="iconMenu" >
				<img src="media/icons/deco.png" alt="" class="centerXY">
			</div>
			<p class="onglName">Déconnexion</p>
		</div>
	</div>
	<div id="content">
		<div id="activePage" class="centerXY">
			<div class="page pact" id="p_dico">
				<div class="btn_fixed pointer" id="btn_random"><img src="media/random.png" alt="Bouton pour accéder au quizz"></div>
				<div class="btn_fixed pointer" id="dico_addword"><img src="media/add.png" alt="Bouton pour ajouter un mot"></div>
				<div id="dico_menu">
					<span id="dico_title" class="page_title">Dictionnaire général</span>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
					<input type="text" id="dico_search" placeholder="Rechercher..."/>
					<span id="dico_loupe"></span>
					
				</div>
				<div id="dico_content">
				
				</div>
			</div>
			<div class="page" id="p_addword">
				<div class="last_page" data-page="dico">Retour</div>
				<h2 class="page_title">Mot</h2>
				<input type="text" class="glo_in" name="word" id="addword_word" placeholder="Entrez un mot..."/>
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
				<h2  class="page_title">Modification du mot</h2>
				<input id="changeword_word" class="glo_in">
				<span id="changeword_trad"></span>
				<span id="changeword_addtrad" class="plus">+</span>
				<textarea id="changeword_comm" placeholder="Note sur le mot..." class="glo_in"></textarea>
				<span class="btn_valid" id="changeword_valid">Ok</span>
			</div>
			<div class="page" id="p_startquiz">
				<div class="last_page" data-page="dico">Retour</div>
				<h2 class="page_title">Test de mémoire</h2>
				<h3>Durée</h3>
				<select id="sq_time" class="glo_in">
					<option value="30">30 sec</option>
					<option value="60">60 sec</option>
					<option value="90">90 sec</option>
					<option value="120">120 sec</option>
				</select>
				<div class="btn_valid" id="sq_start">Démarrer</div>
			</div>
			<div class="page" id="p_rssfeed">
				<div class="last_page" data-page="dico">Retour</div>
				<h2 class="page_title">Presse Étrangères</h2>
				<div id="rss_content"></div>
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
				<h2 class="page_title">Reglages</h2>
				<div id="param_list">
					<div class="param_oneparam" onclick="changePage('compte');"><img src="./media/user.png"/>Compte</div> <!-- ******** Faire la classe css param_oneparam ********* -->
					<div class="param_oneparam" onclick="changePage('perso')"><img src="./media/crayon.png"/>Personnalisation</div>
					<div class="param_oneparam" onclick="changePage('securite')"><img src="./media/securite.png"/>Sécurité</div>
					<div class="param_oneparam" onclick="changePage('qdn')">Quoi de neuf ?</div>
					<div class="param_oneparam" onclick="changePage('support')">Support</div>
					<div class="param_oneparam" onclick="changePage('charte')"><img src="./media/charte.png"/>Charte de confidentialité</div>
				</div>
			</div>
			<div class="page" id="p_stats">
				<div class="last_page" data-page="dico">Retour</div>
				<h2 class="page_title">Statistiques</h2>
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
				<div id="new_pl" class="plus">+</div>
				<div id="pl_content">
					
				</div>
				<div id="error_pl" class="error"></div>
			</div>
			<div class="page" id="p_experience">
				<div class="last_page" data-page="dico">Retour</div>
				<h2 class="page_title">Expérience</h2>
			</div>
			<div class="page" id="p_compte"></div>
			<div class="page" id="p_perso"></div>
			<div class="page" id="p_securite"></div>
			<div class="page" id="p_support"></div>
			<div class="page" id="p_charte"></div>
		</div>
	</div>
	<div id="global_alert"></div>
	<script type="text/javascript" src="js/appli.js"></script>
	<script type="text/javascript">
		var openMenu = document.getElementById('openMenu');
		var leftBar = document.getElementById('leftBar');
		var ongl = document.getElementsByClassName('onglName');
		var searchInp = document.getElementById('searchInp');
		var onglet = document.getElementsByClassName('onglets');

		var gm_accueil = document.getElementById('gm_accueil');
		var gm_recent = document.getElementById('gm_recent');
		var gm_dico = document.getElementById('gm_dico');
		var gm_listes = document.getElementById('gm_listes');
		var gm_stats = document.getElementById('gm_stats');
		var gm_experience = document.getElementById('gm_experience');
		var gm_param = document.getElementById('gm_param');

		var gm_adddico = document.getElementById('gm_adddico');

		/* Gérer l'onglet actif */
		gm_accueil.addEventListener('click',function(){
			rmAllActive();
			checkActive(this);
			selectDico('general');
		});
		gm_recent.addEventListener('click',function(){
			rmAllActive();
			checkActive(this);
		});
		gm_dico.addEventListener('click',function(){
			rmAllActive();
			checkActive(this);
		});
		gm_listes.addEventListener('click',function(){
			rmAllActive();
			checkActive(this);
		});
		gm_stats.addEventListener('click',function(){
			rmAllActive();
			checkActive(this);
			changePage('stats');
			var getstat = new XMLHttpRequest();
			getstat.open('POST',url);
			getstat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			getstat.send('id='+userid+'&req=getstat');
			getstat.onreadystatechange = function()
			{
				if(getstat.readyState == 4)
				{
					document.getElementById('st_content').innerHTML = getstat.responseText;
					var data = JSON.parse(document.getElementById('stat_graph_data').innerHTML);
					var can = document.getElementById('st_can');
					can.width = window.innerWidth*0.8;
					var ctx = can.getContext('2d');
					var i = 0;
					ctx.clearRect(0,0,can.width,can.height);
					ctx.fillStyle = '#F0F0F0';
					ctx.fillRect(0,0,can.width,can.height);
					ctx.textAlign = 'center';
					for(i = 0;i < data.length;i++)
					{
						ctx.fillStyle = '#2c3e50';
						ctx.fillRect((can.width/data.length)*i,can.height - (data[i].nt / data[i].nm)*can.height,(can.width/(data.length)),can.height);
						ctx.fillStyle = '#FFF';
						ctx.font = "bold 20px arial";
						ctx.fillText(Math.floor((data[i].nt / data[i].nm)*100)+'%',(can.width/data.length)*(i+0.5),can.height-((data[i].nt / data[i].nm)*can.height*0.5));
						ctx.font = "15px arial";
						if(i == 0 || data[i].d != data[i-1].d)
						{
							ctx.fillText(data[i].d,(can.width/data.length)*(i+0.5),can.height-5);
						}
					}
				}
			}
		});
		gm_experience.addEventListener('click',function(){
			rmAllActive();
			checkActive(this);
		});
		gm_param.addEventListener('click',function(){
			rmAllActive();
			checkActive(this);
			changePage('param');
		});

		/* Gérér les sous onglets */
		gm_adddico.addEventListener('click',function(){
			checkActive(this);
		});

		/*openMenu.addEventListener('click',function(){
			var i = 0;
			if(this.classList.contains("active")){
				this.classList.remove("active");
				leftBar.classList.remove("active");
				for(i=0;i<ongl.length;i++){
					ongl[i].style.display = "none";
				}
			}
			else{
				this.classList.add("active");
				leftBar.classList.add("active");
				setTimeout(afficheButton(0),1000);
			}
		});*/

		function afficheButton(i){
				if(i>=ongl.length)
					return;
				ongl[i].style.display = "block";
				i++;
				setTimeout(afficheButton(i), 100 + ( i * 100 ));
		}
		function rmAllActive(){
			for(i=0;i<onglet.length-1;i++){
				if(onglet[i].classList.contains("active"))
					onglet[i].classList.remove("active");
			}
		}
		function checkActive(div){
			if(div.classList.contains("active"))
				div.classList.remove("active");
			else
				div.classList.add("active");
		}
	</script>
</body>
</html>