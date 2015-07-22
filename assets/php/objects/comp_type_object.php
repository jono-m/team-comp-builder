<?php

class CompType {
    function __construct($comp_id) {
        $this->comp_id = $comp_id;
        if($comp_id == null) {
            $this->is_valid = false;
        } else {
            $this->is_valid = true;
        }
        $this->load_comp_type();
    }
    function load_comp_type() {
        global $db;
        if($this->is_valid) {
            $this->comp_type = $db->get_comp_type($this->comp_id);
        } else {
            $this->comp_name = "---";
            $this->comp_id = "unpicked";
        }
    }
}

?>