<?

// outputs the container structure

$id = $id ? $id : $_GET['id'];

if (!$id) {
  print 'error: no stack ID provided';
  die;
}

if (!mod ('stack-exists', $id)) {
  print 'this stack does not exist yet';
} else {
  $source = mod ('stack', $id);
  $stack  = new CTN_single ($source);
  $stack->tplbase  = $node->skin.'/';
  $stack->webbase  = DOMAIN.$node->skin.'/';
  $stack->skinbase = DOMAIN.$node->skin.'/';
  $stack->source   = $source;

  // render the payload
  $stack->payload_html = mod ('skinner-payload', $id);
  // unset the origins
  unset ($stack->origins);

  if ($admin) {
    $stack->admin = $node->stack_last.'.edit';
  }

  header ("Content-Type: text/html;charset=utf-8");
  print $stack->skin(); 
}

