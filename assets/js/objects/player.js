var player_manager = (function() {
    var pub = {}
    var pri = {} 

    pub.retrieve_all = function(callback) {
        pri.submitAJAX("/assets/php/scripts/player.php",
            {method: "retrieveall"},
            pri.update_players, callback);
    };

    pub.retrieve = function(player_id, callback) {
        pri.submitAJAX("/assets/php/scripts/player.php",
            {method: "retrieve",
            player_id: player_id}, pri.update_player,
            callback);
    }

    pub.new = function(player_name, callback) {
        pri.submitAJAX("/assets/php/scripts/player.php",
            {method: "new",
            player_name: player_name}, null,
            callback);
    }

    pub.rename = function(player_id, player_name, callback) {
        pri.submitAJAX("/assets/php/scripts/player.php",
            {method: "rename",
            player_id: player_id,
            player_name: player_name}, null,
            callback);
    }

    pub.delete = function(player_id, callback) {
        pri.submitAJAX("/assets/php/scripts/player.php",
            {method: "delete",
            player_id: player_id}, null,
            callback);
    }

    pub.add_champion = function(player_id, champ_id, role, callback) {
        pri.submitAJAX("/assets/php/scripts/player.php",
            {method: "addchamp",
            player_id: player_id,
            champ_id: champ_id,
            role: role}, null,
            callback);
    }

    pub.remove_champion = function(player_id, champ_id, role, callback) {
        pri.submitAJAX("/assets/php/scripts/player.php",
            {method: "removechamp",
            player_id: player_id,
            champ_id: champ_id,
            role: role}, null,
            callback);
    }

    pri.players = null;

    pub.get_player = function() {
        return pri.player;
    }

    pub.get_player_champ_ids = function(role) {
        var champ_ids = [];
        for(var champ_index = 0; champ_index < pri.player.champions[role].length; champ_index++) {
            champ_ids.push(pri.player.champions[role][champ_index].champ_id);
        }
        return champ_ids
    }

    pub.get_players = function() {
        return pri.players;
    }

    pri.update_player = function(player) {
        pri.player = player;
    }

    pri.update_players = function(players) {
        pri.players = players;
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