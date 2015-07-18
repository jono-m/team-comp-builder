var comp_type_manager = (function() {
    var pub = {}
    var pri = {} 

    pub.retrieve_all = function(callback) {
        pri.submitAJAX("/assets/php/scripts/comp_type.php",
            {method: "retrieveall"}, pri.update_comp_types,
            callback);
    };

    pub.retrieve = function(comp_id, callback) {
        pri.submitAJAX("/assets/php/scripts/comp_type.php",
            {method: "retrieve",
            comp_id: comp_id}, null,
            callback);
    }

    pub.new = function(comp_type, callback) {
        pri.submitAJAX("/assets/php/scripts/comp_type.php",
            {method: "new",
            comp_type: comp_type}, null,
            callback);
    }

    pub.delete = function(comp_id, callback) {
        pri.submitAJAX("/assets/php/scripts/comp_type.php",
            {method: "delete",
            player_id: comp_id}, null,
            callback);
    }

    pri.comp_types = null;

    pub.get_comp_types = function() {
        return pri.comp_types;
    }

    pri.update_comp_types = function(comp_types) {
        pri.comp_types = comp_types;
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
                }if(externalcb != null) {
                    externalcb();
                }
            }
        });
    }

    return pub;
}());