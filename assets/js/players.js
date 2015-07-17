$( document ).ready(function() {
   $("#add_player").click(function() {
        var player_name = prompt("Enter a name for this new player.", "");
        if(player_name != null) {
            $.ajax({
                        type: "POST",
                        url: "scripts/editplayer.php",
                        data: {method: "new", player_name: player_name},
                        success: function(){    
                            location.reload();   
                        }
                     });
        }
   });
});