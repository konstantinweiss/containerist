<?

// renames a container. 
// makes sure, that the container's name is updated in all stacks.

// set old and new container name
$id = ($id) ? $id : $_GET['id'];
$to = ($to) ? $to : $_GET['to'];
$to = ($to) ? $to : $param2;

$context = $context ? $context : $_GET['context'];
$context = $context ? $context : $param3;
$context = $context ? $context : 'ctn';

if (!$id OR !$to) {
	print 'error: no id or/and to parameter set';
	die;
}

$idpath = $repo.'/'.$context.'/'.$id.'.txt';
$topath = $repo.'/'.$context.'/'.$to.'.txt';

if (!is_file ($idpath)) {
	print 'error: container not found.';
	die;
} else
if (is_file ($topath)) {
	print 'error: container with new id already exists.';
	die;
} 
else {
	rename_container ($id, $to, $context);
	$source = mod ('stacks');
	$obj = new CTN_single (mod ('stacks'));
	foreach ($obj->items as $stack) {
		rename_container_in_stack ($id, $to, $stack);
	}
	print '1';
}

function rename_container_in_stack ($cid_from, $cid_to, $sid) {
	$source = mod ('stack', $sid);
	$source = str_replace ("\n".$cid_from.".ctn", "\n".$cid_to.".ctn", $source);
	mod ('stack-update', $sid, $source);
}

function rename_container ($from, $to, $context) {
	$source = mod ('container', $from, $context);
	mod ('container-create', $to, $context);
	mod ('container-update', $to, $source, $context);
	mod ('container-delete', $from);
}