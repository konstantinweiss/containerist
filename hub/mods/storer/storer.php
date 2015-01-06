<?

// SETTINGS -----------

$data->domain   = DOMAIN;
$data->skinner  = DOMAIN.'html/';
$data->skin     = DOMAIN.$node->skin.'/';
$data->storer   = 'storer';
$data->module_dir = $module_dir;

// VARS ---------------

$data->repo     = $repo;
$data->id       = ($id) ? $id : $_GET['id'];
$data->site     = $data->domain.$data->repo.'/';

// SOURCE -------------

$mod_exists = $hub->has_container_mod ($id);
if ($mod_exists) {
	$mod_path = new Path ($mod_exists);
	$module_name = $mod_path->second;
	$mod_name = extract_name ($id);
	$data->source = mod ('moc-data', $mod_name, $module_name);
	// $data->source = mod ('container', $data_name, true);
	$data->edit_origin = false;
	$data->update_id = $module_name;
	$data->module = $module_name;
	$data->preview_id = $mod_name;
} else {
	$data->source = mod ('container', $id, true);
	$data->edit_origin = true;
	$data->update_id = $data->id;
	$data->preview_id = $data->id;
}

// STACK --------------

if ($path->third) {
	$data->stack = '../'.$path->second;
}

// USAGE --------------

$usage = yaml_read (mod ('container-usage', $id));
$data->usage = $usage['items'];

// OUTPUT -------------

$template = file_get_contents ($module_dir.'storer.tpl.html');
$html = mustache ($template, $data);
header ("Content-Type: text/html;charset=utf-8");
print $html;
