<?php
include_once 'champion_object.php';

class Player {
    function __construct($player_id) {
        $this->player_id = $player_id;
        if($player_id == null) {
            $this->is_valid = false;
        } else {
            $this->is_valid = true;
        }
        $this->load_player();
    }
    function load_player() {
        global $db;
        if($this->is_valid) {
            $this->player_name = $db->get_player_name($this->player_id);
            $champion_ids = $db->get_player_champ_ids($this->player_id);

            $this->champions = array(
                "Top Lane" => array(),
                "Jungle" => array(),
                "Mid Lane" => array(),
                "AD Carry" => array(),
                "Support" => array(),
            );
            foreach ($champion_ids as $role => $ids) {
                foreach ($ids as $champ_id) {
                    $this->champions[$role][] = new Champion($champ_id);
                }
            }
        } else {
            $this->player_name = "";
        }
    }
}

?>