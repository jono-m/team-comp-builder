<?php include_once '../../header.php' ?>
<link rel="stylesheet" type="text/css" href="/assets/styles/player.css">
<script src="/assets/js/pages/player.js"></script>
<script>var player_id = <?php echo $_GET["player_id"] ?></script>
<div id="summary" class="clearfix">
    <div class="header1" id="player_name"></div>
    <div class="stat">Top Laners: 10</div>
    <div class="stat">Junglers: 10</div>
    <div class="stat">Mid Laners: 10</div>
    <div class="stat">AD Carries: 10</div>
    <div class="stat">Supports: 10</div>
    <div id="buttonpanel">
        <div class="button" id="rename_player">Rename</div>
        <div class="button button-bad" id="delete_player">Delete Player</div>
    </div>
</div>
<div class="listbox">
    <div class="header3">Top Lane</div>
    <div class="listbox-divider" id="top_laners">
        <div class="listbox-item listbox-add listbox-button" id="add_top_laners"><a>+</a></div>
    </div>
    <div class="header3">Jungle</div>
    <div class="listbox-divider" id="junglers">
        <div class="listbox-item listbox-add listbox-button" id="add_junglers"><a>+</a></div>
    </div>
    <div class="header3">Mid Lane</div>
    <div class="listbox-divider" id="mid_laners">
        <div class="listbox-item listbox-add listbox-button" id="add_mid_laners"><a>+</a></div>
    </div>
    <div class="header3">AD Carry</div>
    <div class="listbox-divider" id="adcs">
        <div class="listbox-item listbox-add listbox-button" id="add_adcs"><a>+</a></div>
    </div>
    <div class="header3">Support</div>
    <div class="listbox-divider" id="supports">
        <div class="listbox-item listbox-add listbox-button" id="add_supports"><a>+</a></div>
    </div>
</div>
<div class="popup" id="champselect">
    <div class="popup-shader"></div>
    <div class="popup-content">
        <div class="popup-section clearfix" id="popuptitle">
            <div class="popup-title header2">Add Champions</div>
            <div class="button popup-close">Close</div>
            <div class="button button-good popup-confirm">Add</div>
        </div>
        <div class="text-entry" id="popupentry">
            <input type="text" id="champ_searchbox"/>
        </div>
        <div id="champion_list" class="listbox listbox-divider">
        </div>
    </div>
</div>
<div class="popup" id="rename">
    <div class="popup-shader"></div>
    <div class="popup-content">
        <div class="popup-section clearfix">
            <div class="popup-title header2">Rename Player</div>
            <div class="button popup-close">Close</div>
            <div class="button button-good popup-confirm">Rename</div>
        </div>
        <div class="text-entry">
            <input type="text" id="player_renamebox"/>
        </div>
    </div>
</div>
<?php include_once '../../footer.php' ?>