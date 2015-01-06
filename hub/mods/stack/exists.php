<?

// outputs the container structure

$id = $id ? $id : $_GET['id'];

if (!$id) {
	print 'error: no stack ID provided';
	die;
}

$filepath = $repo.'/stacks/'.$id.'.txt';
if (!is_file ($filepath)) {
	print '0';
} else {
	print '1';
}