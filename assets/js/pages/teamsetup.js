$( document ).ready(function() {
    document.title = 'Team Manager | Syner.gg';
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

    $("#champ_comp_types .popup-shader").click(function() {
        page.hide_champ_comp_types();
    })

    $(window).resize(function() {
        var width = $("#comp_types .strength_selector").width();
        var first_four = Math.floor(width/5);
        var last_one = width-(first_four*4);
        $("#comp_types .strength_selector .listbox-button a").width(first_four-2).height(first_four);
        $("#comp_types .strength_selector .listbox-last a").width(last_one-7);
    });

    page.refreshChampionList();
    page.refreshPlayerList();
    page.refreshCompTypeList();
    page.show_tab("tab_players");
    page.hide_champ_comp_types();

    util.addPath('Team Manager', '/teamsetup/');
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
        if(new_name != null && new_name != "") {
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
        pri.updateSummary();
        $("#player_list").html('');
        for (player_index = 0; player_index < player_manager.get_players().length; player_index++) {
            player = player_manager.get_players()[player_index];
            $("#player_list").append('<a class="clearfix" href="/teamsetup/player/?player_id=' + player.player_id + '"><div class="listbox-row">' +
    '<div class="player_name">' + player.player_name + '</div>' + 
    '<div class="lanes">' +
        '<div class="lane top-lane">' +
            '<div class="number">' + player.champions["Top Lane"].length + '</div>' +
            '<div class="header3">Top Laners</div>' +
        '</div>' +
        '<div class="lane jungle">' +
            '<div class="number">' + player.champions["Jungle"].length + '</div>' +
            '<div class="header3">Junglers</div>' +
        '</div>' +
        '<div class="lane mid-lane">' +
            '<div class="number">' + player.champions["Mid Lane"].length + '</div>' +
            '<div class="header3">Mid Laners</div>' +
        '</div>' +
        '<div class="lane adc">' +
            '<div class="number">' + player.champions["AD Carry"].length + '</div>' +
            '<div class="header3">AD Carries</div>' +
        '</div>' +
        '<div class="lane support">' +
            '<div class="number">' + player.champions["Support"].length + '</div>' +
            '<div class="header3">Supports</div>' +
        '</div>' +
    '</div>' +
'</div></a>');

        }
    };

    pri.fillChampionList = function() {
        pri.updateSummary();
        for (champ_index = 0; champ_index < champion_manager.get_champions().length; champ_index++) {
            champion = champion_manager.get_champions()[champ_index];
            $("#champion_list").append('<div class="listbox-item listbox-button" id="' + champion.champ_id + '">' +
                                            '<img src="' + champion.champ_img + '" class="listbox-item-image"/>' +
                                            '<a class="image-link">' + champion.champ_name + '</a>' +
                                        '</div>');
        }
        $("#champion_list .listbox-button").click(function() {
            pub.show_champ_comp_types($(this)[0].id);
        });
    };

    pri.fillCompTypeList = function() {
        pri.updateSummary();
        $("#comp_type_list").html('');
        for (comp_type_index = 0; comp_type_index < comp_type_manager.get_comp_types().length; comp_type_index++) {
            comp_type = comp_type_manager.get_comp_types()[comp_type_index];
            $("#comp_type_list").append('<div class="listbox-item">' +
                                            '<a>' + 
                                                comp_type.comp_type + 
                                            '</a>' +
                                        '</div>');
        }
    };

    pri.updateSummary = function() {
        if(player_manager.get_players() == null ||
           comp_type_manager.get_comp_types() == null ||
           champion_manager.get_champions() == null ) {
            return
        }
        $("#summary").children().not(":first").remove()
        $("#summary").append(
    '<div class="stat">Roster Size: ' + player_manager.get_players().length + '</div>' +
    '<div class="stat">Composition Types: ' + comp_type_manager.get_comp_types().length + '</div>' +
    '<div class="stat">Champions: ' + champion_manager.get_champions().length + '</div>')
    }

    pri.champ_id = 0;
    pri.comp_type_changes = {};

    pub.refreshChampion = function() {
        champion_manager.retrieve(pri.champ_id, pri.fillChampionCompTypes);
    }

    pub.show_champ_comp_types = function(champ_id) {
        $("#champ_comp_types").show();
        $("#champ_comp_types").css('top', $(window).scrollTop())
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
            var strength_initial = comp_type[1]
            $("#comp_types").append(
                '<div class="comp_type" id="comp-type' + comp_type[0].comp_id + '">' +
                    '<div class="comp_type_name">' + comp_type[0].comp_type + '</div>' +
                    '<div class="comp_strength">' +
                        '<div class="grades">' +
                            '<div class="grade grade-1">1 (Weak)</div>' +
                            '<div class="grade grade-2">2</div>' +
                            '<div class="grade grade-3">3</div>' +
                            '<div class="grade grade-4">4</div>' +
                            '<div class="grade grade-5">5 (Strong)</div>' +
                        '</div>' +
                        '<div class="slider">' +
                            '<input type=range min=1 max=5 value=' + strength_initial + '/>' +
                        '</div>' +
                    '</div>' +
                '</div>');

            $("#comp-type" + comp_type[0].comp_id + " .slider input").val(strength_initial);
            $("#comp-type" + comp_type[0].comp_id + " .grade-" + comp_type[1]).addClass("grade-selected");
            $("#comp-type" + comp_type[0].comp_id + " .slider input").on("change mousemove", function() {
                $(this).parent().parent().find('.grade').removeClass('grade-selected')
                var new_strength = $(this).val();
                var comp_id = $(this).parent().parent().parent()[0].id.substring(9)
                pri.comp_type_changes[comp_id] = new_strength;
                $(this).parent().parent().find('.grade-' + new_strength).addClass('grade-selected')
            });
        }
        $(window).resize();
    };

    return pub;
}());