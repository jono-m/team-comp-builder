$( document ).ready(function() {
    $("#delete_player").click(function() {
        page.delete_player();
    });
    $("#rename_player").click(function() {
        page.show_rename_player();
    });
    $('#champ_searchbox').each(function() {
       var elem = $(this);

       // Save current value of element
       elem.data('oldVal', elem.val());

       // Look for changes in the value
       elem.bind("propertychange change click keyup input paste", function(event){
          // If value has changed...
          if (elem.data('oldVal') != elem.val()) {
           // Updated stored value
           elem.data('oldVal', elem.val());

           page.refreshChampionList();
         }
       });
     });

    $("#add_top_laners").click(function() {page.show_champion_select("Top Lane")});
    $("#add_junglers").click(function() {page.show_champion_select("Jungle")});
    $("#add_mid_laners").click(function() {page.show_champion_select("Mid Lane")});
    $("#add_adcs").click(function() {page.show_champion_select("AD Carry")});
    $("#add_supports").click(function() {page.show_champion_select("Support")});

    $("#champselect .popup-close").click(function() {page.hide_champion_select()});
    $("#champselect .popup-confirm").click(function() {page.add_champions()});

    $("#champ_searchbox").watermark('Search for a champion', {className: 'text-entry-watermark', useNative: false});

    $("#player_renamebox").watermark('Enter new player name', {className: 'text-entry-watermark', useNative: false});
    $("#player_renamebox").bind('keypress', function(e) {
        var code = e.keyCode || e.which;
        if(code == 13) {
            $("#rename .popup-confirm").click();
        }
    });
    

    $("#rename .popup-close").click(function() {page.hide_rename_player()});
    $("#rename .popup-confirm").click(function() {page.rename_player()});

    $(".popup-shader").click(function() {
        page.hide_champion_select();
        page.hide_rename_player();
    });

    page.reloadPlayer();
    page.refreshChampionList();
    page.hide_champion_select();
    page.hide_rename_player();

    util.addPath('Team Manager', '/teamsetup/');
    util.addPath('Unknown Player', '/teamsetup/player/?player_id=' + player_id);
});

