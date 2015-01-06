<?

if (!$load_class) {
  $path_ = $id ? $id : $_GET['path'];
  $stackpath = new Containerist_Node ($path_);
  print $stackpath->stack_id;
  // print_r ($stackpath);
}

