<?php include_once 'header.php' ?>
<link rel="stylesheet" type="text/css" href="styles/player.css">
<script src="scripts/player.js"></script>
<?php
    $player_id = $_GET["player_id"];
    $player = new Player($player_id, $db)
?>
<script>var player_id = <?php echo $player_id ?></script>
<div class="header1"><?php echo $player->player_name; ?></div>
<div id="buttonpanel">
    <div class="button" id="rename_player">Rename</div>
    <div class="button function-strong" id="delete_player">Delete Player</div>
</div>
<div class="header2">Champions</div>
<div id="champion_list" class="listbox">
    <?php
    foreach($player->champions as $role => $champions) {
        echo '<div class="listbox-divider"><div class="header3">' . $role . '</div>';
        foreach($champions as $champion) {
            echo '<div class="listbox-item"><img src="' . $champion->champ_img . '" class="listbox-item-image"/><a href="champion.php?champ_id=' 
                . $champion->champ_id . '">' . $champion->champ_name . '</a></div>';
        }
        echo '<div class="listbox-item listbox-add"><a href="#">+</a></div>';
        echo '</div>';
    }
?>
</div>
</div>
<div class="popup" id="champselect">
    <?php
    $champ_ids = $db->get_champ_ids();

    $champions = array();
    foreach($champ_ids as $champ_id) {
        if()
        $champions[] = new Champion($champ_id, $db);
    }
    ?>
    <div class="header2">Add Champions</div>
    <div id="champion_list" class="listbox listbox-divider">
        <?php
            foreach($champions as $champion) {
                echo '<div class="listbox-item"><img src="' . $champion->champ_img . '" class="listbox-item-image"/><a href="champion.php?champ_id=' 
                    . $champion->champ_id . '">' . $champion->champ_name . '</a></div>';
            }
            echo '<div class="listbox-item listbox-add"><a href="#">+</a></div>';
        ?>
    </div>
</div>
<?php include_once 'footer.php' ?>