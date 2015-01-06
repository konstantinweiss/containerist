<?

// renames a container. 
// makes sure, that the container's name is updated in all stacks.

// set old and new container name
$id = ($id) ? $id : $_GET['id'];
$to = ($to) ? $to : $_GET['to'];

if (!$id OR !$to) {
	print 'error: no id or/and to parameter set';
	die;
}

$idpath = $repo.'/ctn/'.$id.'.txt';
$topath = $repo.'/ctn/'.$to.'.txt';

if (!is_file ($idpath)) {
	print 'error: container not found.';
	die;
} else
if (is_file ($topath)) {
	print 'error: container with new id already exists.';
	die;
} 
else {
	// rename ($idpath, $topath);
	// print '1';
}

$source = mod ('containers');
$obj = new CTN_single (mod ('stacks'));
print_r ($obj->items);

foreach ($obj->items as $stack) {
	print mod ('container-in-stack', $id, $stack);
}

// print mod ('container-in-stack', 'artist', 'index');