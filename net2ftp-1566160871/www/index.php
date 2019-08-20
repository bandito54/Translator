<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Dicoti</title>
	<link rel="stylesheet" type="text/css" href="./css/index.css">
</head>
<body>
	<div id="menu">
		<div id="connexMenu">
			<a href="./connect.php"><p class="pWM">Connexion</p></a>
		</div>
	</div>
	<section id="accueil">
		<div id="cttAccueil">
			<h1 id="dicotiTle">Dicoti</h1>
			<p id="openPhrase" class="pWM openPhrase">le dico </p><div id="containTres	"><span class="bold fIn" id="tresTitle">très</span></div><p class="pWM openPhrase"> intelligent qui te fait progresser en langues étrangères.</p>
			<div id="btnAccueil">
				<div  class="btn" id="inscrAccueil">
					<a href="./inscr.php">Inscription</a>
				</div>
				<div  class="btn" id="connAccueil">
					<a href="./connect.php">Connexion</a>
				</div>
			</div>
		</div>
	</section>
	<section id="little_pres" class="padSect">
		<p class="pWM" id="pres">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium </p>
		<div id="svgAccueil">
			<?php require_once("./svgAccueil.html"); ?>
		</div>
	</section>
	<section id="enBref" class="padSect">
		<h2 class="pWM" id="ttlenBref">Dicoti en bref</h2>
		<div id="listingBref">
			<div class="listsB">
				<img src="./media/img/icons/puzzle.png" alt="" class="iconsBref" >
				<p class="pWM">Créez et/ou téléchargez des listes de mots complètes pour développer un vocabulaire précis</p>
			</div>
			<div class="listsB">
				<img src="./media/img/icons/pointer.png" alt="" class="iconsBref">
				<p class="pWM">Ajoutez en 1 clic tous les mots et toutes les expressions  que vous croisez dans votre journée </p>
			</div>
			<div class="listsB">
				<img src="./media/img/icons/build.png" alt="" class="iconsBref">
				<p class="pWM">Entrainez-vous  pour mémoriser votre vocabulaire et progresser à l’oral et à l’écrit : La répétition aide à la mémorisation</p>
			</div>
			<div class="listsB">
				<img src="./media/img/icons/stats.png" alt="" class="iconsBref">
				<p class="pWM">Suivez votre progression, et atteignez vos objectifs  </p>
			</div>
			<div class="listsB">
				<img src="./media/img/icons/recomp.png" alt="" class="iconsBref">
				<p class="pWM">Partagez vos listes et vos scores,  conseillez et challengez vos amis, vos collègues et votre famille</p>
			</div>
		</div>
	</section>
	<section id="sondage" class="padSect">
		<h2 id="sondTle" class="bold">SONDAGE AMUSANT</h2>
		<p>Pour vous, quel est « le nerf de la guerre » dans l’apprentissage d’une langue étrangère ? </p>
		<div id="checkboxes">
			<div class="checkbox">
			       <input type="radio" id="checkbox1" value="L'entrainement" name="sondage" onclick="checkB()">
			       <label for="checkbox1">L'entrainement</label>
			 </div>
			 
			 <div class="checkbox">
			      <input type="radio" id="checkbox2" value="Le vocabulaire" name="sondage" onclick="checkB()">
			      <label for="checkbox2">Le vocabulaire</label>
			 </div>

			 <div class="checkbox">
			      <input type="radio" id="checkbox3" value="La grammaire" name="sondage" onclick="checkB()">
			      <label for="checkbox3">La grammaire</label>
			 </div>
		</div>
		<div id="resSond"></div>
		<div id="submitSond">
				<p class="pWM bold">Envoyer</p>
			</div>
	</section>
	<section id="aboContact">
		<div id="abo" class="padabo">
			<h2>RÉSEAUX SOCIAUX et ABONNEMENTS</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			<div id="btnAbo">
				<div  class="btn" id="inscrAbo">
					<a href="./inscr.php">Inscription</a>
				</div>
				<div  class="btn" id="connAbo">
					<a href="./connect.php">Connexion</a>
				</div>
			</div>
			<div id="resSocAbo">
				<a href=""><img src="./media/img/icons/fb.png" alt="" class="iconsRes"></a>
				<a href=""><img src="./media/img/icons/twitter.png" alt="" class="iconsRes"></a>
				<a href=""><img src="./media/img/icons/ytb.png" alt="" class="iconsRes"></a>
				<a href=""><img src="./media/img/icons/ldin.png" alt="" class="iconsRes"></a>
			</div>
		</div>
  		<div id="contact">
  			<h2 id="ttlCont">CONTACT</h2>
  			<p class="bold">Un souci, une question, nous voilà !</p>
  			<p class="bold pWM">Adresse</p>
  			<p class="pWM">ICN Business School - 86 rue du Sergent Blandan - 54003 NANCY Cedex </p>
  			<div id="mails">
  				<img src="./media/img/icons/mails.png">
  				<div id="mailsP">
  					<p class="pWM">contact@dicoti.com</p>
  					<p class="pWM">assistance@dicoti.com</p>
  				</div>
  			</div>
  		</div>
	</section>
	<footer class="padSect">
		<p class="pWM">© Dicoti - 2018</p>
		<a href="">Mentions légales</a>
	</footer>
	<script type="text/javascript">
		var sehr;
		var i = 1;
		var tres = ["très","sehr","very","muy","molto","uiterst","niezmiernie"];
		var tresTitle = document.getElementById("tresTitle");
		var submitSond = document.getElementById("submitSond");

		function tresFct(i){
			if(tresTitle.classList.contains("fIn"))
				tresTitle.classList.remove("fIn");
			tresTitle.classList.add("fOut");
			tresTitle.innerHTML = "";
			setTimeout(function(){
			    if(i<tres.length){
			       	tresTitle.innerHTML = tres[i];
			    }
			    else{
			        i = 0;
			        tresTitle.innerHTML = tres[i];
			    }

			    tresTitle.classList.remove("fOut");
			    tresTitle.classList.add("fIn");
			    i++;
		    	setTimeout("tresFct("+i+")", 5000);
			}, 1500);
		}
		setTimeout("tresFct("+i+")",5000);
		function checkB(){
			submitSond.style.bottom = "0px";
		}
		function loadRes(){
			var checkboxes = document.getElementById("checkboxes");
			var resSond = document.getElementById("resSond");
			var res = [["L'entrainement",47],["Le vocabulaire",118],["La grammaire",62]];
			var nbVotes = res[0][1] + res[1][1] + res[2][1];
			var content = "<div class='graph'><div class='subGraph'><div id='entrSond' class='resGraph'></div></div></div><div class='graph'><div class='subGraph'><div id='vocSond' class='resGraph'></div></div></div><div class='graph'><div class='subGraph'><div id='grammSond' class='resGraph'></div></div></div>"
			checkboxes.innerHTML = "";
			resSond.style.height = "150px";
			resSond.innerHTML = content;
			var entrSond = document.getElementById("entrSond");
			var vocSond = document.getElementById("vocSond");
			var grammSond = document.getElementById("grammSond");
			setTimeout(function(){
				entrSond.style.width = ((res[0][1]*100)/nbVotes)+"%";
				vocSond.style.width = ((res[1][1]*100)/nbVotes)+"%";
				grammSond.style.width = ((res[2][1]*100)/nbVotes)+"%";
			},500);
		}
		submitSond.addEventListener("click",function(){
			loadRes();
			submitSond.style.bottom = "-50px";
		});
	</script>
</body>
</html>