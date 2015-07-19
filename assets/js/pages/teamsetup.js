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

    $("#champ_comp_types .popup-close").click(function() {
        page.hide_champ_comp_types();
    });

    $("#champ_comp_types .popup-confirm").click(function() {
        page.update_champ_comp_types();
    });

    page.refreshChampionList();
    page.refreshPlayerList();
    page.refreshCompTypeList();
    page.show_tab("tab_players");
    page.hide_champ_comp_types();
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
        $(".tab").removeClass("tab-current");
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

    pri.fillPlayerList = function() {
        $("#player_list").children().not(":last").remove();
        for (player_index = 0; player_index < player_manager.get_players().length; player_index++) {
            player = player_manager.get_players()[player_index];
            $("#player_list").append('<a class="clearfix" href="/teamsetup/player/?player_id=' + player.player_id + '"><div class="listbox-row">' +
    '<div class="player_name">' + player.player_name + '</div>' + 
    '<div class="lanes">' +
        '<div class="lane top-lane">' +
            '<div class="header3">Top Laners</div>' +
            '<div class="number">' + player.champions["Top Lane"].length + '</div>' +
        '</div>' +
        '<div class="lane jungle">' +
            '<div class="header3">Junglers</div>' +
            '<div class="number">' + player.champions["Jungle"].length + '</div>' +
        '</div>' +
        '<div class="lane mid-lane">' +
            '<div class="header3">Mid Laners</div>' +
            '<div class="number">' + player.champions["Mid Lane"].length + '</div>' +
        '</div>' +
        '<div class="lane adc">' +
            '<div class="header3">AD Carries</div>' +
            '<div class="number">' + player.champions["AD Carry"].length + '</div>' +
        '</div>' +
        '<div class="lane support">' +
            '<div class="header3">Supports</div>' +
            '<div class="number">' + player.champions["Support"].length + '</div>' +
        '</div>' +
    '</div>' +
'</div></a>');

        }
    };

    pri.fillChampionList = function() {
        for (champ_index = 0; champ_index < champion_manager.get_champions().length; champ_index++) {
            champion = champion_manager.get_champions()[champ_index];
            $("#champion_list").append('<div class="listbox-item listbox-button" id="' + champion.champ_id + '">' +
                                            '<img src="' + champion.champ_img + '" class="listbox-item-image"/>' +
                                            '<a>' + champion.champ_name + '</a>' +
                                        '</div>');
        }
        $("#champion_list .listbox-button").click(function() {
            pub.show_champ_comp_types($(this)[0].id);
        });
    };

    pri.fillCompTypeList = function() {
        $("#comp_type_list").children().not(":last").remove();
        for (comp_type_index = 0; comp_type_index < comp_type_manager.get_comp_types().length; comp_type_index++) {
            comp_type = comp_type_manager.get_comp_types()[comp_type_index];
            $("#add_comp_type").before('<div class="listbox-item">' +
                                            '<a>' + 
                                                comp_type.comp_type + 
                                            '</a>' +
                                        '</div>');
        }
    };

    pri.champ_id = 0;
    pri.comp_type_changes = {};

    pub.refreshChampion = function() {
        champion_manager.retrieve(pri.champ_id, pri.fillChampionCompTypes);
    }

    pub.show_champ_comp_types = function(champ_id) {
        $("#champ_comp_types").show();
        pri.champ_id = champ_id;
        pri.comp_type_changes = [];
        pub.refreshChampion();
    }

    pub.hide_champ_comp_types = function() {
        $("#champ_comp_types").hide();
    }

    pub.update_champ_comp_types = function() {
        for (var comp_id in pri.comp_type_changes) {
          if (pri.comp_type_changes.hasOwnProperty(comp_id)) {
            champion_manager.update_strength(pri.champ_id, comp_id, pri.comp_type_changes[comp_id], null);
          }
        }
        pub.hide_champ_comp_types();
    }

    pri.fillChampionCompTypes = function() {
        var champion = champion_manager.get_champion();
        $("#champ_comp_types .popup-title").html(champion.champ_name);
        $("#champ_comp_types .popup-titleimage").attr('src', champion.champ_img);
        $("#comp_types").html('');
        for (champ_comp_type_index = 0; champ_comp_type_index < champion.comp_types.length; champ_comp_type_index++) {
            var comp_type = champion.comp_types[champ_comp_type_index]
            $("#comp_types").append('<div class="listbox-divider clearfix" id="comp-type'+comp_type[0].comp_id+'">' +
                                        '<div class="comp-label"><a>' + comp_type[0].comp_type + '</a></div>' +
                                        '<div class="strength_selector">' +
                                            '<div class="listbox-item listbox-button"><a class="S">S</a></div>' +
                                            '<div class="listbox-item listbox-button"><a class="A">A</a></div>' +
                                            '<div class="listbox-item listbox-button"><a class="B">B</a></div>' +
                                            '<div class="listbox-item listbox-button"><a class="C">C</a></div>' +
                                            '<div class="listbox-item listbox-button"><a class="D">D</a></div>' +
                                        '</div>' +
                                    '</div>');
            $("#comp-type" + comp_type[0].comp_id + " ." + comp_type[1]).parent().addClass("listbox-button-active");
            $("#comp-type" + comp_type[0].comp_id + " .listbox-button").click(function() {
                if($(this).hasClass("listbox-button-active") == false) {
                    var new_strength = $(this).children().html();
                    pri.comp_type_changes[comp_type[0].comp_id] = new_strength;
                    $(this).parent().find('.listbox-button-active').removeClass('listbox-button-active');
                    $(this).addClass("listbox-button-active");
                }
            });
        }
    };

    return pub;
}());