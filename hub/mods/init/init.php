<?

header ("Content-Type: text/plain;charset=utf-8");

// print 'mark 1';
// mkdir ($node->repo);
mkdir ($node->repo.'/stacks');
mkdir ($node->repo.'/ctn');
$redirect = DOMAIN.$node->repo.'/index.edit';
header('Location: '.$redirect);

/*




// load all stacks.
$stacks = yaml_read (mod ('stacks'));

print 'compiler started.'."\n\n";

// create a directory for all compiled files
if (!is_dir ($compilation_dir)) {
  mkdir ($compilation_dir);
  print "created the compilation directory called: $compilation_dir\n";
}



// prepare section_types_collections
GLOBAL $section_types;
$section_types = array ();



// let's go through the stacks
foreach ($stacks['items'] as $stack_id) {
  collect_section_types ($stack_id);

  // if index, do an index.html into the root of compilation_dir
  if ($stack_id == 'index') {
    $html = mod ('skinner-stack', $stack_id);
    $filepath = $compilation_dir.'/index.html';
    $html = str_replace (DOMAIN.$node->skin, 'skin', $html);
    $html = str_replace ('src="', 'src="images/', $html);
    file_write ($filepath, $html);
  }

  // for all, including index, do pages into folders named as $stack_id.
  $html = mod ('skinner-stack', $stack_id);

  if (!is_dir ($compilation_dir.'/'.$stack_id)) {
    mkdir ($compilation_dir.'/'.$stack_id);
  }
  $filepath = $compilation_dir.'/'.$stack_id.'/index.html';

  // correct links to other pages
  $html = str_replace ('href="', 'href="../', $html);

  // search and replace - css, so that it works in /skin/* folder
  $html = str_replace (DOMAIN.$node->skin, '../skin', $html);

  // search and replace - adjust images to /images/* folder
  $html = str_replace ('src="', 'src="../images/', $html);

  file_write ($filepath, $html);
  print "compiled ".$filepath."\n";
}

print_r ($section_types);

collect_css ();


// collect all images
collect_images ();


// collect all stacks (and containers)
// as stack_id.stack
foreach ($stacks['items'] as $stack_id) {
  $stack_source = mod ('stack', $stack_id);
  $stack = new CTN_single ($stack_source);
  // unset ($stack->site);
  $stack->site = $stack_id.'/';
  unset ($stack->renderer);
  file_write ($compilation_dir.'/'.$stack_id.'.stack', $stack->structure());


  // collect all containers of that stack
  // as container_id.ctn
  foreach ($stack->origins as $file) {
    $c_id = extract_name ($file);
    $c_source = mod ('node', $c_id);
    file_write ($compilation_dir.'/'.$file, $c_source);
  }
}








function collect_images () {
  GLOBAL $node;
  GLOBAL $compilation_dir;
  $images_dir = $compilation_dir.'/images';
  if (!is_dir ($images_dir)) {
    mkdir ($images_dir);
  }
  $images = scandir ($node->repo.'/images');
  foreach ($images as $file) {
    if (is_image ($file)) {
      $from = $node->repo.'/images/'.$file;
      $to   = $images_dir.'/'.$file;
      copy ($from, $to);
    }
  }
}




function collect_section_types ($stack_id) {
  GLOBAL $node;
  GLOBAL $section_types;

  $stack_source = mod ('stack', $stack_id);
  $stack = new CTN_single($stack_source);
  foreach ($stack->origins as $container_name) {
    $node->stack_id = $stack_id;
    $container_source = mod ('node', str_replace ('.ctn', '', $container_name));
    $container = new CTN ($container_source);
    foreach ($container->sources as $section_source) {
      $section = new CTN_single ($section_source);
      $type = $section->CTN;
      if (!in_array ($type, $section_types)) {
        array_push ($section_types, $type);
      }
      unset ($section);
    }
    unset ($container);
  }
}



// prepare css
function collect_css () {
  GLOBAL $node;
  GLOBAL $compilation_dir;
  GLOBAL $section_types;

  if (!is_dir ($compilation_dir.'/skin')) {
    mkdir ($compilation_dir.'/skin');
  }

  array_push($section_types, 'stack');
  array_push($section_types, 'typography');
  array_push($section_types, 'grid');

  foreach ($section_types as $file) {
    $from = $node->skin.'/'.$file.'.css';
    $to   = $compilation_dir.'/skin/'.$file.'.css';
    copy ($from, $to);
  } 
}

*/