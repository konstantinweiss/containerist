<?

// creates a new, empty stack

// set stack id
$id = ($id) ? $id : $_GET['id'];

// set module, if there is any
$context = $context ? $context : $param2;
$context = $context ? $context : 'ctn';

// this can get more elegant
if (!$id) {
	print 'error: no id set';
	die;
}

$filepath = $repo.'/'.$context.'/'.$id.'.txt';
if (is_file ($filepath)) {
	print '1';
} else {
	print '0';
}
