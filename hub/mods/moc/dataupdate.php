<?

$id = $id ? $id : $_GET['id'];

$data = $data ? $data : $_GET['data'];
$data = $data ? $data : $param2;


if (!$id) {
  print "no ID provided";
  die;
}
if (!$data) {
  print "no Container data provided\n";
  die;
}

$modpath = mod ('moc-exists', $id);
if (!$modpath) {
  print "This is not a mod.\n";
  die;
}

$modpath = new Path ($modpath);
$mod->module = $modpath->second;
$mod->id = $id;

$custom_update = $mod->module.'-'.$mod->id.'-data-update';
if ($hub->has_mod ($custom_update)) {
  mod ($custom_update, $id, $data);
} else {
  mod ('container-update', $mod->module, $data, $mod->module);
}








