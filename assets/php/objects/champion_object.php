<?php
include_once 'comp_type_object.php';

class Champion {
    function __construct($champ_id) {
        $this->champ_id = $champ_id;
        $this->load_champion();
    }
    function load_champion() {
            global $db;
            $this->champ_name = $db->get_champ_name($this->champ_id);
            $stripped_name = ucfirst(strtolower(preg_replace('/[^A-Za-z0-9]/', '', preg_replace('/[ \']/', '', $this->champ_name))));
            $this->champ_img = "/assets/images/" . $stripped_name . ".png";

            $champ_comp_types = $db->get_champions_comp_types($this->champ_id);

            $this->comp_types = array();
            foreach($champ_comp_types as $champ_comp_id => $champ_comp_strength) {
                $this->comp_types[] = array(new CompType($champ_comp_id), $champ_comp_strength);
            }
    }
}

?>