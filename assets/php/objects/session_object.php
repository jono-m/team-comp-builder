<?php
include_once 'champion_object.php';
include_once 'player_object.php';
include_once 'comp_type_object.php';


class Session {
    function __construct($session_id) {
        $this->session_id = $session_id;
        $this->load_session();
    }
    function load_session() {
        global $db;
        $this->session_name = $db->get_session_name($this->session_id);

        $comp_type_ids = $db->get_session_comp_type_ids($this->session_id);
        $this->comp_types = array(
            "Top Lane" => array(),
            "Jungle" => array(),
            "Mid Lane" => array(),
            "AD Carry" => array(),
            "Support" => array(),
        );
        foreach ($comp_type_ids as $role => $ids) {
            foreach ($ids as $comp_type_id) {
                $this->comp_types[$role][] = new CompType($comp_type_id);
            }
        }

        $picked_champion_ids = $db->get_session_picked_champion_ids($this->session_id);
        $this->picked_champions = array(
            "Top Lane" => null,
            "Jungle" => null,
            "Mid Lane" => null,
            "AD Carry" => null,
            "Support" => null,
        );
        foreach ($picked_champion_ids as $role => $champ_id) {
            $this->picked_champions[$role] = new Champion($champ_id);
        }

        $picked_player_ids = $db->get_session_picked_player_ids($this->session_id);
        $this->picked_players = array(
            "Top Lane" => null,
            "Jungle" => null,
            "Mid Lane" => null,
            "AD Carry" => null,
            "Support" => null,
        );
        foreach ($picked_player_ids as $role => $player_id) {
            $this->picked_players[$role] = new Player($player_id);
        }

        $starter_ids = $db->get_session_starter_ids($this->session_id);
        $this->starters = array(
            "Top Lane" => array(),
            "Jungle" => array(),
            "Mid Lane" => array(),
            "AD Carry" => array(),
            "Support" => array(),
        );
        foreach ($starter_ids as $role => $player_ids) {
            foreach ($player_ids as $player_id) {
                $this->starters[$role][] = new Player($player_id);
            }
        }

        $enemy_champion_ids = $db->get_session_enemy_champion_ids($this->session_id);
        $this->enemy_champions = array();
        foreach ($enemy_champion_ids as $champ_id) {
            $this->enemy_champions[] = new Champion($champ_id);
        }

        $ban_ids = $db->get_session_ban_ids($this->session_id);
        $this->bans = array(array(), array());
        foreach ($ban_ids[0] as $champ_id) {
            $this->bans[0][] = new Champion($champ_id);
        }
        foreach ($ban_ids[1] as $champ_id) {
            $this->bans[1][] = new Champion($champ_id);
        }
    }
}
?>