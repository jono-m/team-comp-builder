var comp_type_manager = (function() {
    var pub = {}
    var pri = {} 

    pub.retrieve_all = function() {
        $.ajax({
            type: "POST",
            url: "/assets/php/scripts/comp_type.php",
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