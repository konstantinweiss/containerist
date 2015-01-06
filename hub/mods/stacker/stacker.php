<?

// SETTINGS ---------------------------

$data->domain   = DOMAIN;
$data->renderer = DOMAIN.'html/';
$data->storer   = 'storer';
$data->editable = 1;
$data->admin    = 1;
$data->module_dir = $module_dir;

// VARS -------------------------------

$data->repo     = $repo;
$data->id       = $node->stack_id;
$data->slug     = $node->stack_slug;
$data->site     = $data->domain.$data->repo.'/';

// SKIN -------------------------------

$data->skindir  = is_dir($node->repo.'/skin') ? $node->repo.'/skin/' : 'skins/squareone/';
$data->skin     = DOMAIN.$data->skindir;
$data->webbase  = $data->skin;

// REPO CONTAINERS --------------------

$list = mod ('containers');
$ctn = new CTN_single ($list);
$data->repo_containers = $ctn->items;

// MOD CONTAINERS ---------------------

$list = mod ('mocs');
$ctn = new CTN_single ($list);
$mod_containers = array ();
$duplicate = false;
foreach ($ctn->items as $key=>$item) {
  if ($duplicate) {
    $duplicate = false;
    continue;
  }
  array_push($mod_containers, $key);
  $duplicate = true;
}
// print_r ($mod_containers);
// die;
$data->mod_containers = $mod_containers;

// STACK CONTAINERS -------------------

$stack = mod ('stack', $data->id);
$ctn = new CTN_single ($stack);
foreach ($ctn->origins as $i=>$item) {
  if (in_str ('?', $item)) {
    $parts = explode ('?', $item);
    $parts[0] = extract_name ($parts[0]);
    $ctn->origins[$i] = implode ('?', $parts);
  } else {
    $ctn->origins[$i] = extract_name ($item);
  }
}
$data->containers = $ctn->origins;
$data->source = $ctn->structure();
$data->stylesheet = $data->skin.'stack.css';

// PREVIEW HTML -----------------------

$data->payload_html = mod ('stacker-view', $data->id);

// SET EDIT MODE ON -------------------

mod ('editmode-start');

// ADMIN HTML -------------------------

$admin_template = file_get_contents ($module_dir.'stacker.tpl.html');
$data->admin_html = mustache ($admin_template, $data);

// OUTPUT -----------------------------

// set template
$template = file_get_contents ($data->skindir.'stack.html');

$html = mustache ($template, $data);
header ("Content-Type: text/html;charset=utf-8");
print $html;

