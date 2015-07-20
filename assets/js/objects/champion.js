var champion_manager = (function() {
    var pub = {}
    var pri = {} 

    pub.retrieve_all = function(callback) {
        pri.submitAJAX("/assets/php/scripts/champion.php",
            {method: "retrieveall"},
            pri.update_champions, callback);
    };

    pub.retrieve = function(champ_id, callback) {
        pri.submitAJAX("/assets/php/scripts/champion.php",
            {method: "retrieve",
            champ_id: champ_id}, pri.update_champion,
            callback);
    }

    pub.new = function(champ_name, callback) {
        pri.submitAJAX("/assets/php/scripts/champion.php",
            {method: "new",
            champ_name: champ_name}, null,
            callback);
    }

    pub.update_strength = function(champ_id, comp_id, strength, callback) {
        pri.submitAJAX("/assets/php/scripts/champion.php",
            {method: "update_strength",
            champ_id: champ_id,
            comp_id: comp_id,
            strength: strength}, null,
            callback);
    }

    pri.champions = null;

    pub.get_champions = function() {
        return pri.champions;
    }

    pub.search_champions = function(search_text) {
        var search_champions = [];

        for (champ_index = 0; champ_index < pri.champions.length; champ_index++) {
            champion = pri.champions[champ_index];
            if (champion.champ_name.toLowerCase().indexOf(search_text.toLowerCase()) > -1) {
                search_champions.push(champion);
            }
        }
        return search_champions;
    }
    pri.update_champions = function(champions) {
        pri.champions = champions;
    }

    pri.champion = null;
    pub.get_champion = function() {
        return pri.champion["champion"];
    }
    pub.get_champion_players = function() {
        return pri.champion["players"];
    }
    pri.update_champion = function(champion) {
        pri.champion = champion;
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