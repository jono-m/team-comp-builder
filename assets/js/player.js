$( document ).ready(function() {
   $("#rename_player").click(function() {
        var player_name = prompt("Enter a name for this new player.", "");
        if(player_name != null) {
            $.ajax({
                        type: "POST",
                        url: "scripts/editplayer.php",
                        data: {method: "rename", player_id: player_id,
                                player_name: player_name},
                        success: function(){    
                            location.reload();   
                        }
                     });
        }
   });
   $("#delete_player").click(function() {
        if(confirm("Are you sure you want to delete this player?")) {
            $.ajax({
                        type: "POST",
                        url: "scripts/editplayer.php",
                        data: {method: "delete", player_id: player_id},
                        success: function(){    
                            window.location.href = 'players.php';   
                        }
                     });
        }
   });
});