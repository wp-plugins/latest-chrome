<?php
function get_os($user_agent) {
	$oses = array (
		'win' => '(Win1)|(Win9)|(WinN)|(Windows )',
		'linux' => '(Linux)|(X11)|(OpenBSD)',
		'mac' => '(Mac_)|(Macintosh)'
	);
 
	foreach($oses as $os => $pattern) {
		if (eregi($pattern, $user_agent)) return $os;
	}
	return 'cf';
}
function vn2n($vn) {
	$s = explode('.',$vn);
	return (($s[0]*100+$s[1])*100+$s[2])*10000+$s[3];
}
function get_branch($vn) {
	$s = explode('.',$vn);
	return $s[2];
}
function osname($osid) {
	switch ($osid) {
		case 'mac': return 'Mac OS'; break;
		case 'win': return 'Windows'; break;
		default: return 'Linux'; break;
	}
}

$echo = '';
$lvs = explode("\n", file_get_contents('chromevdata.txt'));
$chromiumb = file_get_contents('chromiumbranch.txt') + 1;
foreach ($lvs as $lvl) {
	$tabs = explode(',',$lvl);
	$lv[$tabs[0]][$tabs[1]]['l'] = $tabs[2];
	$lv[$tabs[0]][$tabs[1]]['d'] = $tabs[4];
}

if ($_SERVER['HTTP_USER_AGENT']) {
	$ua = str_replace('Chromium','Chrome',$_SERVER['HTTP_USER_AGENT']);
	$uv = trim(substr(strstr($ua,'Chrome/'), 7, 
		strpos(strstr($ua,'Chrome/'), ' ') - 7));
	$echo .= 'Your Chrome version is: ';
	$echo .= (strstr($ua,'Chrome/')) ? $uv : 'Are you using Chrome?';
	$os = get_os($ua);
	$osname = osname($os);
	if (($chromiumb) && (get_branch($uv) == $chromiumb)) {
		$echo .= ' (Latest Chromium for <a href="#chromefor'.$os.'">' . $osname . '</a>)';
	}
	else if (($lv[$os]['canary']['l']) && (vn2n($uv) == vn2n($lv[$os]['canary']['l']))) {
		$echo .= ' (Latest Canary for <a href="#chromefor'.$os.'">' . $osname . '</a>)';
	}
	else if (vn2n($uv) == vn2n($lv[$os]['dev']['l'])) {
		$echo .= ' (Latest Dev for <a href="#chromefor'.$os.'">' . $osname . '</a>)';
	}
	else if (vn2n($uv) == vn2n($lv[$os]['beta']['l'])) {
		$echo .= ' (Latest Beta for <a href="#chromefor'.$os.'">' . $osname . '</a>)';
	}
	else if (vn2n($uv) == vn2n($lv[$os]['stable']['l'])) {
		$echo .= ' (Latest Stable for <a href="#chromefor'.$os.'">' . $osname . '</a>)';
	}
	else if (!(strstr($ua, 'Chrome/'))) {
		$echo .= ' (Please try Chrome!)';
	}
	else {
		$echo .= ' (Please update!)';
	}
}

header('content-type: text/javascript');
echo 'document.getElementById("chromefor'.$os.'").open = true;';
echo 'document.getElementById("currentchromeversion").innerHTML = \''.$echo.'\';';

?>
