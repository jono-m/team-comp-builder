<?php include_once 'header.php' ?>
<link rel="stylesheet" type="text/css" href="styles/player.css">
<script src="/assets/js/pages/player.js"></script>
<script>var player_id = <?php echo $_GET["player_id"] ?></script>
<div class="header1" id="player_name"></div>
<div id="buttonpanel">
    <div class="button" id="rename_player">Rename</div>
    <div class="button function-strong" id="delete_player">Delete Player</div>
</div>
<div class="header2">Champions</div>
<div id="champion_list" class="listbox">
</div>
<div class="popup" id="champselect">
</div>
<?php include_once 'footer.php' ?>



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