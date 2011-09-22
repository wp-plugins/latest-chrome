<?php
error_reporting(0);

$f = file_get_contents('chromiumbranch.txt');
$branch = ($f > 880) ? $f : 880;
while ($branch) {
	if (!file_get_contents('http://src.chromium.org/svn/branches/'.(1 + $branch).'/')) {
		break;
	}
	else $branch++;
}
echo $branch;
if ($branch > 880) {
	$vdataf = fopen('chromiumbranch.txt', 'w');
	fwrite($vdataf, $branch);
	fclose($vdataf);
}