var pages = document.getElementsByClassName('page');
var retours = document.getElementsByClassName('last_page');
var prenom = '';
var mail = '';
var mailRE = new RegExp('[a-zA-z0-9\-\_\.]+@[a-zA-z0-9\.\-\_]+\.[a-z]+','i');
var store = window.localStorage;
var userid = 0;
var allMyWord = [];
var currentDico = 'general';
var inQuizz = false;
var debQuizz = false;
var tabQuest = [];
var idQuizz = 0;
var nbWQuizz = 0;
var timeQuizz;
var pointsQuizz = 0;
var allQsQuizz = 0;
var userData = [];
var url = './php/utils.php';

var create_user = new XMLHttpRequest();
var send_word = new XMLHttpRequest();
var send_trad = new XMLHttpRequest();
var verif_user = new XMLHttpRequest();
var change_word = new XMLHttpRequest();
var remove_word = new XMLHttpRequest();
var change_fav = new XMLHttpRequest();
var add_dico = new XMLHttpRequest();
var del_dico = new XMLHttpRequest();
var start_chrono = new XMLHttpRequest();

var get_cpl = new XMLHttpRequest();
var get_mywords = new XMLHttpRequest();
var get_mydicos = new XMLHttpRequest();
var get_search = new XMLHttpRequest();
var get_topwords = new XMLHttpRequest();
var get_suggest = new XMLHttpRequest();

verif_user.open('POST',url);
verif_user.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
verif_user.send('req=verifuser');


verif_user.onreadystatechange = function()
{
	if(verif_user.readyState == 4 && verif_user.status == 200)
	{
		if(verif_user.responseText == 'no')
		{
			/* Popup pour rediriger vers la page de co */
			alerte('Vous devez vous <a href="./connect.php?error=2">connecter</a> avant d\'accéder à cette page');
		}
		else
		{
			userData = JSON.parse(verif_user.responseText);
			changePage('dico');
			prenom = userData.prenom[0].toUpperCase() + userData.prenom.substring(1,100);
			document.getElementById('gm_prenom').innerHTML = prenom;
			getMyWords();
			getDicos();
			userid = create_user.responseText;
		}
	}
}

for(i = 0;i < retours.length;i++)
{
	retours[i].addEventListener('click',function(){
		changePage(this.getAttribute('data-page'));
	},false);
}

