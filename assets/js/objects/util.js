var util = (function() {
    var pub = {}
    var pri = {} 

    pub.addPath = function(text, link) {
        $("#path").append('<div class="spacer">&gt;</div><a href="' + link + '">' + text + '</a>');
    }

    pub.removeLastPath = function() {
        $("#path").children().last().remove();
        $("#path").children().last().remove();
    }

    return pub;
}());