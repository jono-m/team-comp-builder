<?php include_once '../../header.php' ?>
<link rel="stylesheet" type="text/css" href="/assets/styles/session.css">
<script src="/assets/js/pages/session.js"></script>
<script>session_id = <?php echo $_GET["session_id"] ?></script>
<div id="session">
    <div class="session-buttons clearfix">
        <div class="button" id="rename_session">Rename Session</div>
        <div class="button button-bad" id="end_session">End Session</div>
    </div>
    <div class="session-bar clearfix">
        <div class="teamtitle clearfix">My Team
        </div>
        <div class="enemytitle">Enemy Team</div>
    </div>
    <div class="pickrow clearfix">
        <div class="teampick clearfix">
            <div class="pick-overview clearfix">
                <div class="pick-champion">
                    <div class="lane">Top Lane</div>
                    <div class="pick-image"><img src="/assets/images/Aatrox.png" id="pick-image-TopLane"/></div>
                    <div class="pick-starter-name" id="pick-starter-name-TopLane"></div>
                    <div class="pick-name" id="pick-name-TopLane"></div>
                </div>
                <div class="pick-starters">
                    <div class="pick-starters-title">Starters</div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-TopLane-1">X</div><span id="starter-TopLane-1">David</span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-TopLane-2">(+) Add</div><span id="starter-TopLane-2"></span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-TopLane-3">X</div><span id="starter-TopLane-3">TJ</span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-TopLane-4">X</div><span id="starter-TopLane-4">Jono</span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-TopLane-5">X</div><span id="starter-TopLane-5">Sully</span></div>
                </div>
            </div>
            <div class="pick-browser">
                <div class="pick-bar clearfix">
                    <div class="search"><input type="text" id="search-TopLane"/></div>
                    <div class="comp-types">
                        <div class="comp-type">
                            <select id="comp-type-TopLane-1">
                            </select>
                        </div>
                        <div class="comp-type">
                            <select id="comp-type-TopLane-2">
                            </select>
                        </div>
                        <div class="comp-type">
                            <select id="comp-type-TopLane-3">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="pick-results clearfix" id="pick-results-TopLane">
                </div>
            </div>
        </div>
        <div class="enemypick">
            <div class="enemy-overview" id="enemy-1">
                <div class="pick-result-image">
                    <div class="pick-result-name" id="enemy-1-name"></div>
                    <img src="/assets/images/Akali.png" id="enemy-1-image"/>
                </div>
                <div class="enemy-comp-types" id="enemy-comp-types-1">
                </div>
            </div>
        </div>
    </div>
    <div class="pickrow clearfix">
        <div class="teampick clearfix">
            <div class="pick-overview">
                <div class="pick-champion">
                    <div class="lane">Jungle</div>
                    <div class="pick-image"><img src="/assets/images/Aatrox.png" id="pick-image-Jungle"/></div>
                    <div class="pick-starter-name" id="pick-starter-name-Jungle"></div>
                    <div class="pick-name" id="pick-name-Jungle"></div>
                </div>
                <div class="pick-starters">
                    <div class="pick-starters-title">Starters</div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-Jungle-1">X</div><span id="starter-Jungle-1">David</span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-Jungle-2">(+) Add</div><span id="starter-Jungle-2"></span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-Jungle-3">X</div><span id="starter-Jungle-3">TJ</span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-Jungle-4">X</div><span id="starter-Jungle-4">Jono</span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-Jungle-5">X</div><span id="starter-Jungle-5">Sully</span></div>
                </div>
            </div>
            <div class="pick-browser">
                <div class="pick-bar clearfix">
                    <div class="search"><input type="text" id="search-Jungle"/></div>
                    <div class="comp-types">
                        <div class="comp-type">
                            <select id="comp-type-Jungle-1">
                            </select>
                        </div>
                        <div class="comp-type">
                            <select id="comp-type-Jungle-2">
                            </select>
                        </div>
                        <div class="comp-type">
                            <select id="comp-type-Jungle-3">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="pick-results clearfix" id="pick-results-Jungle">
                </div>
            </div>
        </div>
        <div class="enemypick">
            <div class="enemy-overview" id="enemy-2">
                <div class="pick-result-image">
                    <div class="pick-result-name" id="enemy-2-name"></div>
                    <img src="/assets/images/Akali.png" id="enemy-2-image"/>
                </div>
                <div class="enemy-comp-types" id="enemy-comp-types-2">
                </div>
            </div>
        </div>
    </div>
    <div class="pickrow clearfix">
        <div class="teampick clearfix">
            <div class="pick-overview">
                <div class="pick-champion">
                    <div class="lane">Mid Lane</div>
                    <div class="pick-image"><img src="/assets/images/Aatrox.png" id="pick-image-MidLane"/></div>
                    <div class="pick-starter-name" id="pick-starter-name-MidLane"></div>
                    <div class="pick-name" id="pick-name-MidLane"></div>
                </div>
                <div class="pick-starters">
                    <div class="pick-starters-title">Starters</div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-MidLane-1">X</div><span id="starter-MidLane-1">David</span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-MidLane-2">(+) Add</div><span id="starter-MidLane-2"></span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-MidLane-3">X</div><span id="starter-MidLane-3">TJ</span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-MidLane-4">X</div><span id="starter-MidLane-4">Jono</span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-MidLane-5">X</div><span id="starter-MidLane-5">Sully</span></div>
                </div>
            </div>
            <div class="pick-browser">
                <div class="pick-bar clearfix">
                    <div class="search"><input type="text" id="search-MidLane"/></div>
                    <div class="comp-types">
                        <div class="comp-type">
                            <select id="comp-type-MidLane-1">
                            </select>
                        </div>
                        <div class="comp-type">
                            <select id="comp-type-MidLane-2">
                            </select>
                        </div>
                        <div class="comp-type">
                            <select id="comp-type-MidLane-3">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="pick-results clearfix" id="pick-results-MidLane">
                </div>
            </div>
        </div>
        <div class="enemypick">
            <div class="enemy-overview" id="enemy-3">
                <div class="pick-result-image">
                    <div class="pick-result-name" id="enemy-3-name"></div>
                    <img src="/assets/images/Akali.png" id="enemy-3-image"/>
                </div>
                <div class="enemy-comp-types" id="enemy-comp-types-3">
                </div>
            </div>
        </div>
    </div>
    <div class="pickrow clearfix">
        <div class="teampick clearfix">
            <div class="pick-overview">
                <div class="pick-champion">
                    <div class="lane">AD Carry</div>
                    <div class="pick-image"><img src="/assets/images/Aatrox.png" id="pick-image-ADCarry"/></div>
                    <div class="pick-starter-name" id="pick-starter-name-ADCarry"></div>
                    <div class="pick-name" id="pick-name-ADCarry"></div>
                </div>
                <div class="pick-starters">
                    <div class="pick-starters-title">Starters</div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-ADCarry-1">X</div><span id="starter-ADCarry-1">David</span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-ADCarry-2">(+) Add</div><span id="starter-ADCarry-2"></span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-ADCarry-3">X</div><span id="starter-ADCarry-3">TJ</span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-ADCarry-4">X</div><span id="starter-ADCarry-4">Jono</span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-ADCarry-5">X</div><span id="starter-ADCarry-5">Sully</span></div>
                </div>
            </div>
            <div class="pick-browser">
                <div class="pick-bar clearfix">
                    <div class="search"><input type="text" id="search-ADCarry"/></div>
                    <div class="comp-types">
                        <div class="comp-type">
                            <select id="comp-type-ADCarry-1">
                            </select>
                        </div>
                        <div class="comp-type">
                            <select id="comp-type-ADCarry-2">
                            </select>
                        </div>
                        <div class="comp-type">
                            <select id="comp-type-ADCarry-3">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="pick-results clearfix" id="pick-results-ADCarry">
                </div>
            </div>
        </div>
        <div class="enemypick">
            <div class="enemy-overview" id="enemy-4">
                <div class="pick-result-image">
                    <div class="pick-result-name" id="enemy-4-name"></div>
                    <img src="/assets/images/Akali.png" id="enemy-4-image"/>
                </div>
                <div class="enemy-comp-types" id="enemy-comp-types-4">
                </div>
            </div>
        </div>
    </div>
    <div class="pickrow clearfix">
        <div class="teampick clearfix">
            <div class="pick-overview">
                <div class="pick-champion">
                    <div class="lane">Support</div>
                    <div class="pick-image"><img src="/assets/images/Aatrox.png" id="pick-image-Support"/></div>
                    <div class="pick-starter-name" id="pick-starter-name-Support"></div>
                    <div class="pick-name" id="pick-name-Support"></div>
                </div>
                <div class="pick-starters">
                    <div class="pick-starters-title">Starters</div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-Support-1">X</div><span id="starter-Support-1">David</span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-Support-2">(+) Add</div><span id="starter-Support-2"></span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-Support-3">X</div><span id="starter-Support-3">TJ</span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-Support-4">X</div><span id="starter-Support-4">Jono</span></div>
                    <div class="starter"><div class="button button-bad remove-starter" id="sbutton-Support-5">X</div><span id="starter-Support-5">Sully</span></div>
                </div>
            </div>
            <div class="pick-browser">
                <div class="pick-bar clearfix">
                    <div class="search"><input type="text" id="search-Support"/></div>
                    <div class="comp-types">
                        <div class="comp-type">
                            <select id="comp-type-Support-1">
                            </select>
                        </div>
                        <div class="comp-type">
                            <select id="comp-type-Support-2">
                            </select>
                        </div>
                        <div class="comp-type">
                            <select id="comp-type-Support-3">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="pick-results clearfix" id="pick-results-Support">
                </div>
            </div>
        </div>
        <div class="enemypick">
            <div class="enemy-overview" id="enemy-5">
                <div class="pick-result-image">
                    <div class="pick-result-name" id="enemy-5-name"></div>
                    <img src="/assets/images/Akali.png" id="enemy-5-image"/>
                </div>
                <div class="enemy-comp-types" id="enemy-comp-types-5">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="popup" id="champselect">
    <div class="popup-shader"></div>
    <div class="popup-content">
        <div class="popup-section clearfix" id="popuptitle">
            <div class="popup-title header2">Enemy Champion</div>
            <div class="button popup-close">Close</div>
        </div>
        <div class="text-entry" id="popupentry">
            <input type="text" id="champ_searchbox"/>
        </div>
        <div id="champion_list" class="listbox listbox-divider">
        </div>
    </div>
</div>
<div class="popup" id="starterselect">
    <div class="popup-shader"></div>
    <div class="popup-content">
        <div class="popup-section clearfix" id="popuptitle">
            <div class="popup-title header2">Add Starter</div>
            <div class="button popup-close">Close</div>
        </div>
        <div id="starter_list" class="listbox listbox-divider">
        </div>
    </div>
</div>
<?php include_once '../../footer.php' ?>