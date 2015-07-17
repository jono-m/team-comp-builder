$( document ).ready(function() {
    $(".tab").click(function() {
        page.show_tab($(this)[0].id);
    });
    $("#add_player").click(function() {
        page.add_player();
    });
    $("#add_comp_type").click(function() {
        page.add_comp_type();
    });

    page.refreshChampionList();
    page.refreshPlayerList();
    page.refreshCompTypeList();
    page.show_tab("tab_players");
});

var page = (function() {
    var pub = {}
    var pri = {}

    pub.refreshPlayerList = function() {
        player_manager.retrieve_all(pri.fillPlayerList);
    }

    pub.refreshChampionList = function() {
        champion_manager.retrieve_all(pri.fillChampionList);
    }

    pub.refreshCompTypeList = function() {
        comp_type_manager.retrieve_all(pri.fillCompTypeList);
    }

    pub.show_tab = function(tab) {
        $(".tabpage").hide();
        $(".tabpage").removeClass("tab-current");
        if(tab == "tab_players") {
            $("#tabpage_players").show();
        }
        else if(tab == "tab_comp_types") {
            $("#tabpage_comp_types").show();
        }
        else if(tab == "tab_champions") {
            $("#tabpage_champions").show();
        }
        $("#" + tab).addClass("tab-current");
    }

    pub.add_player = function() {
        var new_name = prompt("Enter the name of the new player.", "");
        if(new_name != null) {
            player_manager.new(new_name, page.refreshPlayerList);
        }
    }

    pub.add_comp_type = function() {
        var new_comp_type = prompt("Enter the name of the new composition type.", "");
        if(new_comp_type != null) {
            comp_type_manager.new(new_comp_type, page.refreshCompTypeList);
        }
    }

    pri.fillPlayerList = function(player_list) {
        for (player_index = 0; player_index < player_list.length; player_index++) {
            player = player_list[player_index];
            $("#player_list").append('<div class="listbox-item">' + 
                                        '<a href="/teamsetup/player/?player_id=' + player.player_id + '">' +
                                            player.player_name +
                                        '</a>' +
                                      '</div>');
        }
        $("#player_list").append('<div class="listbox-item listbox-add" id="add_player"><a href="#">+</a></div>');
    };

    pri.fillChampionList = function(champion_list) {
        for (champ_index = 0; champ_index < champion_list.length; champ_index++) {
            champion = champion_list[champ_index];
            $("#champion_list").append('<div class="listbox-item">' +
                                            '<img src="' + champion.champ_img + '" class="listbox-item-image"/>' +
                                            '<a href="/teamsetup/champion/?champ_id=' + champion.champ_id + '">' + 
                                                champion.champ_name + 
                                            '</a>' +
                                        '</div>');
        }
    };

    pri.fillCompTypeList = function(comp_type_list) {
        for (comp_type_index = 0; comp_type_index < comp_type_list.length; comp_type_index++) {
            comp_type = comp_type_list[comp_type_index];
            $("#comp_type_list").append('<div class="listbox-item">' +
                                            '<a href="">' + 
                                                comp_type.comp_type + 
                                            '</a>' +
                                        '</div>');
        }
        $("#comp_type_list").append('<div class="listbox-item listbox-add" id="add_comp_type"><a href="#">+</a></div>');
    };
    return pub;
}());