/*document.getElementById('log_valid').addEventListener('click',function(){		// Connection (ne sert plus à rien)
	if(document.getElementById('log_prenom').value != '')
	{
		if(document.getElementById('log_mail').value != '' && document.getElementById('log_mail').value.match(mailRE))
		{
			loadingPage('Creation de l\'utilisateur...');
			prenom = document.getElementById('log_prenom').value;
			mail = document.getElementById('log_mail').value;
	
			create_user.open('POST',url);
			create_user.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			create_user.send('req=newuser&prenom='+prenom+'&mail='+mail);
			create_user.onreadystatechange = function()
			{
				if(create_user.readyState == 4)
				{
					if(create_user.responseText != '')
					{
						store.setItem('prenom',prenom);
						store.setItem('mail',mail);
						store.setItem('words','[]');
						userid = create_user.responseText;
						store.setItem('iduser',userid);
						changePage('dico');
						document.getElementById('gm_prenom').innerHTML = prenom;
						getMyWords();
						getDicos();
					}
					else
					{
						changePage('log');
						alerte('Connexion au serveur interrompue...');
					}
				}
			}
		}
		else
		{
			alerte('Le mail que vous avez rentré est incorrect');
		}
	}
	else
	{
		alerte('Vous n\'avez pas rentré de prénom');
	}

},false);*/
document.getElementById('dico_addword').addEventListener('click',function(){
	changePage('addword');
	document.getElementById('addtrad_personal').innerHTML = '<div><input type="text" value="" placeholder="Entrez une traduction..."/></div>';
},false);
document.getElementById('addword_word').addEventListener('keyup',function(){
	getCplAndSugg(this.value);
	/*var value = document.getElementById('addword_word').value;
	if(value != '')
	{
		get_suggest.open('POST',url);
		get_suggest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		get_suggest.send('id='+userid+'&req=getsuggest&word='+document.getElementById('addword_word').value);
		get_suggest.onreadystatechange = function()
		{
			if(get_suggest.readyState == 4)
			{
				if(get_suggest.responseText != '')
				{
				}
			}
		}
	}*/
},false);
/*document.getElementById('valid_addword').addEventListener('click',function(){



},false);*/
document.getElementById('addtrad_valid').addEventListener('click',function(){var value = document.getElementById('addword_word').value;
	var value = document.getElementById('addtrad_personal').getElementsByTagName('input')[0].value;
	if(value != '')
	{
		loadingPage('Enregistrement de la traduction...');
		var at = document.getElementById('addtrad_personal').getElementsByTagName('input');
		var allTrad = [];
		for(i = 0;i < at.length;i++)
		{
			allTrad[i] = at[i].value;
		}
		value = JSON.stringify(allTrad);
		send_trad.open('POST',url);
		send_trad.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		var cDic = currentDico;
		if(cDic == 'general')
		{
			cDic = 'default';
		}
		send_trad.send('id='+userid+'&req=addtrad&dico='+cDic+'&word='+value+'&lg=fr&fw='+document.getElementById('addword_word').value+'&lastlg=en');
		send_trad.onreadystatechange = function()
		{
			if(send_trad.readyState == 4)
			{
				document.getElementById('addtrad_personal').value = '';
				document.getElementById('addword_word').value = '';
				getMyWords();
				//selectDico('general');
				alerte('Mot enregistré','success');
				changePage('dico');
			}
		}
	}
	else
	{
		alerte('Le champ est vide');
	}

},false);
/*document.getElementById('addword_lg').addEventListener('change',function(){
	toogleLg();
},false);*/
document.getElementById('dico_search').addEventListener('keyup',function(){
	var allW = document.getElementById('dico_content').getElementsByClassName('dico_oneword');
	var allLet = document.getElementById('dico_content').getElementsByClassName('dico_oneletter');
	var allFav = document.getElementById('dico_content').getElementsByClassName('dico_ow_fav');
	var i = 0;
	var curWord = '';
	if(this.value == '')
	{
		for(i = 0;i < allLet.length;i++)
		{
			allLet[i].style.display = 'block';
		}
		for(i = 0;i < allW.length;i++)
		{
			allW[i].style.display = 'block';
			allFav[i].style.display = 'block';
			allFav[i].style.top = allW[i].offsetTop + 'px';
		}
	}
	else
	{
		for(i = 0;i < allLet.length;i++)
		{
			allLet[i].style.display = 'none';
		}
		for(i = 0;i < allW.length;i++)
		{
			curWord = allW[i].getElementsByClassName('dico_ow_main')[0].innerHTML;
			curTrad = allW[i].getElementsByClassName('dico_ow_trad')[0].innerHTML;
			if(this.value == curWord.substring(0,this.value.length) || this.value == curTrad.substring(0,this.value.length))
			{
				allW[i].style.display = 'block';
				allFav[i].style.display = 'block';
				allFav[i].style.top = allW[i].offsetTop + 'px';
			}
			else
			{
				allW[i].style.display = 'none';
				allFav[i].style.display = 'none';
				allFav[i].style.top = allW[i].offsetTop + 'px';
			}
		}
	}
},false);
document.getElementById('changeword_valid').addEventListener('click',function(){
	change_word.open('POST',url);
	change_word.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	at = document.getElementById('changeword_trad').children;
	var allTrad = [];
	for(i = 0;i < at.length;i++)
	{
		allTrad[i] = {f:at[i].getAttribute('data-id'),n:at[i].value};
	}
	change_word.send('id='+userid+'&req=changeword&dico='+currentDico+'&idw='+document.getElementById('changeword_word').getAttribute('data-id')+'&word='+document.getElementById('changeword_word').value+'&trad='+JSON.stringify(allTrad)+'&comm='+document.getElementById('changeword_comm').value);
	change_word.onreadystatechange = function()
	{
		if(change_word.readyState == 4)
		{
			getMyWords();
			changePage('dico');
		}
	}
},false);

