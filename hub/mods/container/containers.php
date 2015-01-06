<?

// list all containers of this repo.

$context = $id ? $id : $_GET['context'];
$context = $context ? $context : 'ctn';

$files = directory_to_array ($repo.'/'.$context);
foreach ($files as $i => $value) {
	if (!is_file ($repo.'/'.$context.'/'.$value) OR is_hidden ($value)) {
		unset ($files[$i]);
	} else {
		$files[$i] = str_replace ('.txt', '', $value);
	}
}
sort ($files);

$ctn->CTN = 'list';
$ctn->items = $files;

print yaml_ctn ($ctn);