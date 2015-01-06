<?php

$id = ($id) ? $id : $_GET['id'];

$entry['containers'] = $_GET['containers'];
foreach ($entry['containers'] as $i=>$item) {
	$entry['containers'][$i] = $item.'.ctn';
}

$stack = new CTN_single ();
$stack->CTN = 'stack';
$stack->origins = $entry['containers'];

$source = $stack->structure();

if (!mod ('stack-exists', $id)) {
  mod ('stack-create', $id);
}

mod ('stack-update', $id, $source);

print_r ($stack->structure());

