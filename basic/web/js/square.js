$(function () {
    var conn = new WebSocket('ws://localhost:8080/echo');

    conn.onmessage = function (e) {
        console.log(e.data);
    };

    conn.onopen = function (e) {
        conn.send('Hello Me!');
    };

    $('.dragElement').draggable({
        containment: "parent",

        start: function (event, ui) {
            var Startpos = $(this).position();
            $("div#start").text("Start: \nLeft: "+ Startpos.left + "\nTop: " + Startpos.top);
        },

        stop: function (event, ui) {
            var Stoppos = $(this).position();
            $("div#stop").text("Stop: \nLeft: "+ Stoppos.left + "\nTop: " + Stoppos.top);
        }
    });
});