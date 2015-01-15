<?php

$stack_id = $id ? $id : $_GET['id'];

if (!$stack_id) {
  print "mod: skinner-payload\nAborted. No Stack ID provided.";
  die;
}

$source = mod ('stack', $id);
$stack = new CTN_single ($source);

$html = '';

foreach ($stack->origins as $origin) {
	$nid = extract_name ($origin);
	// print "$nid\n";
	print mod ('skinner-container', $nid);
	// print "\n\n\n";
}
