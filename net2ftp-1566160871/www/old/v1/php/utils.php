<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	session_start();
	if(isset($_POST) && isset($_POST['req']))
	{
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=mpdico;charset=utf8','root','grisous55');
		}
		catch(Exeption $e)
		{
			die($e->getMessage());
		}
		if($_POST['req'] == 'connect')
		{
			if(isset($_POST['mail']) && isset($_POST['mdp']) && $_POST['mail'] != '' && $_POST['mdp'] != '')
			{
				echo 'cnnext';
				$coUser = $bdd->prepare('SELECT id FROM users WHERE mail = ? and mdp = ?');
				$coUser->execute(array($_POST['mail'],$_POST['mdp']));
				$coUser = $coUser->fetch();
				print_r($coUser);
				if(isset($coUser['id']))
				{
					$lastCo = $bdd->prepare('UPDATE users SET lastco=NOW() WHERE id=?');
					$lastCo->execute(array($coUser['id']));
					$_SESSION['id'] = cryptId($coUser['id']);
					header('Location: ../appli.php');
				}
				else
				{
					header('Location: ../connect.php?error=1');
				}
			}
		}
		else if($_POST['req'] == 'newuser')
		{
			if(isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['nom']) && isset($_POST['mdp']) && isset($_POST['mdp2']) && $_POST['prenom'] != '' && $_POST['mail'] != '' && $_POST['nom'] != '' && $_POST['mdp'] != '' && $_POST['mdp'] == $_POST['mdp2'])
			{
				$verifNE = $bdd->prepare('SELECT id FROM users WHERE mail = ?');
				$verifNE->execute(array($_POST['mail']));
				$verifNE->fetch();
				if(isset($coUser['id']))
				{
					header('Location: ../inscr.php?error=1');
				}
				else
				{
					$nuser = $bdd->prepare('INSERT INTO users (prenom,nom,mail,mdp) VALUES (?,?,?,?)');
					$nuser->execute(array($_POST['prenom'],$_POST['nom'],$_POST['mail'],$_POST['mdp']));
			
					$getid = $bdd->query('SELECT id FROM users WHERE prenom = "'.$_POST['prenom'].'" and mail = "'.$_POST['mail'].'" ORDER BY id DESC LIMIT 10');
					$getid = $getid->fetch();
			
					$ndico = $bdd->prepare('INSERT INTO dicos (user_id,name) VALUES (?,"default")');
					$ndico->execute(array($getid['id']));
			
					$_SESSION['id'] = cryptId($getid['id']);
					header('Location: ../appli.php');
				}
			}
		}
		else if(isset($_SESSION['id']) || isset($_POST['id']))
		{
			if(isset($_SESSION['id']))
			{
				$iduser = uncryptId($_SESSION['id']);
			}
			else
			{
				$iduser = uncryptId($_POST['id']);
			}
			
			$userinfo = $bdd->query('SELECT * FROM users WHERE id = '.$iduser);
			
			switch($_POST['req'])
			{
				case 'getmyword':
					$wd = 'default';
					if(isset($_POST['dico']) && $_POST['dico'] != '')
					{
						$wd = $_POST['dico'];
					}
					if($wd == 'general')
					{
						$myword = $bdd->query('SELECT content, trad, favorite, commentaire FROM words, dicos, users WHERE dico_id = dicos.id and user_id = users.id and users.id = '.$iduser.' and content <> "" and trad <> "" ORDER BY favorite DESC, content');
					}
					else
					{
						$dico = $bdd->query('SELECT id FROM dicos WHERE user_id = '.$iduser.' and name ="'.$wd.'"');
						$dico = $dico->fetch();
						$myword = $bdd->query('SELECT content, trad, favorite, commentaire FROM words WHERE dico_id = '.$dico['id'].' and content <> "" and trad <> "" ORDER BY favorite DESC, content');
					}
					$myword = $myword->fetchAll();
					$i = 0;
					while($i < count($myword)-1)
					{
						if($myword[$i]['content'] == $myword[$i+1]['content'])
						{
							$myword[$i]['trad'] .= ', '.$myword[$i+1]['trad'];
							$myword = removeCase($myword,$i+1);
						}
						else
						{
							$i++;
						}
					}
					echo json_encode($myword);
					break;
				case 'getcpl':
					if(isset($_POST['word']) && $_POST['word'] != '')
					{
						$cplword = $bdd->query('SELECT DISTINCT content FROM words WHERE content LIKE "'.addslashes($_POST['word']).'%" and content <> "'.addslashes($_POST['word']).'" LIMIT 5');
						$cplword = $cplword->fetchAll();
						$suggword = $bdd->query('SELECT DISTINCT trad FROM words WHERE content  = "'.addslashes($_POST['word']).'"');
						$suggword = $suggword->fetchAll();
						echo json_encode(array('sugg'=>$suggword,'cpl'=>$cplword));
						break;
					}
					break;
				case 'addtrad':
					if(isset($_POST['word']) && $_POST['word'] != '' && isset($_POST['lg']) && isset($_POST['lastlg']) && isset($_POST['fw']))
					{
						$wd = 'default';
						if(isset($_POST['dico']) && $_POST['dico'] != '')
						{
							$wd = $_POST['dico'];
						}
						$allTrad = json_decode($_POST['word']);
						for($i = 0;$i < count($allTrad);$i++)
						{
							if($allTrad[$i] != '')
							{
								echo $i.' - '.$allTrad[$i].' - '.$_POST['fw'].'  |  '.$iduser;
								addWord($iduser,$wd,$_POST['fw'],$allTrad[$i],$_POST['lastlg'],$_POST['lg']);
							}
						}
					}
					break;
				case 'verifuser':
					$verifUser = $bdd->query('SELECT id, nom, prenom, mail FROM users WHERE id = '.$iduser);
					$verifUser = $verifUser->fetch();
					if(isset($verifUser['nom']))
					{
						$verifUser['state'] = 'ok';
						$verifUser['id'] = cryptId($verifUser['id']);
						$verifUser[0] = $verifUser['id'];
						echo json_encode($verifUser);
					}
					else
					{
						echo 'no';
					}
					break;
				case 'getsuggest':
					$suggword = $bdd->query('SELECT DISTINCT content FROM words WHERE trad = "'.addslashes($_POST['word']).'"');
					$suggword = $suggword->fetchAll();
					echo json_encode($suggword);
					break;
				case 'changeword':
					$wd = 'default';
					$trad = json_decode($_POST['trad'],true);
					if(isset($_POST['dico']) && $_POST['dico'] != '' &&  $_POST['dico'] != 'general')
					{
						$wd = $_POST['dico'];
					}
					$dico = $bdd->query('SELECT id FROM dicos WHERE user_id = '.$iduser.' and name ="'.$wd.'"');
					$dico = $dico->fetch();

					$chword = $bdd->prepare('UPDATE words SET content = ?, commentaire = ?, lastmodif=NOW() WHERE dico_id='.$dico['id'].' and content=?');
					$chword->execute(array($_POST['word'],$_POST['comm'],$_POST['idw']));
					for($i = 0;$i < count($trad);$i++)
					{
						if($trad[$i]['f'] != $trad[$i]['n'])
						{
							if($trad[$i]['f'] != '')
							{
								if($i == 0)
								{
									$chtrad = $bdd->prepare('UPDATE words SET content = ?, lastmodif=NOW() WHERE dico_id='.$dico['id'].' and content=?');
									$chtrad->execute(array($trad[$i]['n'],$trad[$i]['f']));
								}
								else
								{
									$chtrad = $bdd->prepare('UPDATE words SET trad = ?, lastmodif=NOW() WHERE dico_id='.$dico['id'].' and trad=?');
									$chtrad->execute(array($trad[$i]['n'],$trad[$i]['f']));
								}
							}
							else
							{
								addWord($iduser,$wd,$_POST['word'],$trad[$i]['n'],'fr','en');
							}
						}
					}
					break;
				case 'removeword':
					$wd = 'default';
					if(isset($_POST['dico']) && $_POST['dico'] != '')
					{
						$wd = $_POST['dico'];
					}
					$dico = $bdd->query('SELECT id FROM dicos WHERE user_id = '.$iduser.' and name ="'.$wd.'"');
					$dico = $dico->fetch();

					$del = $bdd->prepare('DELETE FROM words WHERE dico_id = ? and content = ?');
					$del->execute(array($dico['id'],$_POST['word']));
					break;
				case 'setfavorite':
					$wd = 'default';
					if(isset($_POST['dico']) && $_POST['dico'] != '' &&  $_POST['dico'] != 'general')
					{
						$wd = $_POST['dico'];
					}
					$dico = $bdd->query('SELECT dicos.id FROM dicos,words WHERE user_id = '.$iduser.' and content = "'.$_POST['idw'].'" and dico_id = dicos.id');
					$dico = $dico->fetch();

					$fav = $bdd->prepare('UPDATE words SET favorite = ? WHERE content = ? and dico_id = ?');
					$fav->execute(array($_POST['fav'],$_POST['idw'],$dico['id']));
					echo 'ok';
					break;
				case 'getdicos':
					$dic = $bdd->query('SELECT name FROM dicos WHERE user_id = '.$iduser);
					$dic = $dic->fetchAll();
					echo json_encode($dic);
					break;
				case 'adddico':
					$dic = $bdd->prepare('INSERT INTO dicos (name, user_id) VALUES (?,'.$iduser.')');
					$dic->execute(array(mb_strToUpper($_POST['fl']).' / '.mb_strToUpper($_POST['sl'])));
					break;
				case 'deldico':
					if(isset($_POST['dico']) && $_POST['dico'] != '' && $_POST['dico'] != 'default')
					{
						$dic = $bdd->prepare('DELETE FROM dicos WHERE name = ? and user_id = '.$iduser);
						$dic->execute(array($_POST['dico']));
					}
					break;
				case 'getlist':
					$limit = 25;
					if(isset($_POST['limit']) && $_POST['limit'] != '')
					{
						$limit = $_POST['limit'];
					}
					$r='';
					switch($_POST['type'])
					{
						case 'lastadd':
							$r = $bdd->query('SELECT content, trad, favorite, commentaire FROM words, dicos, users WHERE dico_id = dicos.id and user_id = users.id and users.id = '.$iduser.' and content <> "" and trad <> "" ORDER BY words.id DESC LIMIT '.$limit);
							$r = $r->fetchAll();
							break;
						case 'unknowns':
							$r = $bdd->query('SELECT content, trad, favorite, commentaire FROM words WHERE words.id NOT IN (SELECT words.id FROM words, dicos, users WHERE dico_id = dicos.id and user_id = users.id and users.id = '.$iduser.') ORDER BY words.id DESC LIMIT '.$limit);
							$r = $r->fetchAll();
							break;
						case 'lastmodif':
							$r = $bdd->query('SELECT content, trad, favorite, commentaire FROM words, dicos, users WHERE dico_id = dicos.id and user_id = users.id and users.id = '.$iduser.' and content <> "" and trad <> "" ORDER BY lastmodif DESC, words.id DESC LIMIT '.$limit);
							$r = $r->fetchAll();
							break;
					}
					echo json_encode($r);
					break;
				case 'getstat':
					$nbW = $bdd->query('SELECT COUNT(*) as nb FROM words, dicos, users WHERE dico_id = dicos.id and user_id = users.id and users.id = '.$iduser.' and content <> "" and trad <> ""');
					$nbW = $nbW->fetch();
					$t = $bdd->query('SELECT SUM(time) as t, SUM(nbmots) as nm, SUM(nbtrue) as nt FROM quizz WHERE user_id = '.$iduser);
					$t = $t->fetch();
					$graph = $bdd->query('SELECT SUM(time) as t, SUM(nbmots) as nm, SUM(nbtrue) as nt, DATE_FORMAT(datet,"%d/%m") as d FROM quizz WHERE user_id = '.$iduser.' GROUP BY DATE(datet) ORDER BY datet ASC LIMIT 10');
					if($graph)
					{
						$graph = $graph->fetchAll();					
						if($t['nm'] == 0)
						{
							$t['nm']++;
						}
						if($t['t'] == 0)
						{
							$t['t']++;
						}
						echo 'Vous avez <strong>'.$nbW['nb'].'</strong> mots enregistrés (tout dictionnaires confondus)<br/>';
						echo 'Vous avez passer <strong>'.humanTime($t['t']).'</strong> sur le quizz<br/>';
						echo 'Vous avez <strong>'.floor(($t['nt']/$t['nm'])*100).' %</strong> de bonnes réponses sur <strong>'.$t['nm'].'</strong> mots testés.<br/>';
						echo 'Vous avez un temps de réponse moyen de <strong>'.(floor(($t['nm']/$t['t'])*100)/100).'</strong> secondes par mot.<br/>';
						echo '<div class="hidden" id="stat_graph_data">'.json_encode($graph).'</div>';
					}
					else
					{
						echo 'Nous n\'avons pas encore assez de données pour afficher vos statistiques';
					}
					break;
				case 'savequizz':
					if(isset($_POST['data']) && isset($_POST['time']) && isset($_POST['nbmots']) && isset($_POST['nbtrue']))
					{
						$s = $bdd->prepare('INSERT INTO quizz (user_id,mots,time,nbmots,nbtrue) VALUES (?,?,?,?,?)');
						$s->execute(array($iduser,$_POST['data'],$_POST['time'],$_POST['nbmots'],$_POST['nbtrue']));
					}
					break;
				case 'getlist':
					$l = $bdd->query('SELECT content, trad, favorite, commentaire FROM listes, liste_word, words WHERE listes.user_id = '.$iduser.' and liste.name = "'.$_POST['name'].'" and listes.id = liste_word.liste_id and words.id = liste_words.word_id ORDER BY content ASC');
					$l = $l->fetchAll();
					echo json_encode($l);
					break;
				case 'getmylists':
					$l = $bdd->query('SELECT name FROM listes WHERE listes.user_id = '.$iduser.' ORDER BY name ASC');
					$l = $l->fetchAll();
					echo json_encode($l);
					break;
				case 'addlist':
					$l = $bdd->prepare('INSERT INTO listes (user_id,name) VALUES (?,?)');
					$l->execute(array($iduser,$_POST['name']));
					break;
				case 'addwordtolist':
					$idL = $bdd->query('SELECT id FROM listes WHERE listes.user_id = '.$iduser.' and name = "'.$_POST['name'].'" ORDER BY name ASC');
					$idL = $idL->fetch();
					$l = $bdd->prepare('INSERT INTO liste_word (liste_id,word_content) VALUES (?,?)');
					$l->execute(array($idL['id'],$_POST['word']));
					break;
				case 'removelist':
					$l = $bdd->prepare('DELETE FROM listes WHERE user_id=? and name=?');
					$l->execute(array($iduser,$_POST['name']));
					break;
				case 'addwordtolist':
					$idL = $bdd->query('SELECT id FROM listes WHERE listes.user_id = '.$iduser.' and name = "'.$_POST['name'].'" ORDER BY name ASC');
					$idL = $idL->fetch();
					$l = $bdd->prepare('DELETE FROM liste_word WHERE liste_id=? and word_content=?');
					$l->execute(array($idL['id'],$_POST['word']));
					break;
				case 'deco':
					$_SESSION['id'] = '';
					unset($_SESSION['id']);
					session_destroy();
					break;
			}
		}
	}
	function cryptId($a)
	{
		return (($a * 12 + 83)*3 + 67);
	}
	function uncryptId($a)
	{
		return ((($a - 67)/3 - 83) / 12);
	}
	function removeCase($tab,$i)
	{
		for($j = $i;$j < count($tab)-1;$j++)
		{
			$tab[$j] = $tab[$j+1];
		}
		unset($tab[count($tab)-1]);
		return $tab;
	}
	function humanTime($t)
	{
		if($t < 60)
		{
			return $t.' s';
		}
		else if($t < 3600)
		{
			return floor($t/60).'min '.($t%60).'s';
		}
		else
		{
			return floor($t/3600).'h '.(floor($t/60)%60).'min ';
		}
	}
	function addWord($iduser,$wd,$fw,$word,$lastlg,$lg)
	{
		global $bdd;
		$exist = $bdd->query('SELECT words.id FROM words,dicos WHERE content = "'.$fw.'" and trad = "'.$word.'" and  user_id = '.$iduser.' and name ="'.$wd.'" and dico_id = dicos.id');
		$exist = $exist->fetchAll();
		if(count($exist) == 0)
		{
			$dico = $bdd->query('SELECT id FROM dicos WHERE user_id = '.$iduser.' and name ="'.$wd.'"');
			$dico = $dico->fetch();
			
			$aw = $bdd->prepare('INSERT INTO words (content,trad,dico_id,langue,commentaire) VALUES (?,?,?,"","")');
			$aw->execute(array($fw,$word,$dico['id']));
		}
	}
?>