<?

/**
 * lists all stacks of this repo.
 *
 * @return string CTN list
 */

$ids = array ();
foreach ($hub->stacks as $key=>$value) {
  if (!is_hidden ($key)) {
    array_push($ids, $key);
  }
}
sort ($ids);

$ctn->CTN = 'list';
$ctn->items = $ids;
print yaml_ctn ($ctn);


// $files = scandir ($node->repo.'/stacks');
// foreach ($files as $i => $value) {
// 	$files[$i] = str_replace ('.txt', '', $value);
// 	if (!is_file ($node->repo.'/stacks/'.$value) OR begins_with ('.', $value) OR begins_with ('_', $value)) {
// 		unset ($files[$i]);
// 	}
// }

// $ctn->CTN = 'list';
// $ctn->items = array_values($files);
// print yaml_ctn ($ctn);