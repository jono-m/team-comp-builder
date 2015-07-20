var session_manager = (function() {
    var pub = {}
    var pri = {} 

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