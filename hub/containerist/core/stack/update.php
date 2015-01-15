<?

/**
 * updates the source of a stack
 *
 * @param string   $id      ID of the stack to be updated
 * @param string   $source  The new source
 * @return boolean          Success
 */

// set stack id
$id = ($id) ? $id : $_GET['id'];
if ($param2) $source = $param2;
$source = ($source) ? $source : $_GET['source'];

if (!$id) {
	print 'error: no id given';
	die;
}
if (!$source) {
  print 'error: no source given';
  die;
}

$filepath = $hub->stacks[$id];
if (!$filepath) {
  print 'error: no stack with this id found.';
  die;
}

$source = str_replace ('.ctn', '', $source);
$stack = new CTN_single ($source);
unset ($stack->site);
unset ($stack->renderer);
print $stack->structure();
file_write ($filepath, $stack->structure());
$hub->register_stacks();
print '1';