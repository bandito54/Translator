<?php
	error_reporting(E_ALL);
	$j = 1;
	$feed = file_get_contents($_GET['url']);
	preg_match('/<title>(.+)<\/title>/',$feed,$title);
	$title = getMark('title',$feed);
	$j = array('title' => $title,'news'=>array());
	$titles = getAllMarks('title',$feed);
	$link = getAllMarks('link',$feed);
	$pubDate = getAllMarks('pubDate',$feed);
	for($i = 0;$i < count($titles)-1 && $i < 5;$i++)
	{
		$j['news'][$i] = array(
			'title'=>html_entity_decode($titles[$i+1]),
			'link'=>$link[$i+1],
			'date'=>date_format(date_create($pubDate[$i]),'h\h - d/m/Y')
		);
	}
	echo json_encode($j);
	function getMark($mark,$str)
	{
		preg_match('/<'.$mark.'>(.+)<\/'.$mark.'>/',$str,$match);
		return $match[1];
	}
	function getAllMarks($mark,$str)
	{
		preg_match_all('/<'.$mark.'>(.+)<\/'.$mark.'>/',$str,$match);
		return $match[1];
	}
?>