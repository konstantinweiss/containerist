<?

// deletes a stack

// set stack id
$id = ($id) ? $id : $_GET['id'];
if (!$id) {
	print 'error: no id parameter set';
	die;
}

$filepath = $repo.'/stacks/'.$id.'.txt';
if (is_file ($filepath)) {
	unlink ($filepath);
	print '1';
} else {
	print 'error: this stack does not exist.';
}