document.getElementById('gm_accueil').addEventListener('click',function(){
	selectDico('general');
	closeMenu();
},false);
document.getElementById('gm_param').addEventListener('click',function(){
	changePage('param');
	closeMenu();
},false);
document.getElementById('changeword_addtrad').addEventListener('click',function(){
	if(document.getElementById('changeword_trad').getElementsByTagName('input')[document.getElementById('changeword_trad').getElementsByTagName('input').length-1].value != '')
	{
		var allVal = [];
		var inps = document.getElementById('changeword_trad').getElementsByTagName('input');
		var i = 0;
		for(i = 0;i < inps.length;i++)
		{
			allVal[i] = inps[i].value;
		}
		document.getElementById('changeword_trad').innerHTML += '<input type="text" data-id="" value="" placeholder="Traduction..."/>';
		inps = document.getElementById('changeword_trad').getElementsByTagName('input');
		for(i = 0;i < allVal.length;i++)
		{
			inps[i].value = allVal[i]
		}
	}
},false);
document.getElementById('addtrad_addtrad').addEventListener('click',function(){
	if(document.getElementById('addtrad_personal').getElementsByTagName('input')[document.getElementById('addtrad_personal').getElementsByTagName('input').length-1].value != '')
	{
		var allVal = [];
		var inps = document.getElementById('addtrad_personal').getElementsByTagName('input');
		var i = 0;
		for(i = 0;i < inps.length;i++)
		{
			allVal[i] = inps[i].value;
		}
		document.getElementById('addtrad_personal').innerHTML += '<div><input type="text" value="" placeholder="Entrez une traduction..."/></div>';
		inps = document.getElementById('addtrad_personal').getElementsByTagName('input');
		for(i = 0;i < allVal.length;i++)
		{
			inps[i].value = allVal[i]
		}
	}
},false);
document.getElementById('remove_word').addEventListener('click',function(){
	remove_word.open('POST',url);
	remove_word.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	remove_word.send('id='+userid+'&req=removeword&dico='+currentDico+'&word='+document.getElementById('changeword_word').getAttribute('data-id'));
	remove_word.onreadystatechange = function()
	{
		if(remove_word.readyState == 4)
		{
			getMyWords();
			changePage('dico');
		}
	}
},false);
document.getElementById('gm_adddico').addEventListener('click',function(){
	document.getElementById('gm_adddico_form').style.display = 'block';
	document.getElementById('elem_gm_dico').style.height = 'auto';
},false);
document.getElementById('gm_adddico_form_valid').addEventListener('click',function(){
	add_dico.open('POST',url);
	add_dico.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	add_dico.send('id='+userid+'&req=adddico&fl='+document.getElementById('gm_adddico_form_lg1').value+'&sl='+document.getElementById('gm_adddico_form_lg2').value);
	add_dico.onreadystatechange = function()
	{
		if(add_dico.readyState == 4)
		{
			getDicos();
		}
	}
},false);
document.getElementById('dico_loupe').addEventListener('click',function(){
	document.getElementById('dico_search').style.left = '50px';
	document.getElementById('dico_search').classList.add("active");
},false);
document.getElementById('dico_content').addEventListener('click',function(){
	if (document.getElementById('dico_search').classList.contains("active")) {
		closeRecherche();
	}
},false);
document.getElementById('gm_dico').addEventListener('click',function(){
	var elem = document.getElementById('elem_gm_dico');
	var height_auto;
	if (elem.classList.contains('active')) {
		elem.classList.remove('active');
		elem.style.height = "0px";
		elem.style.visibility = "hidden";
	}
	else{
		elem.style.height ="auto";
		height_auto = elem.offsetHeight;
		//console.log(height_auto);
		elem.style.height = "0px";
		elem.style.visibility = "visible";
		elem.style.height = height_auto+"px";
		elem.classList.add('active');
	}
},false);
document.getElementById('btn_random').addEventListener('click',function(){
	changePage('startquiz');
},false);
document.getElementById('sq_start').addEventListener('click',function()
{
	changePage('quizz');
	inQuizz = true;
	debQuizz = new Date();
	tabQuest = allMyWord;
	timeQuizz = parseInt(document.getElementById('sq_time').value);
	nbWQuizz = allMyWord.length-1;
	var reqMissWords = new XMLHttpRequest();
	if(nbWQuizz < timeQuizz*2) // En supposant qu'une personne ne met jamais moins de 0.5 sec à répondre
	{
		reqMissWords.open('POST',url);
		reqMissWords.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		reqMissWords.send('id='+userid+'&req=getlist&type=unknowns&limit='+(timeQuizz*2 - nbWQuizz));
		reqMissWords.onreadystatechange = function()
		{
			if(reqMissWords.readyState == 4)
			{
				var nw = JSON.parse(reqMissWords.responseText);
				var i = 0;
				for(i = 0;i < nw.length;i++)
				{
					tabQuest[tabQuest.length] = nw[i];
				}
				prepareQuizz();
			}
		}
	}
	else
	{
		prepareQuizz();
	}
},false);
document.getElementById('gm_listes').addEventListener('click', function(){
	var elem = document.getElementById('elem_gm_listes');
	var height_auto;
	if (elem.classList.contains('active')) {
		elem.classList.remove('active');
		elem.style.height = "0px";
		elem.style.visibility = "hidden";
	}
	else{
		elem.style.height ="auto";
		height_auto = elem.offsetHeight;
		//console.log(height_auto);
		elem.style.height = "0px";
		elem.style.visibility = "visible";
		elem.style.height = height_auto+"px";
		elem.classList.add('active');
	}
},false);
document.getElementById('ajr').addEventListener('click', function(){
	show_listes(this);
});
document.getElementById('rv').addEventListener('click', function(){
	show_listes(this);
});
document.getElementById('mi').addEventListener('click', function(){
	show_listes(this);
});
document.getElementById('mpl').addEventListener('click', function(){
	changePage('playlists');
	closeMenu();
	document.getElementById('pl_content').innerHTML = "";
	my_playlists();
});
document.getElementById('new_pl').addEventListener('click', function(){
	document.getElementById('pl_content').innerHTML = "<h2>Ajout playlist</h2><input id='newpl_name' type='text' name='name' placeholder='Nom playlist'><div id='submit_addpl' class='btn_valid' onclick='ajoutPl()'>Ajouter</div>";
});

