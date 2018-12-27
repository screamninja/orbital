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
                // в случае ошибки
                error: function () {
                    alert('Error');
                }
            });

            // отправляем AJAX-запрос с помощью метода jQuery
            $.ajax({
                url: '/ajax/watch',
                type: 'POST',
                // в случае успеха
                success: function (json, status) {
                    // преобразуем полученные данные в массив
                    var parsed = JSON.parse(json);
                    var arr = [];
                    for (var x in parsed) {
                        arr.push(parsed[x]);
                    }
                    // проверяем получена ли мы команда "не двигаться"
                    if (arr['0'] !== 'X') {
                        // проверяем был ли создан элемент ранее
                        if (!document.getElementById('notDragElement')) {
                            // добавляем элемент на страницу
                            var container = document.getElementById('container');
                            container.insertAdjacentHTML(
                                'beforeend',
                                '<div id="notDragElement"><div id="username">' + arr[1] + '</div></div>'
                            );
                        }
                        // задаём элементу координаты полученные с сервера
                        document.getElementById('notDragElement');
                        $(document).ready(function () {
                            $("#notDragElement").offset(function (i, val) {
                                return {left:arr[2], top:arr[3]}
                            });
                        })
                    }
                },
            });

        }
    })
});
