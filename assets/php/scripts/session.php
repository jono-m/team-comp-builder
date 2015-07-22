<?php
include_once '../common.php';
include_once '../objects/db.php';
include_once '../objects/session_object.php';

$method = urlvar("method");

$db = new DB();
$db->connect();
switch($method) {
    case "retrieveall":
        $session_ids = $db->get_session_ids();
        $sessions = array();
        foreach($session_ids as $session_id) {
            $sessions[] = new Session($session_id);
        }
        echo json_encode($sessions);
        break;
    case "retrieve":
        $session_id = urlvar("session_id");
        echo json_encode(new Session($session_id));
        break;
    case "new":
        $session_name = urlvar("session_name");
        $session_id = $db->create_session($session_name);
        echo json_encode($session_id);
        break;
    case "end":
        $session_id = urlvar("session_id");
        $db->end_session($session_id);
        break;
    case "rename":
        $session_id = urlvar("session_id");
        $session_name = urlvar("session_name");
        $db->set_session_name($session_id, $session_name);
        break;
    case "setcompid":
        $session_id = urlvar("session_id");
        $role = urlvar("role");
        $comp_id = urlvar("comp_id");
        $comp_type_number = urlvar("comp_type_number");
        $db->set_session_comp_type_id($session_id, $role, $comp_id, $comp_type_number);
        break;
    case "setpickedchampid":
        $session_id = urlvar("session_id");
        $role = urlvar("role");
        $champ_id = urlvar("champ_id");
        $db->set_session_picked_champion_id($session_id, $role, $champ_id);
        break;
    case "setpickedplayerid":
        $session_id = urlvar("session_id");
        $role = urlvar("role");
        $player_id = urlvar("player_id");
        $db->set_session_picked_player_id($session_id, $role, $player_id);
        break;
    case "setstarterid":
        $session_id = urlvar("session_id");
        $role = urlvar("role");
        $starter_id = urlvar("starter_id");
        $starter_number = urlvar("starter_number");
        $db->set_session_starter_id($session_id, $role, $starter_id, $starter_number);
        break;
    case "setenemychampid":
        $session_id = urlvar("session_id");
        $enemy_champion_id = urlvar("enemy_champion_id");
        $champion_number = urlvar("champion_number");
        $db->set_session_enemy_champion_id($session_id, $enemy_champion_id, $champion_number);
        break;
    case "setbanid":
        $session_id = urlvar("session_id");
        $ban_champ_id = urlvar("ban_champ_id");
        $teamban = urlvar("teamban");
        $ban_number = urlvar("ban_number");
        $db->set_session_ban_id($session_id, $ban_champ_id, $teamban, $ban_number);
        break;
}
$db->disconnect();
?>