document.getElementById('gm_stats').addEventListener('click', function(){
	changePage('stats');
	closeMenu();
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
				ctx.fillText(data[i].d,(can.width/data.length)*(i+0.5),can.height-5);
			}
		}
	}
},false);
function show_listes(elem){
	var type= "";
	var titre = "";
	changePage('listes');
	closeMenu();
	var getlist = new XMLHttpRequest();
	getlist.open('POST',url);
	getlist.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	switch(elem.id){
		case 'ajr':
			type='lastadd';
			titre="Ajouts récent";
			break;
		case 'rv':
			type='lastmodif';
			titre ="Dernières modifications";
			break;
		case 'mi':
			type='unknowns';
			titre = "Les 25 inconnus";
			break;
	}
	getlist.send('id='+userid+'&req=getlist&type='+type);
	getlist.onreadystatechange = function()
	{
		if(getlist.status == 200)
		{
			allMyWord = getlist.responseText;
		}
		else
		{
			allMyWord = store.getItem('words');
		}

		getWord('li_content');
	}
}
function my_playlists(){
	var getplaylists = new XMLHttpRequest();
	getplaylists.open('POST',url);
	getplaylists.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	getplaylists.send('id='+userid+'&req=getmylists');
	getplaylists.onreadystatechange = function(){
		if (getplaylists.readyState == 4) {
			var pl = JSON.parse(getplaylists.responseText);
			for (var i = 0; i < pl.length; i++) {
				document.getElementById('pl_content').innerHTML += '<div class="myPlaylist" ><p onclick="openPl(\''+pl[i]["name"]+'\')">'+pl[i]["name"]+'</p><p class="rouge" onclick="delPl(\''+pl[i]["name"]+'\')">X</p></div>';
			}
			
		}
	}
}
function openPl(name){
	var getListPl = new XMLHttpRequest();
	getListPl.open('POST',url);
	getListPl.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	getListPl.send('id='+userid+'&req=getlistcontent&name='+name);
	getListPl.onreadystatechange = function(){
		document.getElementById('pl_content').innerHTML = name;
		document.getElementById('pl_content').innerHTML += '<div id="addInPl" onclick="addWordPl(\''+name+'\')">+</div>';
		if (getListPl.readyState == 200) {
			var li = JSON.parse(getListPl.responseText);
			for (var i = 0; i < pl.length; i++) {
				document.getElementById('pl_content').innerHTML += '<div class="contentPl"><p>'+li[i]["name"]+'<span class="rouge" onclick="suppInPl(\''+li[i]["name"]+'\')">X</span></p></div>';
			}
			
		}
	}
}
function addWordPl(name){
	document.getElementById('pl_content').innerHTML = "<h5>Ajout Mot <span class='nomPl'>"+name+"</span></h5>";
	document.getElementById('pl_content').innerHTML += "<input type='text' name='mot' id='motAddPl'><div id='submit_addpl' class='btn_valid' onclick=''>Ajouter</div>";

}
function suppInPl(name){
	var suppInPl = new XMLHttpRequest;
	suppInPl.open('POST',url);
	suppInPl.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	suppInPl.send('id='+userid+'&req=removewordfromlist&name='+name);
	suppInPl.onreadystatechange = function(){
		if(suppPl.readyState == 200){
			document.getElementById('pl_content').innerHTML = "";
			my_playlists();
		}
	}
}
function delPl(name){
	var suppPl = new XMLHttpRequest;
	suppPl.open('POST',url);
	suppPl.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	suppPl.send('id='+userid+'&req=removelist&name='+name);
	suppPl.onreadystatechange = function(){
		if(suppPl.readyState == 4){
			document.getElementById('pl_content').innerHTML = "";
			my_playlists();
		}
	}
}
function ajoutPl(){
	var val = document.getElementById('newpl_name').value;
	if (val=="") {
		document.getElementById('error_pl').innerHTML = "Veuillez saisir un nom valide";
	}
	else{
		addPlaylist(val);
	}
}
function addPlaylist(name){
	var addPl = new XMLHttpRequest();
	addPl.open('POST',url);
	addPl.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	addPl.send('id='+userid+'&req=addlist&name='+name);
	addPl.onreadystatechange = function(){
		if(addPl.readyState == 4){
			document.getElementById('pl_content').innerHTML = "";
			my_playlists();
		}
	}
}
function prepareQuizz()
{
	var i = 0;
	var a = 0;
	var b = 0;
	var c = 0;
	for(i = 0;i < tabQuest.length*10;i++)
	{
		a = randint(0,tabQuest.length);
		b = randint(0,tabQuest.length);
		var c = tabQuest[a] ;
		tabQuest[a] = tabQuest[b];
		tabQuest[b] = c;
	}
	start_chrono.open('GET',url);
	start_chrono.send();
	start_chrono.onreadystatechange = function()
	{
		if(start_chrono.readyState == 4)
		{
			chronoQuizz();
		}
	}
	allQsQuizz = 0;
	pointsQuizz = 0;
	idQuizz = 0;
	newQuizzSlide();

}
function closeMenu()
{
	document.getElementById('global_menu').style.left = '';
	document.getElementById('global_menu_container').style.left = '';
}
function openMenu()
{
	document.getElementById('global_menu').style.left = '0%';
	document.getElementById('global_menu_container').style.left = '0%';
}
function closeRecherche(){
	document.getElementById('dico_search').style.width = '0%';
	document.getElementById('dico_search').classList.remove('active');
}
function getMyWords()
{
	get_mywords.open('POST',url);
	get_mywords.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	get_mywords.send('id='+userid+'&req=getmyword&dico='+currentDico+'');
	get_mywords.onreadystatechange = function(){
		if(get_mywords.readyState == 4)
		{
			if(get_mywords.status == 200)
			{
				allMyWord = get_mywords.responseText;
				
			}
			else
			{
				allMyWord = store.getItem('words');
			}
			getWord('dico_content',true,true);
		}
	}
}
function getWord(container,displayFav,dispayLet){
	if(allMyWord != '')
	{
		var lastLetter = '';
		store.setItem('words',allMyWord);
		allMyWord = JSON.parse(allMyWord);
		document.getElementById(container).innerHTML = '<div class="dico_allfav"></div>';
		var i = 0;
		var fav = '';
		if(allMyWord.length > 0 && allMyWord[0]['favorite'] == 1 && displayFav)
		{
			document.getElementById(container).getElementsByClassName('dico_allfav')[0].innerHTML += '<div class="dico_oneletter">Favoris</div>';
		}
		for(i = 0;i < allMyWord.length;i++)
		{
			//if(i > 1 && word[i]['favorite'] != 1 && word[i-1]['favorite'] == 1)
			//{
				//alert(allMyWord[i]['favorite']+' == 0 && '+allMyWord[i-1]['favorite']+' == 1');
				//document.getElementById('dico_content').innerHTML += '</div>';
			//}
			if(allMyWord[i]['content'][0] != lastLetter && allMyWord[i]['favorite'] != 1 && dispayLet)
			{
				document.getElementById(container).innerHTML += '<div class="dico_oneletter">'+allMyWord[i]['content'][0].toUpperCase()+'</div>';
				lastLetter = allMyWord[i]['content'][0];
			}
			fav = '';
			if(allMyWord[i]['favorite'] == 1 && displayFav)
			{
				fav = 'fav-ok';
				document.getElementById(container).getElementsByClassName('dico_allfav')[0].innerHTML += '<div class="dico_oneword" id="wordnb'+i+'" onclick="changeWord(this);" data-comm="'+allMyWord[i]['commentaire']+'"><p class="dico_ow_main">'+allMyWord[i]['content']+'</p> <p class="dico_ow_trad">'+allMyWord[i]['trad']+'</p></div><span onclick="setWordFav(\'wordnb'+i+'\','+allMyWord[i]['favorite']+')" class="dico_ow_fav '+fav+'"></span>';
			}
			else
			{
				document.getElementById(container).innerHTML += '<div class="dico_oneword" id="wordnb'+i+'" onclick="changeWord(this);" data-comm="'+allMyWord[i]['commentaire']+'"><p class="dico_ow_main">'+allMyWord[i]['content']+'</p> <p class="dico_ow_trad">'+allMyWord[i]['trad']+'</p></div>';
				if(displayFav)
				{
					document.getElementById(container).innerHTML += '<span onclick="setWordFav(\'wordnb'+i+'\','+allMyWord[i]['favorite']+')" class="dico_ow_fav '+fav+'"></span>';
				}
			}
		}
	}
}
function getDicos()
{
	get_mydicos.open('POST',url);
	get_mydicos.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	get_mydicos.send('id='+userid+'&req=getdicos');
	get_mydicos.onreadystatechange = function(){
		if(get_mydicos.readyState == 4)
		{
			var dicos = JSON.parse(get_mydicos.responseText);
			document.getElementById('gm_alldico').innerHTML = '';
			var i = 0;
			var dname = '';
			for(i = 0;i < dicos.length;i++)
			{
				dname = dicos[i]['name'];
				if(dicos[i]['name'] == 'default')
				{
					dname = 'EN / FR';
				}
				document.getElementById('gm_alldico').innerHTML += '<div class="content_one_dico"><div class="one_dico" data-name="'+dicos[i]['name']+'" onclick="getDicosParams(this);">'+dname+'</div><div class="param_one_dico"><span onclick="selectDico(\''+dicos[i]['name']+'\');">Séléctionner</span><span onclick="removeDico(\''+dicos[i]['name']+'\')">Supprimer</span></div></div>';
			}
		}
	}
}


