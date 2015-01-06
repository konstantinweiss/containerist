<?

$id     = $id ? $id : $_GET['id'];
$source = $source ? $source : $_GET['source'];
$source = $source ? $source : $param2;

if (!$id) {
  print "no ID provided";
  die;
}
if (!$source) {
  print "no Container Source provided";
  die;
}

$modpath = mod ('moc-exists', $id);
if ($modpath) {
	mod ('moc-dataupdate', $mod->id, $source);
	print '1';
} else {
	if (!mod ('container-exists', $id)) {
	  mod ('container-create', $id);
	}
	mod ('container-update', $id, $source, $module);
	print '1';
}
