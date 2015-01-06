<?

/*
 *  lists all unused containers of this repo.
 */ 

$used   = yaml_read (mod ('containers-used'));
$inrepo = yaml_read (mod ('containers'));

$diff = array_diff($inrepo['items'], $used['items']);
$diff = array_values ($diff);
sort ($diff);

$ctn->CTN = 'list';
$ctn->items = $diff;
print yaml_ctn ($ctn);