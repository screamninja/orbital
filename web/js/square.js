$(function () {
    $('.dragElement').draggable({
        // ограничиваем перемещение границами родителя
        containment: "parent",

        stop: function (event, ui) {
            // получаем имя пользователя
            var username = document.getElementById('username').textContent;
            // получаем позицию элемента после перетягивания
            var Stoppos = $(this).position();
            // формируем строку данных для передачи серверу через AJAX
            var data = "username=" + username + "&" + "left=" + Stoppos.left + "&" + "top=" + Stoppos.top;
            // отправляем данные AJAX-запросом с помощью метода jQuery
            $.ajax({
                url: '/ajax/move',
                type: 'POST',
                data: data,
                error: function () {
                    alert('Error!');
                }
            });

            // var ask = "who's there="
            //
            // $.ajax({
            //     url: '/ajax/watch',
            //     type: 'POST',
            //     data: ask,
            //     error: function () {
            //         alert('Error!');
            //     }
            // });
        }
    })
});
