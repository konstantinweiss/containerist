<?

/**
 * checks if a container is in a stack
 *
 * @param string $ctn    ID of the container
 * @param string $stack  ID of the stack
 * @return boolean
 */

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

if ($hub->stacks[$stack]) {
	$source = mod ('stack', $stack);
	$stack = new CTN_single ($source);
	$ctnname = str_replace ('.ctn', '', $ctn) . '.ctn'; // sanetize
	if (in_array ($ctnname, $stack->origins)) {
		print '1';
	} else {
		print '0';
	}
} else {
	print 'error: this stack does not exist.';
}
