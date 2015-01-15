<?

/**
 * deletes a container
 *
 * @param boolean $id ID of the contianer to be deleted
 * @return true or error
 */

$id = ($id) ? $id : $_GET['id'];
if (!$id) {
	print 'error: no id set';
	die;
}

$filepath = $hub->containers[$id];
if ($filepath) {
	unlink ($filepath);
  $hub->register_containers();
	print '1';
} else {
	print 'error: this container does not exist.';
}
