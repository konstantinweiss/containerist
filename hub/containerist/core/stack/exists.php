<?

/**
 * checks if a stack exists
 *
 * @param boolean $id
 * @return boolean
 */

$id = $id ? $id : $_GET['id'];

if (!$id) {
	print 'error: no stack ID provided';
	die;
}

$filepath = $hub->stacks[$id];
$result = ($filepath) ? '1' : '0';
print $result;
