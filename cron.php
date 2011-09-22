<?php
function makelink($o, $b, $v) {
	$version = explode('.', $v);
	switch ($o) {
		case 'win':
			if ($b != 'canary') {
				return 'http://dl.google.com/chrome/install/' . $version[2] . '.'
					. $version[3] . '/chrome_installer.exe';
			} else {
				return 'http://tools.google.com/dlpage/chromesxs/eula.html';
			}
			break;
		case 'mac':
			if ($b != 'canary') {
				return 'http://dl.google.com/chrome/mac/'.$b.'/GoogleChrome.dmg'; break;
			} else {
				return 'http://tools.google.com/dlpage/chromesxs/eula.html';
			}
		case 'linux': return 'http://www.google.com/chrome/eula.html?platform=linux'; break;
		default: return ''; break;
	}
}
function osname($osid) {
	switch ($osid) {
		case 'mac': return 'Mac OS'; break;
		case 'win': return 'Windows'; break;
		default: return 'Linux'; break;
	}
}

$echo = '';

$vdata = file_get_contents('http://omahaproxy.appspot.com');
$vdataf = fopen('chromevdata.txt', 'w');
fwrite($vdataf, $vdata);
fclose($vdataf);

$lvs = explode("\n", $vdata);
foreach ($lvs as $lvl) {
	$tabs = explode(',', $lvl);
	$lv[$tabs[0]][$tabs[1]]['l'] = $tabs[2];
	$lv[$tabs[0]][$tabs[1]]['d'] = $tabs[4];
}


	$echo .= '<div id="latestchrome">';
	$os_id = $os;
	foreach ($lv as $osid => $oslv) {
		if (($osid == 'linux') OR ($osid == 'mac') OR ($osid == 'win')) {
			$echo .= '<details id="chromefor'.$osid.'"><summary>Downloads for <span class="osname">' . osname($osid) . '</span>: </summary>';
			$os_id = $osid;
			foreach ($oslv as $bn => $branch) {
				$echo .= '<ul>';
				$echo .= '<li class="chromebranch" id="' . $bn . '">' . $bn . ': ';
				$echo .= '<a title="' . $branch['l'] . ' released on ' . $branch['d'] . '" href="'. makelink($os_id, $bn, $branch['l']) .'">' . $branch['l'] . '</a>';
				$echo .= '</li></ul>';
			}
			$echo .= '</details>';
		}
	}
	$echo .= '</div>';
	$echo .= '<div id="currentchromeversion" />';

	$echo .= '<script type="text/javascript" src="/wp-content/plugins/latest-chrome/versioncheck.php"></script>';

$fp = fopen('chromeversioninline.html', 'w');
fwrite($fp, $echo);
fclose($fp);

echo 'Successfully written into <code>chromeversioninline.html</code>: ' . $echo;

echo '<br />Latest source branch: ';
require_once('chromiumbranch.php');
?>
