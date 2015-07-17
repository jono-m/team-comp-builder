var comp_type_manager = (function() {
    var pub = {}
    var pri = {} 

    pub.retrieve_all = function(callback) {
        pri.submitAJAX("/assets/php/scripts/comp_type.php",
            {method: "retrieveall"},
            callback);
    };

    pub.retrieve = function(comp_id, callback) {
        pri.submitAJAX("/assets/php/scripts/comp_type.php",
            {method: "retrieve",
            comp_id: comp_id},
            callback);
    }

    pub.new = function(comp_type, callback) {
        pri.submitAJAX("/assets/php/scripts/comp_type.php",
            {method: "new",
            comp_type: comp_type},
            callback);
    }

    pub.delete = function(comp_id, callback) {
        pri.submitAJAX("/assets/php/scripts/comp_type.php",
            {method: "delete",
            player_id: comp_id},
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