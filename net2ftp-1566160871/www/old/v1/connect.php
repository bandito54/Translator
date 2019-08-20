<?php
	session_start();
	if(isset($_SESSION['id']) && !isset($_GET['error']))
	{
		header('Location: ./appli.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Appli Dicoti</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/all.css">
	<link rel="stylesheet" type="text/css" href="css/connect.css">
</head>
<body>
	<div id="conIns" class="centerXY divCI">
		<div id="connect" class="cttConIns">
			<h2 class="hConnect" id="hConnex">CONNEXION</h2>
			<form id="formConnex" action="./php/utils.php" method="POST">
				<span id="mailCon" class="spanInp pointer">
					<input type="text" name="mail" class="inputForm" id="inpConMail">
					<div class="placeHolderInp">ADRESSE MAIL</div>
				</span>
				<span id="mdpCon" class="spanInp pointer">
					<input type="password" name="mdp" class="inputForm" id="inpConMdp">
					<div class="placeHolderInp">MOT DE PASSE</div>
				</span>
				<input type="hidden" name="req" value="connect">
			</form>
			<div id="subConnex" class="pointer subConIn">
				<p>CONNEXION</p>
			</div>
		</div>
		<div id="sInscr" class="cttConIns">
			<h2 class="hConnect">S'INSCRIRE ?</h2>
			<p class="pSinscr">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
			<p  class="pSinscr">Eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
			<a href="./inscr.php ">
				<div id="subSInscr" class="pointer subConIn">
					<p>INSCRIPTION</p>
				</div>
			</a>
		</div>
	</div>
	<div id="errorMess" class="pointer"></div>
	<script type="text/javascript">
		var mailCon = document.getElementById("mailCon");
		var mdpCon = document.getElementById("mdpCon");
		var subConnex = document.getElementById("subConnex");
		var errorMess = document.getElementById("errorMess");
		var inpConMail = document.getElementById("inpConMail");
		var inpConMdp = document.getElementById("inpConMdp");

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

		var co_xhr = new XMLHttpRequest();
		switch(error)
		{
			case 1:
				afficheError("Identifiants incorrects :P","all");
		}

		mailCon.addEventListener("keyup", function(){
			checkState(this);
		});
		mdpCon.addEventListener("keyup", function(){
			checkState(this);
		});

		subConnex.onclick = function()
		{

			console.log(mailCon.value);
			if (inpConMail.value != "" && inpConMdp.value != "") {
				if (/^([a-z0-9._-]+)@([a-z0-9._-]+)\.([a-z]{2,6})$/.test(inpConMail.value)) {
					document.getElementById('formConnex').submit();
				}
				else{
					afficheError("Le mail est invalide ! :D","mail");
				}
			}
			else{
				afficheError("Veuillez remplir l'ensemble du formulaire :)","all");
			}
			
		}
		errorMess.addEventListener("click",function(){
			if(this.classList.contains("active")){
					this.classList.remove("active");
					inpConMail.style.borderColor = "#666";
					inpConMdp.style.borderColor = "#666";
				}
		});
		function afficheError(mess,div){
			errorMess.innerHTML = mess;
			errorMess.classList.add("active");
			switch(div){
				case "mail":
					inpConMail.style.borderColor = "#c1392b";
					break;
				default:
					inpConMail.style.borderColor = "#c1392b";
					inpConMdp.style.borderColor = "#c1392b";
					break;
			}
		}
		function checkState(div){
			if(div.value!=""){
				div.classList.add("active");
			}
			else{
				if(div.classList.contains("active")){
					div.classList.remove("active");
				}
			}
		}
		/* Ajouter la class active au span lorsque l'input n'est pas vide */ 

	</script>
</body>
</html>