<?

/*
 * Lists all unused containers of this repo.
 * The list takes into account only containers from 'static' context.
 *
 * @return string CTN list
 */ 

// get the needed lists
$used   = yaml_read (mod ('containers-used'));
$inrepo = yaml_read (mod ('containers'));

// make sure that only containers from 'static' are taken into account
foreach ($inrepo['items'] as $key=>$value) {
  if (get_context ($value) != 'static') unset ($inrepo['items'][$key]);
}
$inrepo['items'] = array_unique($inrepo['items']);

// calculate the difference
$diff = array_diff($inrepo['items'], $used['items']);
$diff = array_values ($diff);
sort ($diff);

// render the list
$ctn->CTN = 'list';
$ctn->items = $diff;
print yaml_ctn ($ctn);

function get_context ($id) {
  GLOBAL $hub;
  $path = new Path ($hub->containers[$id]);
  $context = $path->parts[$path->count-2];
  return $context;
}