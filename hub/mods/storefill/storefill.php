<?

$id = $id ? $id : $_GET['id'];
$type = $type ? $type : $_GET['type'];
$type = $type ? $type : $param2;
$stack = $stack ? $stack : $_GET['stack'];
$stack = $stack ? $stack : $path->second;

$source = file_get_contents($module_dir.'templates/'.$type.'.txt');

mod ('container-create', $id, $source);

$redirect = DOMAIN.$repo.'/'.$stack;
header("Location: ".$redirect);