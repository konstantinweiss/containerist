<?

/**
 * checks if a container exists
 *
 * @param string $id
 * @return boolean
 */

// set stack id
$id = ($id) ? $id : $_GET['id'];

// this can get more elegant
if (!$id) {
	print 'error: no id set';
	die;
}

$filepath = $hub->containers[$id];
$result = ($filepath) ? '1' : '0';
print $result;
