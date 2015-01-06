<?
header ("Access-Control-Allow-Origin: *");
header ("Content-Type: text/plain;charset=utf-8");
error_reporting(E_ERROR | E_PARSE);

include_once ('config.php');

// PATH ------------------------------------------

GLOBAL $q;
$q = $_GET['q'];
GLOBAL $path;
$path = new Path ($_GET['q']);
GLOBAL $repo;
$repo = $path->first;
if (!$path->second) {
  $path = new Path ($repo.'/index');
}



// HUB -------------------------------------------

GLOBAL $hub;
$hub = new Containerist_Hub ();



// NODE ------------------------------------------

GLOBAL $node;
$node = new Containerist_Node ($_GET['q']);
if (!$node->second) {
  $node = new Containerist_Node ($node->first.'/index');
}



// LOCAL SKINNING OF CONTAINERS? -----------------

$node->skinning_local = SKINNING_LOCAL;



// ADMIN? ----------------------------------------

// switch on admin per default for now.
GLOBAL $admin;
$admin = true;
$node->admin = true;



// EDITABLE? -------------------------------------

GLOBAL $editable;
$node->editable = false;
$editable = false;
if ($_GET['edit'] == 'stop') {
  mod ('editmode-stop');
} elseif (mod ('editmode')) {
  $editable = true;
  $node->editable = true;
}



// ROUTER ----------------------------------------

if ($path->first == 'html') {
  $origin = substr ($path->full, 5);
  print mod ('skinner', $origin);
} 

else if ($node->is_image) {
  mod ('image');
}

else if ($path->suffix == 'html') {
  $name = extract_name ($path->last);
  if (ends_with ('.ctn', $name)) { 
    $id = extract_name ($name);
    print mod ('skinner-local', $id);
  }
}

else if ($path->suffix == 'mod') {
  print mod ($path->name);
} 

else if ($path->suffix == 'ctn') {
  print mod ('node', $path->name);
}

else if ($path->suffix == 'stack') {
  print mod ('stack', $path->name);
}

else if ($path->suffix == 'edit' OR $editable) {
  $name = extract_name ($path->last);
  if (ends_with ('.ctn', $name)) { 
    // edit a container
    print mod ('storer', $path->name);
  } else { 
    // edit a stack
    print mod ('stacker', $path->name);
  }
}

else {
  $stack_id = false;
  if ($node->skinning_local) {
    print mod ('skinner-stack', $node->stack_id);
  } else {
    print mod ('stack-html', $node->stack_id, $node->skinning_local);
  }
}



// MOD FUNCTIONS ---------------------------------

function mod ($name, $id = false, $param2 = false, $param3 = false) {
  GLOBAL $path;
  GLOBAL $repo;
  GLOBAL $admin;
  GLOBAL $editable;
  GLOBAL $node;
  GLOBAL $hub;
  $modpath = find_mod ($name);
  if ($modpath) {
    // $mod_name = extract_name ($name);
    // find module name and mod name
    $mod_name = $name;
    $path_ = new Path ($modpath);
    $module_name = $path_->second;
    $module_dir = "$path_->first/$module_name/";
    ob_start(); // begin collecting output
    include ($modpath);
    $source = ob_get_clean(); // end collecting output
    return $source;
  } else {
    print 'Mod not found. mod-name: '.$name;
  }
}

function find_mod ($name) {
  GLOBAL $repo;
  GLOBAL $node;
  GLOBAL $hub;
  $result = false;
  $result = $hub->has_mod ($name);
  return $result;
}



class Containerist_Node {

  function Containerist_Node ($q) {
    $this->q = $q;

    $this->parts = explode ('/', $this->q);
    $this->count = count($this->parts);
    if (!$this->parts[$this->count-1]) {
      $this->end_with_slash = true;
      unset ($this->parts[$this->count-1]);
      $this->count = count($this->parts);
      $this->q_without_slash = implode ('/', $this->parts);
      $this->is_page = true;
    }
    $this->last = $this->parts[$this->count-1];

    $this->set_parts ();
    $this->set_repo ();
    $this->is_image ();
    $this->set_type ();
    $this->find_stack ();
    $this->set_skin ();
  }
  function set_parts () {
    if ($this->parts[0]) $this->first = $this->parts[0];
    if ($this->parts[1]) $this->second = $this->parts[1];
    if ($this->parts[2]) $this->third = $this->parts[2];
    if ($this->parts[3]) $this->fourth = $this->parts[3];
  }

