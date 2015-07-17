var player_manager = (function() {
    var pub = {}
    var pri = {} 

    pub.retrieve_all = function() {
        $.ajax({
            type: "POST",
            url: "/assets/php/scripts/player.php",
            data: {method: "retrieveall"},
            success: function(data){    
                pub.retrieve_all_callback($.parseJSON(data));
            }
        });
    };

    pub.retrieve_all_callback = function(data) {
    };

    return pub;
}());