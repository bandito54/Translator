<?php
	error_reporting(E_ALL);
	try
        {
                $bdd = new PDO('mysql:host=je47502-001.privatesql:35531;dbname=dicoti;charset=utf8','Baptiste','Aikene1097');
        }
        catch(Exeption $e)
        {
                die($e->getMessage());
        }
	$n = 0;
	$fr = explode("\n",file_get_contents("./dict.txt"));
	$en = explode("\n",file_get_contents("./dict_fr-en.txt"));
	for($i = 0;$i < count($fr);$i++)
	{
		if($fr[$i] != "" && $en[$i] != "")
		{
			echo $fr[$i]." = ".$en[$i]."\n";
			$req = $bdd->prepare('INSERT INTO words (content,trad,dico_id,langue,commentaire) VALUES (?,?,?,"","")');
			$req->execute(array($en[$i],$fr[$i],1));
			print_r($req->errorInfo());
			$n++;
		}
	}
	echo $n." mots ajoutés\n";
?>
