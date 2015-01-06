<?

// list all stacks of this repo.

$files = scandir ($node->repo.'/stacks');
foreach ($files as $i => $value) {
	$files[$i] = str_replace ('.txt', '', $value);
	if (!is_file ($node->repo.'/stacks/'.$value) OR begins_with ('.', $value) OR begins_with ('_', $value)) {
		unset ($files[$i]);
	}
}

$ctn->CTN = 'list';
$ctn->items = array_values($files);
print yaml_ctn ($ctn);