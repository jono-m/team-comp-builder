<?php include_once '../header.php' ?>
<link rel="stylesheet" type="text/css" href="/assets/styles/champions.css">
<script src="/assets/js/pages/teamsetup.js"></script>
<div class="tabbar">
    <div class="tab tab-first" id="tab_players">Players</div>
    <div class="tab tab-middle" id="tab_comp_types">Composition Types</div>
    <div class="tab tab-last" id="tab_champions">Champions</div>
</div>
<div class="tabpage" id="tabpage_players">
    <div class="header1">Players</div>
    <div class="listbox listbox-divider" id="player_list">
    </div>
</div>
<div class="tabpage" id="tabpage_comp_types">
    <div class="header1">Composition Types</div>
    <div class="listbox listbox-divider" id="comp_type_list">
    </div>
</div>
<div class="tabpage" id="tabpage_champions">
    <div class="header1">Champions</div>
    <div class="listbox listbox-divider" id="champion_list">
    </div>
</div>
<?php include_once '../footer.php' ?>