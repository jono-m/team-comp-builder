$( document ).ready(function() {
   $("#add_composition").click(function() {
        var comp_type = prompt("Enter a name for this new composition type.", "");
        if (comp_type != null) {
            $.ajax({
                        type: "POST",
                        url: "scripts/editcomptype.php",
                        data: {method: "new", comp_type: comp_type},
                        success: function(){    
                            location.reload();   
                        }
                     });
        }
   });
});