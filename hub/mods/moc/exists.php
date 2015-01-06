<?

// looks if there is a mod of this id. if yes, gives the path of the mod.

$id = $id ? $id : $_GET['id'];

if (!$id) {
	"mod-exists.mod\nerror: no ID provided.";
	die;
}

print $hub->has_container_mod ($id);
