<?

// checks if container is in a stack

// set stack id
$ctn = ($ctn) ? $ctn : $_GET['ctn'];
$stack = ($stack) ? $stack : $_GET['stack'];

if (!$ctn) $ctn = $id;
if (!$stack) $stack = $param2;

if (!$ctn) {
	print 'error: no ctn defined';
	die;
}
if (!$stack) {
	print 'error: no stack defined';
	die;
}


$filepath = $repo.'/'.$stack.'.txt';
if (is_file ($filepath)) {
	$source = file_get_contents ($filepath);
	$stack = new CTN_single ($source);
	$ctnname = str_replace ('.ctn', '', $ctn) . '.ctn';
	if (in_array ($ctnname, $stack->origins)) {
		print '1';
	} else {
		print '0';
	}
} else {
	print 'error: this stack does not exist.';
}
