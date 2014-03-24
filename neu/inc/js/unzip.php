<?PHP

$tarName = 'firebug-lite.zip';

$shellBefehl = "unzip $tarName";

$shellBefehl = escapeshellcmd($shellBefehl);

exec($shellBefehl,$nu);

print_r($nu);

?>
