<?php include_once 'header.php' ?>
<link rel="stylesheet" type="text/css" href="styles/compositions.css">
<script src="scripts/compositions.js"></script>
<?php
    $comp_ids = $db->get_comp_type_ids();

    $comp_types = array();
    foreach($comp_ids as $comp_id) {
        $comp_types[] = new CompType($comp_id, $db);
    }
?>
<div class="header1">Composition Types</div>
<div id="complist" class="listbox listbox-divider">
    <?php
        foreach($comp_types as $comp_type) {
            echo '<div class="listbox-item"><a href="#">' . $comp_type->comp_type . '</a></div>';
        }
        echo '<div class="listbox-item listbox-add" id="add_composition"><a href="#">+</a></div>';
    ?>
</div>
<?php include_once 'footer.php' ?>