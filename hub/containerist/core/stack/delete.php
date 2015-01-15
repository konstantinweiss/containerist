<?

/**
 * deletes a stack. this cannot be undone.
 *
 * @param boolean $id ID of the stack to be deleted
 * @return true or error
 */

// set stack id
$id = ($id) ? $id : $_GET['id'];
if (!$id) {
	print 'error: no id parameter set';
	die;
}

$filepath = $node->repo.'/'.STACKS_DIR.$id.'.txt';
if (is_file ($filepath)) {
	unlink ($filepath);
  $hub->register_stacks();
	print '1';
} else {
	print 'error: this stack does not exist.';
}
