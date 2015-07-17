$( document ).ready(function() {
    page.refreshChampionList();
});

var page = (function() {
    var pub = {}
    var pri = {}

    pub.refreshChampionList = function() {
        champion_manager.retrieve_all_callback = pri.fillChampionList;
        champion_list = champion_manager.retrieve_all();
    }

    pri.fillChampionList = function(champion_list) {
        for (champ_index = 0; champ_index < champion_list.length; champ_index++) {
            champion = champion_list[champ_index];
            $("#champion_list").append('<div class="listbox-item">' +
                                            '<img src="' + champion.champ_img + '" class="listbox-item-image"/>' +
                                            '<a href="champion.php?champ_id=' + champion.champ_id + '">' + 
                                                champion.champ_name + 
                                            '</a>' +
                                        '</div>');
        }
        $("#champion_list").append('<div class="listbox-item listbox-add"><a href="#">+</a></div>');
    };

    return pub;
}());