<?
/**
 * renames a container. 
 * makes sure, that the container's name is updated in all stacks.
 *
 * @param string $id / the container to be renamed
 * @param string $to / the container's new ID
 * @return boolean
 */



// set old and new container name
$id = ($id) ? $id : $_GET['id'];
$to = ($to) ? $to : $_GET['to'];
$to = ($to) ? $to : $param2;

if (!$id OR !$to) {
	print 'error: no id or/and to parameter set';
	die;
}

// get the context (container's directory)
$idpath = $hub->containers[$id];
$_path = new Path ($idpath);
$context = $_path->parts[$_path->count-2]; // the second last part of the path

// check errors
if (!$hub->containers[$id]) {
	print 'error: container not found.';
	die;
} else
if ($hub->containers[$to]) {
	print 'error: container with new id already exists.';
	die;
} 
// rename
else {
	rename_container ($id, $to, $context);
	$obj = yaml_read (mod ('stacks'));
	foreach ($obj['items'] as $stack) {
		rename_container_in_stack ($id, $to, $stack);
	}
	$hub->register_containers ();
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
	mod ('container-update', $to, $source);
	mod ('container-delete', $from);
}