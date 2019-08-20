<!DOCTYPE html>
<html>
<head>
	<title>S'inscrire</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/all.css">
	<link rel="stylesheet" type="text/css" href="css/connect.css">
</head>
<body>
	<div id="inscr" class="centerXY divCI">
		<div id="inscrMess" class="cttConIns">
			<h2 class="hConnect">INSCRIPTION</h2>
			<p class="pSinscr">Une inscription gratuite pour un compte unique sur tous tes appareils.</p>
			<p  class="pSinscr">Ton vocabulaire partout et quand tu en as besoin.</p>
		</div>
		<div id="formInscr" class="cttConIns">
			<div id="choixInscr">
				<p class="choix pointer active" id="choixForm">FORMULAIRE</p>
				<p class="choix pointer" id="choixFac">FACEBOOK</p>
			</div>
			<div id="cttInscrConnect" class="active">
				<form id="formConnex" action="./php/utils.php" method="POST">
					<input type="hidden" name="req" value="newuser">
					<span id="prenomInscr" class="spanInp">
						<input type="text" name="prenom" class="inputForm" id="inpConMail">
						<div class="placeHolderInp">PRÉNOM</div>
					</span>
					<span id="nomInscr" class="spanInp">
						<input type="text" name="nom" class="inputForm" id="inpConMail">
						<div class="placeHolderInp">NOM</div>
					</span>
					<span id="mailInscr" class="spanInp">
						<input type="text" name="mail" class="inputForm" id="inpConMail">
						<div class="placeHolderInp">ADRESSE MAIL</div>
					</span>
					<span id="mdpInscr" class="spanInp">
						<input type="password" name="mdp" class="inputForm" id="inpConMdp">
						<div class="placeHolderInp">MOT DE PASSE</div>
					</span>
					<span id="mdpVerifInscr" class="spanInp">
						<input type="password" name="mdp2" class="inputForm" id="inpConMdp2">
						<div class="placeHolderInp">VERIFICATION MOT DE PASSE</div>
					</span>
				</form>
				<div id="subConnex" class="pointer subConIn">
					<p>INSCRIPTION</p>
				</div>
			</div>
			<div id="cttInscrFb">
				<p style='color:black;'>FACEBOOK</p>
			</div>
			<div id="missInfo">

			</div>
		</div>
	</div>
	<div id="errorMess" class="pointer"></div>
	<script type="text/javascript">
		var error = <?php
			if(isset($_GET['error']))
			{
				echo $_GET['error'];
			}
			else
			{
				echo 0;
			}
		?>;
		function addActive(div){
			div.classList.add("active");
		}
		function removeActive(div){
			if(div.classList.contains("active")){
				div.classList.remove("active");
			}
		}
		switch(error)
		{
			case 1:
				/* Afficher l'erreur : L'adresse mail est déjà utilisée */
				break;
			default:

				break;
		}

		var choixForm = document.getElementById("choixForm");
		var choixFac = document.getElementById("choixFac");
		var cttInscrConnect = document.getElementById("cttInscrConnect");
		var cttInscrFb = document.getElementById("cttInscrFb");

		choixForm.addEventListener("click",function(){
			addActive(this);
			removeActive(choixFac);
			addActive(cttInscrConnect);
			removeActive(cttInscrFb);
			
		});
		choixFac.addEventListener("click",function(){
			addActive(this);
			removeActive(choixForm);
			addActive(cttInscrFb);
			removeActive(cttInscrConnect);
		});
		document.getElementById('subConnex').onclick = function()
		{
			var inpForm = document.getElementById('formConnex').getElementsByTagName('input');
			var isFill = true;
			var i = 0;
			while(isFill && i < inpForm.length)
			{
				isFill = testMissInp(inpForm[i]);
				i++;
			}
			if(isFill)
			{
				document.getElementById('formConnex').submit();
			}
			else
			{
				document.getElementById('missInfo').innerHTML = "Veuillez remplir la totalité des informations !";
			}
		}
		function testMissInp(elem)
		{
			if(elem.value != '')
			{
				return true;
			}
			else
			{
				elem.classList.add('miss');
				elem.onclick = function(){
					elem.classList.remove('miss');
				}
				return false;
			}
		}
		
	</script>
	<script src="./js/controlInput.js"></script>
</body>
</html>