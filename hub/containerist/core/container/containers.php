<?

/**
 * Lists all containers in this repo, in 'static' context per default
 *
 * @param string $context (optional) the context / directory of which containers should be listed
 * @return sring CTN list
 */

// set context
$context = $id ? $id : $_GET['context'];
$context = $context ? $context : 'static';

// get list of containers
if ($context == 'static') {
  $list = $hub->static_containers;
} else {
  $list = $hub->get_containers_by_context ($context);
}

// set keys to values, ignore hidden (staring with '_')
$container_ids = array ();
foreach ($list as $key=>$value) {
  if (!is_hidden ($key)) {
    array_push($container_ids, $key);
  }
}
sort ($container_ids);

// display list
$ctn->CTN = 'list';
$ctn->items = $container_ids;
print yaml_ctn ($ctn);
