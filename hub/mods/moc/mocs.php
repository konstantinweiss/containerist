<?

// list all available mods for this repo.

$ctn->CTN = 'list';
$ctn->items = $hub->container_mods;

print yaml_ctn ($ctn);