var page = (function() {
    var pub = {}
    var pri = {}

    pri.adding_to_role = "Top Lane";

    pri.added_champions = [];

    pub.show_champion_select = function(role) {
        pri.adding_to_role = role;
        pri.added_champions = [];
        pub.refreshChampionList();
        $("#champselect").show();
    }

    pub.hide_champion_select = function() {
        $("#champselect").hide();
    }

    pub.add_champions = function() {
        for(var champion_index = 0; champion_index < pri.added_champions.length; champion_index++) {
            var champ_id = pri.added_champions[champion_index];
            player_manager.add_champion(player_id, champ_id, pri.adding_to_role, function() {
                pub.hide_champion_select();
                pub.reloadPlayer();
            });
        }
    }

    pub.rename_player = function() {
        var new_name = $("#player_renamebox").val();
        if(new_name != null && new_name != "") {
            player_manager.rename(player_id, new_name, pub.reloadPlayer)
        }
        pub.hide_rename_player();
    }

    pub.delete_player = function() {
        if(confirm("Are you sure you want to delete this player?")) {
            player_manager.delete(player_id, function() {
                window.location.href = "/teamsetup/";
            });
        }
    }

    pub.reloadPlayer = function() {
        player_manager.retrieve(player_id, pri.fillPlayer);
    }

    pub.refreshChampionList = function() {
        var search_text = $("#champ_searchbox").val();
        champion_manager.retrieve_all(function(){pri.fillChampionList(champion_manager.search_champions(search_text))});
    }

    pri.fillPlayer = function() {
        var player  = player_manager.get_player();
        util.removeLastPath();
        util.addPath(player.player_name, '/teamsetup/player/?player_id=' + player_id)
        $("#player_name").html(player.player_name);
        document.title = player.player_name + ' | Syner.gg';
        $("#summary").children().not(":first").not("#buttonpanel").remove();
        $("#summary").append(
    '<div class="stat">Top Laners: ' + player.champions["Top Lane"].length + '</div>' + 
    '<div class="stat">Junglers: ' + player.champions["Jungle"].length + '</div>' + 
    '<div class="stat">Mid Laners: ' + player.champions["Mid Lane"].length + '</div>' + 
    '<div class="stat">AD Carries: ' + player.champions["AD Carry"].length + '</div>' + 
    '<div class="stat">Supports: ' + player.champions["Support"].length + '</div>');
        pri.fillLane(player_manager.get_player().champions["Top Lane"], "top_laners", "Top Lane");
        pri.fillLane(player_manager.get_player().champions["Jungle"], "junglers", "Jungle");
        pri.fillLane(player_manager.get_player().champions["Mid Lane"], "mid_laners", "Mid Lane");
        pri.fillLane(player_manager.get_player().champions["AD Carry"], "adcs", "AD Carry");
        pri.fillLane(player_manager.get_player().champions["Support"], "supports", "Support");
    };

    pri.fillLane = function(champions, lane_id, role) {
        champions.sort(function(a, b) {
            if (a.champ_name < b.champ_name) {
                return -1;
            } else if (a.champ_name > b.champ_name) {
                return 1;
            }
            return 0;
        });
        $("#" + lane_id).children().not(':last').remove()
        for (champion_index = 0; champion_index < champions.length; champion_index++) {
            var champion = champions[champion_index];
            $("#add_" + lane_id).before('<div class="listbox-item">' +
                                            '<img src="' + champion.champ_img + '" class="listbox-item-image"/>' + 
                                            '<img src="/assets/images/trash.png" class="listbox-item-delete delete-' + lane_id + '" id="delete_' + champion.champ_id + '"/>' +
                                            '<a class="image-link">' + champion.champ_name + '</a>' +
                                        '</div>');
        }

        $(".delete-" + lane_id).click(function() {
            var champ_id = $(this)[0].id.substring(7)
            player_manager.remove_champion(player_id, champ_id, role, function() {
                pub.reloadPlayer();
                pub.refreshChampionList();
            });
        });
    }

    pri.fillChampionList = function(champion_list) {
        $("#champion_list").html("");
        for (champ_index = 0; champ_index < champion_list.length; champ_index++) {
            var champion = champion_list[champ_index];
            var extra_flag = "listbox-button listbox-item-not-added"
            if (player_manager.get_player_champ_ids(pri.adding_to_role).indexOf(champion.champ_id) != -1) {
                extra_flag = "listbox-item-greyed"
            }
            else if(pri.added_champions.indexOf(champion.champ_id) != -1) {
                extra_flag = "listbox-button listbox-item-added";
            }
            $("#champion_list").append('<div class="listbox-item ' + extra_flag + '" id="' + champion.champ_id + '">' +
                                            '<img src="' + champion.champ_img + '" class="listbox-item-image"/>' +
                                            '<a class="image-link">' + champion.champ_name + '</a>' +
                                        '</div>');
        }
        $("#champion_list .listbox-button").click(function() {
            var champ_id = $(this)[0].id;
            var champ_index = pri.added_champions.indexOf(champ_id);
            if(champ_index == -1) {
                $(this).removeClass("listbox-item-not-added");
                $(this).addClass("listbox-item-added");
                pri.added_champions.push(champ_id);
            } else {
                $(this).addClass("listbox-item-not-added");
                $(this).removeClass("listbox-item-added");
                pri.added_champions.splice(champ_index, 1);
            }
        });
    };

    pub.show_rename_player = function() {
        $("#rename").show();
    }
    pub.hide_rename_player = function() {
        $("#rename").hide();
        $("#player_renamebox").val('');
    }
    return pub;
}());

