<?

// list all used containers of this repo.

$files = scandir ($node->repo.'/stacks');
foreach ($files as $i => $value) {
	if (!is_file ($repo.'/stacks/'.$value) OR begins_with ('.', $value)) {
		unset ($files[$i]);
	}
}
$files = array_values($files);

$containers = array ();
foreach ($files as $file) {
	$name = extract_name ($file);
	$source = mod ('stack', $name);
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