<?php
if(false){ ?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251"><?php }

define("defFile","log.er");

function AddError($cod,$source,$text){
	$f=fopen(defFile,"a");
	flock ($f, LOCK_EX);
	fputs ($f, getdate().$cod.';'.$source.';'.$text.'
');
	flock ($f, LOCK_UN);
	fclose($f);
}

?>