<?

$mod = $id ? $id : $_GET['mod'];

$module = $module ? $module : $_GET['module'];
$module = $module ? $module : $param2;

if (find_mod ($mod.'-data')) {
	$data = mod ($module.'-'.$mod.'-data');
} else {
	$data = mod ('container', $mod, 'raw', $module);
	if ($data == 'empty.') {
		$data = mod ('container', $module, 'raw', $module);
	}
}
print $data;


/*

repo/module-name/mod-name.data.txt
repo/module-name/module-name.data.txt

*/