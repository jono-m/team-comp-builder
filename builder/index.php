<?php include_once '../header.php' ?>
<link rel="stylesheet" type="text/css" href="/assets/styles/builder.css">
<script src="/assets/js/pages/builder.js"></script>
<div class="summarybox clearfix">
    <div class="header1">Composition Builder</div>
    <div class="stat">Active Sessions: 0</div>
</div>
<div class="clearfix" id="sessions">
    <div class="button" id="new_session">+ Create New Session</div>
    <div class="listbox listbox-divider clearfix" id="session_list">
        <div class="session">
            <div class="session_bar clearfix">
                <div class="session_name">Poopy Bandits</div>
                <div class="session_viewers">14 viewers</div>
            </div>
            <div class="session_overview clearfix">
                <div class="picks">
                    <div class="teampicks">
                        <div class="pick">
                            <div class="lane">Top Lane</div>
                            <div class="player-champion">
                                <div class="player_name">David</div>
                                <div class="champion_name">Aatrox</div>
                            </div>
                            <div class="champion_image"><img src="/assets/images/Aatrox.png"/></div>
                        </div>
                        <div class="pick">
                            <div class="lane">Jungle</div>
                            <div class="player-champion">
                                <div class="player_name">David</div>
                                <div class="champion_name">Aatrox</div>
                            </div>
                            <div class="champion_image"><img src="/assets/images/Aatrox.png"/></div>
                        </div>
                    </div>
                    <div class="versus">VS</div>
                    <div class="enemypicks">
                        <div class="champion_image"><img src="/assets/images/Leona.png"/></div>
                        <div class="champion_name">Leona</div>
                    </div>
                </div>
                <div class="bans">
                    <div class="banstext">Bans</div>
                    <div class="teambans">
                        <div class="champion_image"><img src="/assets/images/Leona.png"/></div>
                        <div class="champion_image"><img src="/assets/images/Jarvaniv.png"/></div>
                        <div class="champion_image"><img src="/assets/images/Chogath.png"/></div>
                    </div>
                    <div class="enemybans">
                        <div class="champion_image"><img src="/assets/images/Ekko.png"/></div>
                        <div class="champion_image"><img src="/assets/images/Tahmkench.png"/></div>
                        <div class="champion_image"><img src="/assets/images/Blitzcrank.png"/></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once '../footer.php' ?>