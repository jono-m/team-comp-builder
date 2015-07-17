var player_manager = (function() {
    var pub = {}
    var pri = {} 

    pub.retrieve_all = function(callback) {
        pri.submitAJAX("/assets/php/scripts/player.php",
            {method: "retrieveall"},
            callback);
    };

    pub.retrieve = function(player_id, callback) {
        pri.submitAJAX("/assets/php/scripts/player.php",
            {method: "retrieve",
            player_id: player_id},
            callback);
    }

    pub.new = function(player_name, callback) {
        pri.submitAJAX("/assets/php/scripts/player.php",
            {method: "new",
            player_name: player_name},
            callback);
    }

    pub.rename = function(player_id, player_name, callback) {
        pri.submitAJAX("/assets/php/scripts/player.php",
            {method: "rename",
            player_id: player_id,
            player_name: player_name},
            callback);
    }

    pub.delete = function(player_id, callback) {
        pri.submitAJAX("/assets/php/scripts/player.php",
            {method: "delete",
            player_id: player_id},
            callback);
    }

    pri.submitAJAX = function(url, data, callback) {
        $.ajax({type: "POST", url: url, data: data,
            success: function(data){    
                if(callback) {
                    callback($.parseJSON(data));
                }
            }
        });
    }

    return pub;
}());