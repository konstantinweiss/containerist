<?php 
header ("Content-Type: text/plain;charset=utf-8");

// SETTINGS -----------

$data->domain   = DOMAIN;
$data->renderer = DOMAIN.'html/';
$data->storer   = 'storer';

// VARS ---------------

$data->repo     = $repo;
// $data->id       = ($id) ? $id : $_GET['id'];
$data->id       = $node->stack_id;
$data->slug     = $node->stack_slug;
$data->site     = $data->domain.$data->repo.'/'.$data->slug.'/';
$data->stack    = $data->id;

// SKIN ---------------

$data->skindir = is_dir($node->repo.'/skin') ? $node->repo.'/skin/' : 'skins/squareone/';
$data->skin    = DOMAIN.$data->skindir;


// LOCAL SKINNING? ----

if ($node->skinning_local) {
  unset ($data->renderer);
  $data->renderer_suffix = ".html";
}


// STACK CONTAINERS ---

$stack = mod ('stack', $data->id);
$ctn = new CTN_single ($stack);

$data->containers = array ();
foreach ($ctn->origins as $i=>$item) {
  // if this is a remote container
  if (in_str ('http://', $item)) {
    $c->remote_container = true;
    $c->origin           = $item;
    $c->edit_url         = $item;
    $c->id_with_params   = $item;
  // if this is a local container
  } else {
    $c->origin         = $data->site.$item;
    $c->id_with_params = $item;
    $c->id             = extract_name ($item);
    $c->edit_url       = '/'.$repo.'/'.$data->slug.'/'.$c->id.'.ctn.edit';
    $c->container_html = mod ('skinner-local', extract_name ($item));
  }
  array_push($data->containers, $c);
  unset ($c);
}

// OUTPUT -------------

$template = file_get_contents ($module_dir.'view.tpl.html');
$html = mustache ($template, $data);
header ("Content-Type: text/html;charset=utf-8");
print $html;