function setWordValue(elem)
{
	document.getElementById('addword_word').value = elem.innerHTML;
	document.getElementById('addword_completion').innerHTML = '';
	getCplAndSugg(elem.innerHTML);
}
function seTradValue(elem)
{
	document.getElementById('addtrad_personal').getElementsByTagName('input')[0].value = elem.innerHTML;
}
function getCplAndSugg(word)
{
	document.getElementById('addtrad_suggest').innerHTML = '<h3>Suggestions</h3>';
	get_cpl.open('POST',url);
	get_cpl.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	get_cpl.send('id='+userid+'&req=getcpl&dico='+currentDico+'&word='+word);
	get_cpl.onreadystatechange = function()
	{
		if(get_cpl.readyState == 4)
		{
			if(get_cpl.responseText != '')
			{
				var cplContent = JSON.parse(get_cpl.responseText)['cpl'];
				var i = 0;
				document.getElementById('addword_completion').innerHTML = '';
				for(i = 0;i < cplContent.length;i++)
				{
					document.getElementById('addword_completion').innerHTML += '<div class="addword_onecpl" onclick="setWordValue(this);">'+cplContent[i]['content']+'</div>';
				}
				var sugg = JSON.parse(get_cpl.responseText)['sugg'];
				var i = 0;
				for(i = 0;i < sugg.length;i++)
				{
					document.getElementById('addtrad_suggest').innerHTML += '<span class="addtrad_one_suggest" onclick="seTradValue(this);">'+sugg[i][0]+'</span>';
				}
			}
		}
	}

}
function toogleLg()
{
	if(document.getElementById('addword_lg').value == document.getElementById('addtrad_lg').value)
	{
		if(document.getElementById('addword_lg').value == 'fr')
		{
			document.getElementById('addtrad_lg').value = 'en';
		}
		else
		{
			document.getElementById('addtrad_lg').value = 'fr';
		}
	}
}
function changeWord(elem)
{
	changePage('changeword');
	document.getElementById('changeword_word').value = elem.getElementsByClassName('dico_ow_main')[0].innerHTML;
	document.getElementById('changeword_word').setAttribute('data-id',elem.getElementsByClassName('dico_ow_main')[0].innerHTML);

	var strTrad = elem.getElementsByClassName('dico_ow_trad')[0].innerHTML;
	var allTrad = strTrad.split(', ');
	document.getElementById('changeword_trad').innerHTML = '';
	var i = 0;

	document.getElementById('changeword_comm').value = elem.getAttribute('data-comm');

	for(i = 0;i < allTrad.length;i++)
	{
		document.getElementById('changeword_trad').innerHTML += '<input type="text" data-id="'+allTrad[i]+'" value="'+allTrad[i]+'" placeholder="Traduction..."/>';
	}
}
function setWordFav(id,etat)
{
	elem = document.getElementById(id);
	change_fav.open('POST',url);
	change_fav.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	change_fav.send('id='+userid+'&req=setfavorite&dico='+currentDico+'&fav='+Math.abs(etat-1)+'&idw='+elem.getElementsByClassName('dico_ow_main')[0].innerHTML);
	change_fav.onreadystatechange = function()
	{
		if(change_fav.readyState == 4)
		{
			getMyWords();
		}
	}
}
function changePage(pageName)
{
	document.getElementsByClassName('active')[0].setAttribute('class','page');
	document.getElementById('p_'+pageName).setAttribute('class','page active');
	document.getElementById('global_alert').innerHTML = '';
	window.scrollTo(0,0);
}
function alerte(txt,type)
{
	if(type)
	{
		type = ' ua_'+type; 
	}
	else
	{
		type = '';
	}
	document.getElementById('global_alert').innerHTML += '<div class="uniq_alert'+type+'" onclick="this.parentNode.removeChild(this);">'+txt+'</div>';
}
function loadingPage(txt)
{
	document.getElementById('title_load').innerHTML = txt;
	changePage('load');
}
function getDicosParams(elem)
{
	if(elem.parentNode.getElementsByClassName('param_one_dico')[0].style.display == 'block')
	{
		elem.parentNode.getElementsByClassName('param_one_dico')[0].style.display = 'none';
		elem.style.backgroundColor='';
	}
	else
	{
		elem.parentNode.getElementsByClassName('param_one_dico')[0].style.display = 'block';
		elem.style.backgroundColor='#444';
	}
}
function removeDico(name)
{
	del_dico.open('POST',url);
	del_dico.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	del_dico.send('id='+userid+'&req=deldico&dico='+name);
	del_dico.onreadystatechange = function()
	{
		if(del_dico.readyState == 4)
		{
			getDicos();
		}
	}
}
function newQuizzSlide()
{
	var propositions = '';
	var trueRep = randint(0,4);
	var i = 0;
	var contentRep = '';
	var now;
	var str = '<h1 class="quizz_title">'+tabQuest[idQuizz]['content'].toUpperCase()+'</h1><div id="quizz_container_resp">';
	if(randint(0,4) == 0)
	{
		document.getElementById('quizz_content').innerHTML = str+'<input class="quizz_text_rep" placeholder="Traduction..."∕><div class="quizz_onerep">Ok</div></div>';
		document.getElementById('quizz_container_resp').getElementsByClassName('quizz_text_rep')[0].focus();
		document.getElementById('quizz_container_resp').getElementsByClassName('quizz_onerep')[0].addEventListener('click',function()
		{
			analyseRep(document.getElementById('quizz_container_resp').getElementsByClassName('quizz_text_rep')[0].value);
		},false);
	}
	else
	{
		for(i = 0;i < 4;i++)
		{
			if(i == trueRep)
			{
				contentRep = tabQuest[idQuizz]['trad'].split(',')[0];
			}
			else
			{
				contentRep = allMyWord[randint(0,allMyWord.length)]['trad'].split(',')[0];
			}
			propositions += '<div class="quizz_onerep">'+contentRep.toLowerCase()+'</div>';
		}
		document.getElementById('quizz_content').innerHTML = str+propositions+'</div>';
		for(i = 0;i < 4;i++)
		{
			document.getElementById('quizz_container_resp').getElementsByClassName('quizz_onerep')[i].addEventListener('click',function()
			{
				analyseRep(this.innerHTML);
			},false);
		}
	}
}
function analyseRep(txtRep)
{
	now = new Date();
	allQsQuizz++;
	var isGood = false;
	var j = 0;
	var allRep = tabQuest[idQuizz]['trad'].split(',');
	while(j < allRep.length && !isGood)
	{
		if(txtRep.toLowerCase() == tabQuest[idQuizz]['trad'].split(',')[j].toLowerCase())
		{
			isGood = true;
		}
		j++;
	}
	if(isGood)
	{
		document.getElementById('p_one_color').style.backgroundColor = '#5F5';
		pointsQuizz++;
	}
	else
	{
		document.getElementById('p_one_color').style.backgroundColor = 'red';
	}
	tabQuest[idQuizz]['perso_rep'] = txtRep;
	changePage('one_color');
	setTimeout(function(){
		changePage('quizz');
		if(idQuizz < tabQuest.length)
		{
			tabQuest[idQuizz].time = now - debQuizz
			idQuizz++;
			newQuizzSlide();
		}
		else
		{
			finQuizz(false);
		}
	},200);

}
function finQuizz(timeEnd)
{
	inQuizz = false;
	var timePassed = (now - debQuizz)/1000;
	if(timeEnd)
	{
		timePassed = timeQuizz;
	}
	var resumRep = '';
	var i = 0;
	var trCol = '';
	var saveQuizz = new XMLHttpRequest();
	var saveQuest = [];
	saveQuizz.open('POST',url);
	saveQuizz.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	for(i = 0;i < allQsQuizz;i++)
	{
		saveQuest[i] = tabQuest[i];
		trCol = '#F55';
		if(tabQuest[i]['trad'].split(',')[0].toLowerCase() == tabQuest[i]['perso_rep'].toLowerCase())
		{
			trCol = '#5F5';
		}
		resumRep += '<tr style="background-color:'+trCol+'"><td>'+tabQuest[i]['content']+'</td><td>'+tabQuest[i]['perso_rep']+'</td><td>'+tabQuest[i]['trad']+'</td></tr>'
	}
	saveQuizz.send('id='+userid+'&req=savequizz&time='+timePassed+'&nbmots='+allQsQuizz+'&nbtrue='+pointsQuizz+'&data='+JSON.stringify(saveQuest));
	document.getElementById('quizz_content').innerHTML = '<h1 class="quizz_title">Bravo !!!</h1><div id="quizz_container_fin">Tu as <strong>'+pointsQuizz+'</strong> bonnes réponses sur <strong>'+allQsQuizz+'</strong> mots en <strong>'+timePassed+' secondes</strong> !</div><table id="qz_tab_fin"><tr><th>Mot</th><th>Votre réponse</th><th>Traduction</th></tr>'+resumRep+'</table><div class="btn_valid" id="sq_restart">Recommencer</div>';
	document.getElementById('sq_restart').addEventListener('click',function(){
		changePage('startquiz');
	},false);
}
function chronoQuizz()
{
	if(inQuizz)
	{
		now = new Date();
		if(timeQuizz - Math.floor((now - debQuizz)/1000) <= 0)
		{
			idQuizz = nbWQuizz+1;
			finQuizz(true);
		}
		document.getElementById('quizz_time').innerHTML = pointsQuizz+' / '+allQsQuizz + ' | '+ (timeQuizz - Math.floor((now - debQuizz)/1000));
		setTimeout(function(){chronoQuizz();},500);
	}
}
function selectDico(name)
{
	currentDico = name;
	var nomDic = name;
	if(name == 'default')
	{
		nomDic = 'EN/FR';
	}
	if(name == 'general')
	{
		nomDic = 'général';
	}
	else
	{
		document.getElementById('p_addword').getElementsByTagName('h2')[0].innerHTML = 'Mot '+fullCountryName(nomDic.substring(0,2));
	}
	document.getElementById('dico_title').innerHTML = 'Dictionnaire '+nomDic;
	getMyWords();
	closeMenu();
}
function randint(a,b)
{
	if(a > b)
	{
		var c = a;
		a = b;
		b = c;
	}
	return Math.floor(Math.random()*(b-a)+a);
}
function fullCountryName(ac)
{
	ac = ac.toLowerCase();
	switch(ac)
	{
		case 'en':
			return 'Anglais';
			break;
		case 'fr':
			return 'Français';
			break;
		case 'es':
			return 'Espagnol';
			break;
		case 'al':
			return 'Allemand';
			break;
		case 'it':
			return 'Italien';
			break;

	}
}
document.addEventListener('keydown',function(e)
{
	if(e.keyCode == 13 && inQuizz && document.getElementById('quizz_container_resp').getElementsByClassName('quizz_text_rep').length > 0)
	{
		analyseRep(document.getElementById('quizz_container_resp').getElementsByClassName('quizz_text_rep')[0].value);
	}
},false);