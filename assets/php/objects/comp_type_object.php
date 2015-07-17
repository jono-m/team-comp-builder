<?php

class CompType {
    function __construct($comp_id) {
        $this->comp_id = $comp_id;
        $this->load_comp_type();
    }
    function load_comp_type() {
        global $db;
        $this->comp_type = $db->get_comp_type($this->comp_id);
    }
}

?>