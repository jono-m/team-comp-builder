<?php
include_once '../common.php';
include_once '../objects/db.php';
include_once '../objects/comp_type_object.php';

$method = urlvar("method");

$db = new DB();
$db->connect();
switch($method) {
    case "retrieveall":
        $comp_ids = $db->get_comp_type_ids();
        $comp_types = array();
        foreach($comp_ids as $comp_id) {
            $comp_types[] = new CompType($comp_id);
        }
        echo json_encode($comp_types);
        break;
    case "retrieve":
        $comp_id = urlvar("comp_id");
        echo json_encode(new CompType($comp_id));
        break;
    case "new":
        $comp_type = urlvar("comp_type");
        $db->add_comp_type($comp_type);
        break;
    case "delete":
        $comp_id = urlvar("comp_id");
        $db->remove_comp_type($comp_id);
        break;
}
$db->disconnect();
?>