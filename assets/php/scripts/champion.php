<?php

include_once '../common.php';
include_once '../objects/db.php';
include_once '../objects/champion_object.php';
include_once '../objects/player_object.php';

$method = urlvar("method");

$db = new DB();
$db->connect();
switch($method) {
    case "retrieveall":
        $champ_ids = $db->get_champ_ids();
        $champions = array();
        foreach($champ_ids as $champ_id) {
            $champions[] = new Champion($champ_id);
        }
        echo json_encode($champions);
        break;
    case "retrieve":
        $champ_id = urlvar("champ_id");
        $champion_player_ids = $db->get_champion_player_ids($champ_id);
        $champion_players = array(
            "Top Lane" => array(),
            "Jungle" => array(),
            "Mid Lane" => array(),
            "AD Carry" => array(),
            "Support" => array(),
        );
        foreach ($champion_player_ids as $role => $player_ids) {
            foreach($player_ids as $player_id) {
                $champion_players[$role][] = new Player($player_id);
            }
        }
        echo json_encode(array("champion" => new Champion($player_id),
                "players" => $champion_players));
        break;
    case "new":
        $champ_name = urlvar("champ_name");
        $db->add_champ($comp_type);
        break;
    case "updatestrength":
        $champ_id = urlvar("champ_id");
        $comp_id = urlvar("comp_id");
        $strength = urlvar("strength");
        $db->update_champions_comp_type_strength($champ_id, $comp_id, $strength);
        break;
}
$db->disconnect();
?>