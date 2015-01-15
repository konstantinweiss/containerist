<?

/**
 * renames a stack
 *
 * @param string $id of the stack to be renamed
 * @param string $to New stack ID
 * @return boolean
 */

// set old stack name
$id = ($id) ? $id : $_GET['id'];
$to = ($to) ? $to : $_GET['to'];

if (!$id OR !$to) {
	print 'error: no $id or $to parameter set';
	die;
}

$idpath = $node->repo.'/'.STACKS_DIR.$id.'.txt';
$topath = $node->repo.'/'.STACKS_DIR.$to.'.txt';

if (!is_file ($idpath)) {
	print 'error: stack not found.';
	die;
} else
if (is_file ($topath)) {
	print 'error: stack with new name already exists.';
	die;
} 
else {
	rename ($idpath, $topath);
  $hub->register_stacks ();
	print '1';
}
