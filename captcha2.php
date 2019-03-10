<?php

$digit1 = mt_rand(1,20);
$digit2 = mt_rand(1,20);
if( mt_rand(0,1) === 1 ) {
	$math = "$digit1 + $digit2";
	$_SESSION['answer'] = $digit1 + $digit2;
} elseif ($digit1 < $digit2) {
	$math = "$digit2 - $digit1";
	$_SESSION['answer'] = $digit2 - $digit1;
}
else {
	$math = "$digit1 - $digit2";
	$_SESSION['answer'] = $digit1 - $digit2;
}

?>