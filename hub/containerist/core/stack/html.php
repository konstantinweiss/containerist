<?

// outputs the container structure

$id = $id ? $id : $_GET['id'];
$skinning_local = $skinning_local ? $skinning_local : $_GET['skinning_local'];
$skinning_local = $skinning_local ? $skinning_local : $node->skinning_local;

if (!$id) {
	print 'error: no stack ID provided';
	die;
}


if (!$hub->stacks[$id]) {
	print 'no stack yet.';
} else {
	$source          = mod ('stack', $id);
	$stack           = new CTN_single ($source);
  $stack->tplbase  = $node->skin.'/';
  $stack->webbase  = DOMAIN.$node->skin.'/';
  $stack->skinbase = DOMAIN.$node->skin.'/';

	$stack->site     = $stack->site.$id.'/';
  if ($admin) {
    $stack->admin  = $node->stack_slug.'.edit';
  }

  // local skinning?
  if ($skinning_local) {
    unset ($stack->renderer);
    $stack->renderer_suffix = '.html';
    // print_r ($stack);
    // die;
  }

	header ("Content-Type: text/html;charset=utf-8");
	print $stack->skin();
}