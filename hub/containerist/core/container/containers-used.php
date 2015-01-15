<?

/**
 * List all used static containers of this repo. (used in stacks of same repo)
 *
 * @return sring CTN list
 */

$list = yaml_read (mod('stacks'));
$stacks = $list['items'];

$containers = array ();
foreach ($stacks as $stack_id) {
	$source = mod ('stack', $stack_id);
	// print $source;
	$stack = new CTN_single ($source);
	foreach ($stack->origins as $i=>$origin) {
		$origin = extract_name ($origin);
		$origin = str_replace ('.ctn', '', $origin);
		array_push ($containers, $origin);
	}
	unset ($stack);
}
// print_r ($containers);
$containers = array_unique($containers);
sort($containers);

$ctn->CTN = 'list';
$ctn->items = $containers;
print yaml_ctn ($ctn);