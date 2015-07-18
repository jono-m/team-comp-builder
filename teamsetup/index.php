<?php include_once '../header.php' ?>
<link rel="stylesheet" type="text/css" href="/assets/styles/teamsetup.css">
<script src="/assets/js/pages/teamsetup.js"></script>
<div class="tabbar clearfix">
    <div class="tab tab-first" id="tab_players">Players</div>
    <div class="tab tab-middle" id="tab_comp_types">Composition Types</div>
    <div class="tab tab-last" id="tab_champions">Champions</div>
</div>
<div class="tabpage" id="tabpage_players">
    <div class="listbox listbox-divider" id="player_list">
        <div class="listbox-item listbox-add listbox-button" id="add_player"><a>+</a></div>
    </div>
</div>
<div class="tabpage" id="tabpage_comp_types">
    <div class="listbox listbox-divider" id="comp_type_list">
        <div class="listbox-item listbox-add listbox-button" id="add_comp_type"><a>+</a></div>
    </div>
</div>
<div class="tabpage" id="tabpage_champions">
    <div class="listbox listbox-divider" id="champion_list">
    </div>
</div>
<div class="popup" id="champ_comp_types">
    <div class="popup-content">
        <div class="popup-section clearfix">
            <img src = "" class="popup-titleimage"/>
            <div class="popup-title header1"></div>
            <div class="button popup-close">X</div>
            <div class="button button-good popup-confirm">✓</div>
        </div>
        <div id="comp_types" class="listbox">
            
        </div>
    </div>
</div>
<?php include_once '../footer.php' ?>