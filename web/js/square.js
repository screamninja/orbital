$(function () {
    $('.dragElement').draggable({
        // ограничиваем перемещение границами родителя
        containment: "parent",

        stop: function (event, ui) {
            // получаем имя пользователя
            var username = document.getElementById('username').textContent;
            // получаем позицию элемента после перетягивания
            var stopPos = $(this).position();
            // формируем строку данных для передачи серверу через AJAX
            var data = "username=" + username + "&" + "left=" + stopPos.left + "&" + "top=" + stopPos.top;
            // отправляем данные AJAX-запросом с помощью метода jQuery
            $.ajax({
                url: '/ajax/move',
                type: 'POST',
                data: data,
                error: function () {
                    alert('Error');
                }
            });

            // устанавливаем интервал вызова метода watch возвращающего данные для просмотра других пользователей
            var timerID = setInterval(function () {
                // отправляем AJAX-запрос с помощью метода jQuery
                $.ajax({
                    url: '/ajax/watch',
                    type: 'POST',
                    success: function (json, status) {
                        if (status !== 'success') {
                            alert('Error');
                            return;
                        }
                        // преобразуем полученные данные в массив
                        var parsed = JSON.parse(json);
                        var arr = [];
                        for (var x in parsed) {
                            arr.push(parsed[x]);
                        }



                        // добавляем квадрат другого пользователя
                        var container = document.getElementById('container');
                        container.insertAdjacentHTML(
                            'beforeend',
                            '<div id="notDragElement">' + arr[1] + '</div>'
                        );
                        var notDragElement = document.getElementsByClassName('notDragElement');
                        $(document).ready(function () {
                            $("#notDragElement").offset(function (i, val) {
                                return {left:arr[2], top:arr[3]}
                            });
                        })
                    },
                    error: function () {
                        alert('Error');
                    },
                });
            }, 1000);
            // устанавливаем таймер прекращающий выполнение вызова метода watch
            setTimeout(function () {
                clearInterval(timerID);
            }, 2000);
        }
    })
});
