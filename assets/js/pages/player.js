$( document ).ready(function() {
    page.reloadPlayer();
});

var page = (function() {
    var pub = {}
    var pri = {}

    pub.reloadPlayer = function() {
        player_manager.retrieve(player_id, pri.fillPlayer);
    }

    pri.fillPlayer = function(player) {
        $("#player_name").html(player.player_name);
        alert(JSON.stringify(player))
        for (lane_index = 0; lane_index < player.champions.length; lane_index++) {
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

    return pub;
}());