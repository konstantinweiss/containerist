<?

/**
 * creates a new, empty stack
 *
 * @param boolean $id
 * @return boolean
 */

// set stack id
$id = ($id) ? $id : $_GET['id'];

if (!$id) {
	print 'error: no id parameter set';
	die;
}

$filepath = $node->repo.'/'.STACKS_DIR.$id.'.txt';
if (!is_file ($filepath)) {
	$content = "CTN: stack\n---\n";
	file_write ($filepath, $content);
  $hub->register_stacks();
	print '1';
} else {
	print 'error: this stack already exists.';
}
