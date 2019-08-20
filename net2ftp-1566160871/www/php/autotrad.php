<?php
	error_reporting(E_ALL);
	set_time_limit(240);
	$ctx = stream_context_create(array(
	    'http' => array(
		'timeout' => 1,
		'user_agent'=>'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:34.0) Gecko/20100101 Firefox/34.0' // To not be kick from the google trad API
		)
	    )
	);

	function trad_file($mot,$sl,$tl) // To Translate the <lex> into a file
	{
		global $ctx;
		$ret = file_get_contents('https://translate.googleapis.com/translate_a/single?client=gtx&sl='.$sl.'&tl='.$tl.'&dt=t&q='.urlencode($mot),0, $ctx);
		return utf8_decode(json_decode($ret)[0][0][0]);
	}
?>
