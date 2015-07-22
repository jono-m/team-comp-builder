var session_manager = (function() {
    var pub = {}
    var pri = {} 

    pub.retrieveall = function(callback) {
        pri.submitAJAX("/assets/php/scripts/session.php",
            {method: "retrieveall"},
            pri.update_sessions, callback);
    };

    pub.retrieve = function(session_id, callback) {
        pri.submitAJAX("/assets/php/scripts/session.php",
            {method: "retrieve",
            session_id: session_id},
            pri.update_session, callback);
    };

    pub.new = function(session_name, callback) {
        pri.submitAJAX("/assets/php/scripts/session.php",
            {method: "new",
            session_name: session_name}, 
            null, callback);
    };

    pub.end = function(session_id, callback) {
        pri.submitAJAX("/assets/php/scripts/session.php",
            {method: "end",
            session_id: session_id},
            null , callback);
    };

    pub.rename = function(session_id, session_name, callback) {
        pri.submitAJAX("/assets/php/scripts/session.php",
            {method: "rename",
            session_id: session_id,
            session_name: session_name},
            null, callback);
    };

    pub.setcompid = function(session_id, role, comp_id, comp_type_number, callback) {
        pri.submitAJAX("/assets/php/scripts/session.php",
            {method: "setcompid",
            session_id: session_id,
            role: role,
            comp_id: comp_id,
            comp_type_number: comp_type_number},
            null, callback);
    };

    pub.setpickedchampid = function(session_id, role, champ_id, callback) {
        pri.submitAJAX("/assets/php/scripts/session.php",
            {method: "setpickedchampid",
            session_id: session_id,
            role: role,
            champ_id: champ_id},
            null, callback);
    };

    pub.setpickedplayerid = function(session_id, role, player_id, callback) {
        pri.submitAJAX("/assets/php/scripts/session.php",
            {method: "setpickedplayerid",
            session_id: session_id,
            role: role,
            player_id: player_id},
            null, callback);
    };

    pub.setstarterid = function(session_id, role, starter_id, starter_number, callback) {
        pri.submitAJAX("/assets/php/scripts/session.php",
            {method: "setstarterid",
            session_id: session_id,
            role: role,
            starter_id: starter_id,
            starter_number: starter_number},
            null, callback);
    };

    pub.setenemychampid = function(session_id, enemy_champion_id, champion_number, callback) {
        pri.submitAJAX("/assets/php/scripts/session.php",
            {method: "setenemychampid",
            session_id: session_id,
            enemy_champion_id: enemy_champion_id,
            champion_number: champion_number},
            null, callback);
    };

    pub.setbanid = function(session_id, ban_champ_id, teamban, ban_number, callback) {
        pri.submitAJAX("/assets/php/scripts/session.php",
            {method: "setbanid",
            session_id: session_id,
            ban_champ_id: ban_champ_id,
            teamban: teamban,
            ban_number: ban_number},
            null, callback);
    };

    pri.sessions = null;
    pri.session = null;

    pri.update_sessions = function(sessions) {
        pri.sessions = sessions;
    }

    pri.update_session = function(session) {
        pri.session = session;
    }

    pub.get_sessions = function() {
        return pri.sessions;
    }

    pub.get_session = function() {
        return pri.session;
    }

    pub.get_champ_list = function(search_string, role) {
        var available_champions = pri.get_available_champions(role);
        available_champions.sort(function(champ_a, champ_b) {
            var scoreA = pri.get_champ_totalscore(champ_a, role);
            var scoreB = pri.get_champ_totalscore(champ_b, role);
            return scoreB-scoreA;
        });

        var champ_list = [];
        for(var acindex = 0; acindex < available_champions.length; acindex++) {
            if(available_champions[acindex].champ_name.toLowerCase().indexOf(search_string.toLowerCase()) != -1) {
                champ_list.push(available_champions[acindex]);
            }
        }
        return champ_list
    }

    pri.get_champ_totalscore = function(champion, role) {
        var cts = [];
        for(var ctindex = 0; ctindex < pri.session.comp_types[role].length; ctindex++) {
            var comp_type = pri.session.comp_types[role][ctindex];
            if(comp_type.is_valid) {
                cts.push(comp_type.comp_id);
            }
        }
        var totalscore = 1;
        for(var ctindex = 0; ctindex < champion.comp_types.length; ctindex++) {
            var comp_type = champion.comp_types[ctindex][0];
            var strength = champion.comp_types[ctindex][1];
            for(var cti = 0; cti < cts.length; cti++) {
                if(cts[cti] == comp_type.comp_id) {
                    totalscore *= parseInt(strength);
                    break;
                }
            }
        }
        return totalscore;
    }

    pri.get_available_champions = function(role) {
        var unavailable_champion_ids = [];
        // All picked champions
        if(pri.session.picked_champions["Top Lane"].is_valid) {
            unavailable_champion_ids.push(pri.session.picked_champions["Top Lane"].champ_id);
        }
        if(pri.session.picked_champions["Jungle"].is_valid) {
            unavailable_champion_ids.push(pri.session.picked_champions["Jungle"].champ_id);
        }
        if(pri.session.picked_champions["Mid Lane"].is_valid) {
            unavailable_champion_ids.push(pri.session.picked_champions["Mid Lane"].champ_id);
        }
        if(pri.session.picked_champions["AD Carry"].is_valid) {
            unavailable_champion_ids.push(pri.session.picked_champions["AD Carry"].champ_id);
        }
        if(pri.session.picked_champions["Support"].is_valid) {
            unavailable_champion_ids.push(pri.session.picked_champions["Support"].champ_id);
        }
        // Enemy champions
        for(var enemy_index = 0; enemy_index < pri.session.enemy_champions.length; enemy_index++) {
            var champion = pri.session.enemy_champions[enemy_index];
            if(champion.is_valid) {
                unavailable_champion_ids.push(champion.champ_id);
            }
        }
        // Banned champions
        for(var ban_index = 0; ban_index < pri.session.bans[0].length; ban_index++) {
            var champion = pri.session.bans[0][ban_index];
            if(champion.is_valid) {
                unavailable_champion_ids.push(champion.champ_id);
            }
            champion = pri.session.bans[1][ban_index];
            if(champion.is_valid) {
                unavailable_champion_ids.push(champion.champ_id);
            }
        }

        var available_champions = [];
        for(var starter_index = 0; starter_index < pri.session.starters[role].length; starter_index++) {
            var starter = pri.session.starters[role][starter_index];
            if(starter.is_valid) {
                for(var champion_index = 0; champion_index < starter.champions[role].length; champion_index++) {
                    var champion = starter.champions[role][champion_index];
                    if(champion.is_valid) {
                        var found = false;
                        for(var uain = 0; uain < unavailable_champion_ids.length; uain++) {
                            if(unavailable_champion_ids[uain] == champion.champ_id) {
                                found = true;
                                break;
                            }
                        }
                        if(!found) {
                            var found = -1;
                            for(var acindex = 0; acindex < available_champions.length; acindex++) {
                                if(available_champions[acindex].champ_id == champion.champ_id) {
                                    found = acindex;
                                    break;
                                }
                            }
                            var noncircularstarter = {player_id: starter.player_id, player_name: starter.player_name}
                            if(found != -1) {
                                available_champions[found].starters.push(noncircularstarter);
                            } else {
                                champion.starters = [noncircularstarter];
                                available_champions.push(champion);
                            }
                        }
                    }
                }
            }
        }
        return available_champions;
    }

    pri.submitAJAX = function(url, data, internalcb, externalcb) {
        $.ajax({type: "POST", url: url, data: data,
            success: function(returned_data){    
                if(internalcb != null) {
                    if(returned_data != "") {
                        internalcb($.parseJSON(returned_data));
                    } else {
                        internalcb("");
                    }
                } if(externalcb != null) {
                    externalcb();
                }
            }
        });
    }

    return pub;
}());