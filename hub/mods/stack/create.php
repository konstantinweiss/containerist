<?

// creates a new, empty stack

// set stack id
$id = ($id) ? $id : $_GET['id'];

if (!$id) {
	print 'error: no id parameter set';
	die;
}

$filepath = $repo.'/stacks/'.$id.'.txt';
if (!is_file ($filepath)) {
	$content = "CTN: stack\n---\n";
	file_write ($filepath, $content);
	print '1';
} else {
	print 'error: this stack already exists.';
}
