$(document).ready(function() {
    util.addPath('Composition Builder', '/builder/');
    util.addPath('--', '--');
    page.refreshCompTypes();

    $(".enemy-overview").click(function() {
        var number = $(this)[0].id.split("-")[1];
        page.show_champion_select(number);
    })

    $(".comp-type select").change(function() {
        var id = $(this)[0].id.split("-");
        var role = id[2].replace("L", " L").replace("C", " C");
        var number = id[3];
        var new_id = $(this).val()
        if(new_id == "unpicked") {
            new_id = "null"
        }
        session_manager.setcompid(session_id, role, new_id, number, page.refreshSession);
    })

    $("#rename_session").click(function() {
        var new_name = prompt("Enter a new name for this session.", "");
        if(new_name != "") {
            session_manager.rename(session_id, new_name, page.refreshSession);
        }
    });

    $("#end_session").click(function() {
        if(confirm("Are you sure you want to end this session?")) {
            session_manager.end(session_id, function() {
                document.location.href="/builder/";
            });
        }
    })


    $(".starter .button").click(function() {
        if($(this).hasClass("remove-starter")) {
            var id = $(this)[0].id.split("-");
            var role = id[1].replace("L", " L").replace("C", " C");
            var number = id[2];
            session_manager.setstarterid(session_id, role, "null", number, page.refreshSession);
        } else {
            var id = $(this)[0].id.split("-");
            var role = id[1].replace("L", " L").replace("C", " C");
            var number = id[2];
            page.show_starter_select(role, number);
        }
    });

    page.refreshChampionList();
    page.refreshStarterList();
    page.hide_starter_select();
    page.hide_champion_select();
    $("#champselect .popup-close").click(function() {page.hide_champion_select()});
    $("#starterselect .popup-close").click(function() {page.hide_starter_select()});
    $("#champ_searchbox").watermark('Search for a champion', {className: 'text-entry-watermark', useNative: false});
    $(".popup-shader").click(function() {
        page.hide_champion_select();
        page.hide_starter_select();
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

    setInterval(page.refreshSession, 2000);
});


var page = (function() {
    var pub = {}
    var pri = {}

    pri.adding_to_number = 1;
    pri.adding_to_role = "";
    pri.added_champion = "null";

    pri.added_starter = 0;

    pub.show_starter_select = function(role, number) {
        pri.adding_to_number = number;
        pri.adding_to_role = role;
        pub.refreshStarterList();
        $("#starterselect").show();
    }

    pub.hide_starter_select = function() {
        $("#starterselect").hide();
    }

    pub.show_champion_select = function(number) {
        pri.adding_to_number = number;
        pub.refreshChampionList();
        $("#champselect").show();
    }

    pub.hide_champion_select = function() {
        $("#champselect").hide();
    }

    pub.add_champion = function() {
        session_manager.setenemychampid(session_id, pri.added_champion, pri.adding_to_number, function() {
            pub.refreshSession();
            pub.hide_champion_select();
        });
    }

    pub.add_starter = function() {
        session_manager.setstarterid(session_id, pri.adding_to_role, pri.added_starter, pri.adding_to_number, function() {
            pub.refreshSession();
            pub.hide_starter_select();
        });
    }

    pub.refreshSession = function() {
        session_manager.retrieve(session_id, pri.refillSession);
    }

    pub.refreshCompTypes = function() {
        comp_type_manager.retrieve_all(pri.refillCompTypes);
    }

    pub.refreshChampionList = function() {
        var search_text = $("#champ_searchbox").val();
        champion_manager.retrieve_all(function(){pri.fillChampionList(champion_manager.search_champions(search_text))});
    }

    pub.refreshStarterList = function() {
        player_manager.retrieve_all(pri.fillStarterList);
    }

    pri.fillChampionList = function(champion_list) {
        $("#champion_list").html("");
        $("#champion_list").append('<div class="listbox-item listbox-button" id="null">' +
                                        '<img src="/assets/images/unknown.png" class="listbox-item-image"/>' +
                                        '<a class="image-link">Not picked</a>' +
                                    '</div>');
        for (champ_index = 0; champ_index < champion_list.length; champ_index++) {
            var champion = champion_list[champ_index];
            $("#champion_list").append('<div class="listbox-item listbox-button" id="' + champion.champ_id + '">' +
                                            '<img src="' + champion.champ_img + '" class="listbox-item-image"/>' +
                                            '<a class="image-link">' + champion.champ_name + '</a>' +
                                        '</div>');
        }
        $("#champion_list .listbox-button").click(function() {
            var champ_id = $(this)[0].id;
            pri.added_champion = champ_id;
            pub.add_champion();
        });
    }

    pri.fillStarterList = function() {
        $("#starter_list").html("");
        var starter_list = player_manager.get_players();
        for (var starter_index = 0; starter_index < starter_list.length; starter_index++) {
            var starter = starter_list[starter_index];
            $("#starter_list").append('<div class="listbox-item listbox-button" id="' + starter.player_id + '">' +
                                            '<a>' + starter.player_name + '</a>' +
                                        '</div>');
        }
        $("#starter_list .listbox-button").click(function() {
            var starter_id = $(this)[0].id;
            pri.added_starter = starter_id;
            pub.add_starter();
        });
    }

    pri.refillCompTypes = function() {
        $(".comp-type select").html('');
        $(".comp-type select").append('<option value="unpicked">---</option>');
        var comp_types = comp_type_manager.get_comp_types();
        for(var comp_type_index = 0; comp_type_index < comp_types.length; comp_type_index++) {
            var comp_type = comp_types[comp_type_index];
            $(".comp-type select").append('<option value=' + comp_type.comp_id + '>' + comp_type.comp_type + '</option>');
        }
        pub.refreshSession();
    }

    pri.refillSession = function() {
        pri.refillName();
        pri.refillLane("TopLane", "Top Lane");
        pri.refillLane("Jungle", "Jungle");
        pri.refillLane("MidLane", "Mid Lane");
        pri.refillLane("ADCarry", "AD Carry");
        pri.refillLane("Support", "Support");
        pri.refillEnemies();
        // pri.refillBans();
    }

    pri.refillName = function() {
        util.removeLastPath();
        util.addPath(session_manager.get_session().session_name, '/builder/session/?session_id=' + session_id);
    }

    pri.refillLane = function(classlane, role) {
        $("#pick-image-" + classlane).attr('src', session_manager.get_session().picked_champions[role].champ_img);
        var player_name = session_manager.get_session().picked_players[role].player_name;
        if(player_name == "") {
            var player_name = "&nbsp;";
        }
        $("#pick-starter-name-" + classlane).html(player_name);
        $("#pick-name-" + classlane).html(session_manager.get_session().picked_champions[role].champ_name);
        for(var starter_index = 0; starter_index < 5; starter_index++) {
            var starter = session_manager.get_session().starters[role][starter_index];
            $("#starter-"+classlane+'-'+(starter_index+1)).html(starter.player_name);
            if(starter.is_valid) {
                $("#sbutton-"+classlane+'-'+(starter_index+1)).addClass('remove-starter').addClass('button-bad').removeClass('add-starter').html('X');
            } else {
                $("#sbutton-"+classlane+'-'+(starter_index+1)).removeClass('remove-starter').removeClass('button-bad').addClass('add-starter').html('(+) Add');
            }
        }

        for(var comp_type_index = 0; comp_type_index < 3; comp_type_index++) {
            var comp_type = session_manager.get_session().comp_types[role][comp_type_index];
            if(comp_type.is_valid) {
                $("#comp-type-" + classlane + "-" + (comp_type_index+1)).val(comp_type.comp_id);
            }
        }
        $('#search-' + classlane).each(function() {
           var elem = $(this);

           // Save current value of element
           elem.data('oldVal', elem.val());

           // Look for changes in the value
           elem.bind("propertychange change click keyup input paste", function(event){
              // If value has changed...
              if (elem.data('oldVal') != elem.val()) {
               // Updated stored value
               elem.data('oldVal', elem.val());

               pri.refillLane(classlane, role);
             }
           });
         });

        $("#pick-results-" + classlane).html('');
        var champ_list = session_manager.get_champ_list($("#search-" + classlane).val(), role);
        var champ_count = (champ_list.length > 4 ? 4 : champ_list.length);
        for(var champ_index = 0; champ_index < champ_count; champ_index++) {
            var champion = champ_list[champ_index];
            var cttext = pri.get_champ_relevant_comp_types(champion.comp_types, role);
            var startersText = "";
            for(var starter_index = 0; starter_index < champion.starters.length; starter_index++) {
                var starter = champion.starters[starter_index];
                startersText += '<div class="button pick-starter" id="pick-TopLane-' + starter.player_id + '-' + champion.champ_id + '">' + starter.player_name + '</div>';
            }
            $("#pick-results-" + classlane).append(
            '<div class="pick-result clearfix">' +
                '<div class="pick-result-image">' +
                '<div class="pick-result-name">' + champion.champ_name + '</div><img src="' + champion.champ_img + '" /></div>' +
                '<div class="pick-result-comp-types">' + cttext +
                '</div>' +
                '<div class="pick-result-starters">' +
                    '<div class="pick-result-starters-title">Starters</div>' + startersText +
                '</div>' +
            '</div>');
        }
        $(".pick-starter").click(function() {
            var id = $(this)[0].id.split("-");
            var role = id[1].replace("L", " L").replace("C", " C");
            var starter_id = id[2];
            var champ_id = id[3];
            session_manager.setpickedchampid(session_id, role, champ_id, pub.refreshSession);
            session_manager.setpickedplayerid(session_id, role, starter_id, pub.refreshSession);
        })
    }

    pri.get_champ_relevant_comp_types = function(comp_types, role) {
        var cttext = ""
        for(var comp_type_index = 0; comp_type_index < 3; comp_type_index++) {
            var comp_type = session_manager.get_session().comp_types[role][comp_type_index];
            if(comp_type.is_valid) {
                for(var ct_champ_index = 0; ct_champ_index < comp_types.length; ct_champ_index++) {
                    var ct_champ = comp_types[ct_champ_index];
                    if(ct_champ[0].comp_id == comp_type.comp_id) {
                        cttext += '<div class="pick-result-comp-type">' + ct_champ[0].comp_type + ': ' + ct_champ[1] + '</div>';
                    }
                }
            }
        }
        return cttext;
    }

    pri.refillEnemies = function() {
        for(var enemyindex = 0; enemyindex < 5; enemyindex++) {
            var enemychampion = session_manager.get_session().enemy_champions[enemyindex];
            var enemy_comp_types = pri.get_top_comp_types(enemychampion);
            $("#enemy-" + (enemyindex+1) + "-name").html(enemychampion.champ_name);
            $("#enemy-" + (enemyindex+1) + "-image").attr('src', enemychampion.champ_img);
            $("#enemy-comp-types-" + (enemyindex+1)).html('')
            for(var comp_type_index = 0; comp_type_index < enemy_comp_types.length; comp_type_index++) {
                $("#enemy-comp-types-" + (enemyindex+1)).append('<div class="enemy-comp-type">' +
                    enemy_comp_types[comp_type_index][0].comp_type + ': ' + enemy_comp_types[comp_type_index][1] + '</div>');
            }
        }
    }

    pri.get_top_comp_types = function(champion) {
        var comp_types = []
        if(champion.is_valid) {
            comp_types = champion.comp_types;
            comp_types.sort(function(a, b) {
                return b[1]-a[1];
            });
            comp_types = comp_types.slice(0, 3);
        }
        return comp_types;
    }

    return pub;
}());

