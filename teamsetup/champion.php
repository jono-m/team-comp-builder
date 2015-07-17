<?php include_once 'header.php' ?>
<link rel="stylesheet" type="text/css" href="styles/champion.css">
<script src="scripts/champion.js"></script>
<?php
    $champ_id = $_GET["champ_id"];
    $champion = new Champion($champ_id, $db);

    
?>
<script>var champ_id = <?php echo $champ_id ?></script>
<?php echo '<img src="' . $champion->champ_img . '" id="headerimage"/>' ?>
<div class="header1"><?php echo $champion->champ_name; ?></div>
<div id="champion_comps">
    <div class="header2">Composition Qualities</div>
    <div id="quality_list" class="listbox listbox-divider">
        <?php
        foreach($champion->comp_types as $comp_type) {
            echo '<div class="listbox-item trigger-edit" id="' . $comp_type[0]->comp_id . '"><a href="">' . $comp_type[0]->comp_type . ': ' . $comp_type[1] . '</a></div>';
        }
    ?></div>
</div>
<div id="champion_players">
    <div class="header2">Players</div>
    <div id="player_list" class="listbox">
        <?php

        foreach($champion_players as $role => $players) {
            echo '<div class="listbox-divider"><div class="header3">' . $role . '</div>';
            foreach($players as $player) {
                echo '<div class="listbox-item"><a href="player.php?player_id=' 
                    . $player->player_id . '">' . $player->player_name . '</a></div>';
            }
            echo '</div>';
        }
    ?></div>
</div>
<?php include_once 'footer.php' ?>