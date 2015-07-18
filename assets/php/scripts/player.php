<?php
include_once '../common.php';
include_once '../objects/db.php';
include_once '../objects/player_object.php';

$method = urlvar("method");

$db = new DB();
$db->connect();
switch($method) {
    case "retrieveall":
        $player_ids = $db->get_player_ids();
        $players = array();
        foreach($player_ids as $player_id) {
            $players[] = new Player($player_id);
        }
        echo json_encode($players);
        break;
    case "retrieve":
        $player_id = urlvar("player_id");
        echo json_encode(new Player($player_id));
        break;
    case "new":
        $player_name = urlvar("player_name");
        $db->add_player($player_name);
        break;
    case "rename":
        $player_id = urlvar("player_id");
        $player_name = urlvar("player_name");
        $db->change_player_name($player_id, $player_name);
        break;
    case "delete":
        $player_id = urlvar("player_id");
        $db->remove_player($player_id);
        break;
    case "addchamp":
        $player_id = urlvar("player_id");
        $champ_id = urlvar("champ_id");
        $role = urlvar("role");
        $db->add_player_champion($player_id, $role, $champ_id);
        break;
    case "removechamp":
        $player_id = urlvar("player_id");
        $champ_id = urlvar("champ_id");
        $role = urlvar("role");
        $db->remove_player_champion($player_id, $role, $champ_id);
        break;
}
$db->disconnect();
?>
