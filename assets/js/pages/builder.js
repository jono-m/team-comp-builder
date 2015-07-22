$(document).ready(function() {
    document.title = 'Composition Builder | Syner.gg';
    util.addPath('Composition Builder', '/builder/');

    $("#new_session").click(function() {
        page.new_session();
    });

    page.reloadSessions();
});


var page = (function() {
    var pub = {}
    var pri = {}

    pub.new_session = function() {
        var session_name = prompt("Enter a name for this session.", "");
        if(session_name != "") {
            session_manager.new(session_name, pub.reloadSessions);
        }
    }

    pub.reloadSessions = function() {
        session_manager.retrieveall(pri.fillSessionList);
    }

    pri.fillSessionList = function() {
        $("#session_list").html('');
        var sessions = session_manager.get_sessions();
        $("#num_sessions").html(sessions.length);

        for(var session_index = 0; session_index < sessions.length; session_index++) {
            var session = sessions[session_index];
            $("#session_list").append(
'<div class="session">' + 
           '<a href="/builder/session/?session_id=' + session.session_id + '"><div class="joinsession" style="display: none"><div class="jointext"><div class="centercell">Join Session</div></div></div></a>' +
            '<div class="session_bar clearfix">' +
                '<div class="session_name">' + session.session_name + '</div>' +
            '</div>' + 
            '<div class="session_overview clearfix">' +
                '<div class="picks">' +
                    '<div class="teampicks">' +
                        '<div class="pick">' +
                            '<div class="lane">Top Lane</div>' +
                            '<div class="player-champion">' +
                                '<div class="player_name">' + session.picked_players["Top Lane"].player_name + '</div>' +
                                '<div class="champion_name">' + session.picked_champions["Top Lane"].champ_name + '</div>' +
                            '</div>' +
                            '<div class="champion_image"><img src="' + session.picked_champions["Top Lane"].champ_img + '"/></div>' +
                        '</div>' + 
                        '<div class="pick">' +
                            '<div class="lane">Jungle</div>' +
                            '<div class="player-champion">' +
                                '<div class="player_name">' + session.picked_players["Jungle"].player_name + '</div>' +
                                '<div class="champion_name">' + session.picked_champions["Jungle"].champ_name + '</div>' +
                            '</div>' +
                            '<div class="champion_image"><img src="' + session.picked_champions["Jungle"].champ_img + '"/></div>' +
                        '</div>' + 
                        '<div class="pick">' +
                            '<div class="lane">Mid Lane</div>' +
                            '<div class="player-champion">' +
                                '<div class="player_name">' + session.picked_players["Mid Lane"].player_name + '</div>' +
                                '<div class="champion_name">' + session.picked_champions["Mid Lane"].champ_name + '</div>' +
                            '</div>' +
                            '<div class="champion_image"><img src="' + session.picked_champions["Mid Lane"].champ_img + '"/></div>' +
                        '</div>' + 
                        '<div class="pick">' +
                            '<div class="lane">AD Carry</div>' +
                            '<div class="player-champion">' +
                                '<div class="player_name">' + session.picked_players["AD Carry"].player_name + '</div>' +
                                '<div class="champion_name">' + session.picked_champions["AD Carry"].champ_name + '</div>' +
                            '</div>' +
                            '<div class="champion_image"><img src="' + session.picked_champions["AD Carry"].champ_img + '"/></div>' +
                        '</div>' + 
                        '<div class="pick">' +
                            '<div class="lane">Support</div>' +
                            '<div class="player-champion">' +
                                '<div class="player_name">' + session.picked_players["Support"].player_name + '</div>' +
                                '<div class="champion_name">' + session.picked_champions["Support"].champ_name + '</div>' +
                            '</div>' +
                            '<div class="champion_image"><img src="' + session.picked_champions["Support"].champ_img + '"/></div>' +
                        '</div>' + 
                    '</div>' +
                    '<div class="versus">VS</div>' +
                    '<div class="enemypicks">' +
                        '<div class="pick">' +
                            '<div class="champion_image"><img src="' + session.enemy_champions[0].champ_img + '"/></div>' +
                            '<div class="champion_name">' + session.enemy_champions[0].champ_name + '</div>' +
                        '</div>' +
                        '<div class="pick">' +
                            '<div class="champion_image"><img src="' + session.enemy_champions[1].champ_img + '"/></div>' +
                            '<div class="champion_name">' + session.enemy_champions[1].champ_name + '</div>' +
                        '</div>' +
                        '<div class="pick">' +
                            '<div class="champion_image"><img src="' + session.enemy_champions[2].champ_img + '"/></div>' +
                            '<div class="champion_name">' + session.enemy_champions[2].champ_name + '</div>' +
                        '</div>' +
                        '<div class="pick">' +
                            '<div class="champion_image"><img src="' + session.enemy_champions[3].champ_img + '"/></div>' +
                            '<div class="champion_name">' + session.enemy_champions[3].champ_name + '</div>' +
                        '</div>' +
                        '<div class="pick">' +
                            '<div class="champion_image"><img src="' + session.enemy_champions[4].champ_img + '"/></div>' +
                            '<div class="champion_name">' + session.enemy_champions[4].champ_name + '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="bans">' +
                    '<div class="banstext">Bans</div>' +
                    '<div class="teambans">' +
                        '<div class="champion_image"><img src="' + session.bans[1][0].champ_img + '"/></div>' +
                        '<div class="champion_image"><img src="' + session.bans[1][1].champ_img + '"/></div>' +
                        '<div class="champion_image"><img src="' + session.bans[1][2].champ_img + '"/></div>' +
                    '</div>' +
                    '<div class="enemybans">' +
                        '<div class="champion_image"><img src="' + session.bans[0][0].champ_img + '"/></div>' +
                        '<div class="champion_image"><img src="' + session.bans[0][1].champ_img + '"/></div>' +
                        '<div class="champion_image"><img src="' + session.bans[0][2].champ_img + '"/></div>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>')

        }
        $(".session").mouseover(function() {
            $(this).find('.joinsession').show();
        });
        $(".session").mouseout(function() {
            $(this).find('.joinsession').hide();
        });
    }

    return pub;
}());