  function is_image () {
    if (ends_with ('.png',  $this->last)) $this->is_image = true;
    if (ends_with ('.gif',  $this->last)) $this->is_image = true;
    if (ends_with ('.svg',  $this->last)) $this->is_image = true;
    if (ends_with ('.jpg',  $this->last)) $this->is_image = true;
    if (ends_with ('.jpeg', $this->last)) $this->is_image = true;
  }

  function set_repo () {
    $this->repo = $this->first;
  }

  function set_type () {
    $parts_ = $this->parts;
    if (ends_with ('.ctn', $this->last)) {
      $this->is_ctn = true;
    } else if (ends_with ('.ctn.edit', $this->last)) {
      $this->is_ctn = true;
      $this->editable = true;
    } else if (ends_with ('.stack', $this->last)) {
      $this->is_stack = true;
    } else if (ends_with ('.edit', $this->last)) {
      $this->is_stack = true;
      $this->editable = true;
      $this->last = substr ($this->last, 0, -5);
      $this->parts[$this->count-1] = $this->last;
    } else if (ends_with ('.mod', $this->last)) {
      $this->is_mod = true;
    } else {
      // $this->is_page = true;
      $this->is_stack = true;
    }
  }

  function find_stack () {
    $this->stack_id = false;
    $parts = $this->parts;
    array_shift ($parts);
    if (!$this->is_stack) {
      array_pop ($parts);
    }
    $this->stack_parts = $parts;
    $this->stack_slug  = implode ('/', $parts);
    $parts_ = $parts;

    $parts_count = count ($parts)-1;
    if ($parts_count > 0) {
      $stack_id = implode ('--', $parts);
      $this->_set_stack_id($stack_id);
      // print $stack_id."\n";
      for ($i = $parts_count; $i > 0; $i--) {
        $parts[$i] = '*';
        $stack_id = implode ('--', $parts);
        // print $stack_id."\n";
        $this->_set_stack_id($stack_id);

        // unset ($parts[$i]);
        // $stack_id = implode ('--', $parts);
        // // print $stack_id."\n";
        // $this->_set_stack_id($stack_id);
      }
    } else {
      $this->stack_id = $this->second;
      $this->stack_path = $this->stack_id;
    }
  }
  function _set_stack_id ($id_) {
    if (!$this->stack_id) {
      // print $id_."\n";
      if (mod ('stack-exists', $id_)) {
        $this->stack_id = $id_;
      }
    }
  }

  function set_skin () {
    $repo_skin = $this->repo.'/skin';
    if (is_dir ($repo_skin)) {
      $this->skin = $repo_skin;
    } else {
      $this->skin = 'skins/'.SKIN;
    }
  }

}




class Containerist_Hub {
  function Containerist_Hub () {
    $this->set_repo ();
    $this->register_mods ();
  }

  function set_repo () {
    GLOBAL $q;
    $path = new Path ($q);
    $this->repo = ($path->first == 'html') ? false : $path->first;
  }

  function register_mods () {
    $this->mods = array ();
    $this->container_mods = array ();

    // register repository mods
    if ($this->repo) {
      $this->_register_mods_by_base ($this->repo);
    }

    // register global mods
    $this->_register_mods_by_base ('mods');
  }

  function _register_mods_by_base ($base) {
    $dir = directory_to_array_recursive ($base);
    foreach ($dir as $key=>$filepath) {
      if (ends_with('.php', $filepath)) {
        $path = new Path ($filepath);
        // 
        // option 1: moduleName-modName.mod
        // 
        $name = $path->second.'-'.$path->third;
        $name = substr ($name, 0, -4); // delete '.php' from name
        // if this is a container mod
        if (ends_with ('.ctn', $name)) {
          $name = substr ($name, 0, -4); // delete '.ctn' from name
          $this->container_mods[$name] = $filepath;
        }
        // add this mod
        $this->mods[$name] = $filepath;
        // 
        // option 2: modName.mod (without moduleName)
        // 
        $name = $path->third;
        $name = substr ($name, 0, -4); // delete '.php' from name
        // if this is a container mod
        if (ends_with ('.ctn', $name)) {
          $name = substr ($name, 0, -4); // delete '.ctn' from name
          $this->container_mods[$name] = $filepath;
        }
        // add this mod
        $this->mods[$name] = $filepath;
      }
    }
  }

  function has_mod ($name) {
    $result = false;
    foreach ($this->mods as $mod_name=>$mod_path) {
      if ($name == $mod_name) {
        $result = $mod_path;
      }
    }
    return $result;
  }

  function has_container_mod ($name) {
    $result = false;
    foreach ($this->container_mods as $cmod_name=>$cmod_path) {
      if ($name == $cmod_name) {
        $result = $cmod_path;
      }
    }
    return $result;
  }

}