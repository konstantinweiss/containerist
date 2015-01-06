<?

// deletes a stack

// set stack id
$id = ($id) ? $id : $_GET['id'];
if (!$id) {
	print 'error: no id set';
	die;
}

$context = $context ? $context : $_GET['context'];
$context = $context ? $context : $param2;
$context = $context ? $context : 'ctn';

$filepath = $node->repo.'/'.$context.'/'.$id.'.txt';
if (is_file ($filepath)) {
	unlink ($filepath);
	print '1';
} else {
	print 'error: this container does not exist.';
}
