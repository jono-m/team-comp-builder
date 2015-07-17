var champion_manager = (function() {
    var pub = {}
    var pri = {} 

    pub.retrieve_all = function(callback) {
        pri.submitAJAX("/assets/php/scripts/champion.php",
            {method: "retrieveall"},
            callback);
    };

    pub.retrieve = function(champ_id, callback) {
        pri.submitAJAX("/assets/php/scripts/champion.php",
            {method: "retrieve",
            champ_id: champ_id},
            callback);
    }

    pub.new = function(champ_name, callback) {
        pri.submitAJAX("/assets/php/scripts/champion.php",
            {method: "new",
            champ_name: champ_name},
            callback);
    }

    pub.update_strength = function(champ_id, comp_id, strength, callback) {
        pri.submitAJAX("/assets/php/scripts/champion.php",
            {method: "update_strength",
            champ_id: champ_id,
            comp_id: comp_id,
            strength: strength},
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