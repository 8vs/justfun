<?php

$user = $_SESSION['user_id'];

?>

<div>
    <div class="d-flex justify-content-center">
        <h5>Мои заказы <span id="my_count" class="badge badge-info">0</span></h5>
    </div>
    <div id="my_orders"></div>

    <div class="d-flex justify-content-center">
        <h5>Свободные заказы <span id="other_count" class="badge badge-info">0</span></h5>
    </div>
    <div id="other_orders"></div>
</div>



<script>
	/* Так как таблицы идентичные по полям, мы сделаем общий массив названий полей */
	const column = [
        '№ заказа',
        'Дата и время',
        'Адрес',
		'Заказчик',
		'Номер клиента'
    ];

	/* Функция генерирующая таблицу по данным из API */
	function createTable(headers, data, my = true)
	{
        data = data.filter(x => {
            let item = new Date(x['date_ord']).getTime();
            let current = new Date().getTime();
            return item >= current;
        });

        /* Отрисовка количества заказов для каждой таблицы */
        if (my) $('#my_count').text(data.length);
        else $('#other_count').text(data.length);

        if (Object.keys(data).length === 0) {
            return '<p>Список пуст.</p>';
		}

        let cols = headers;
        let headerRow = '';
        let bodyRows = '';

        cols.map(function(col) {
            headerRow += '<th>' + col + '</th>';
        });

        headerRow += '<th>Действие</th>';

        /* Можно сделать валидацию по дате здесь data.filter(x => x...) */
        data.map(function(row) {
            bodyRows += `<tr>`;

			bodyRows += `
				<td>${ row['orderid'] }</td>
				<td>${ row['date_ord'] } ${ row['time'] }</td>
				<td>${ row['place'] }</td>
				<td>${ row['name'] }</td>
				<td>${ row['phone'] }</td>
			`;

            bodyRows += `
			<td>
				<button
                    type="button"
                    class="${ my
                        ? 'btn btn-danger' : 'btn btn-success'}"
                    onclick="${ my
                ? `dontTake(${ row['orderid'] });`
                : `take(${ row['orderid'] });`}"
                >${ my
                    ? 'Отказаться'
                    : 'Взять' }
                </button>
			</td>`;

            bodyRows += '</tr>';
        });

        return `<table class="table table-striped"><thead><tr>${headerRow}</tr></thead><tbody>${bodyRows}</tbody></table>`;
	}

    /* Функция отправки запросов к API + callback */
    function getAPI(url, doneCallback, method = 'GET', data = {}) {
        const query = {
            url,
            dataType: 'json',
            success: doneCallback
		};

        if (method === 'POST') {
            Object.assign(query, { data, method });
        }

        $.ajax(query);
	}

    /* Взятие заказа */
    function take(id) {
        getAPI(
            '/controllers/api/employ_reverse_post.php',
            function (result) {
                let { status } = result;
                if (status) {
                    alert('Заказ успешно взят в обработку.');
                    reloadOrders();
                } else {
                    alert('Не удалось взять заказ в обработку.');
                }
            },
			'POST', {
                type: 'take',
                orderid: id
            }
		);
	}

    /* Отказ от заказа */
    function dontTake(id) {
        getAPI(
            '/controllers/api/employ_reverse_post.php',
            function (result) {
                let { status } = result;
                if (status) {
                    alert('Успешно отказались от заказа.');
                    reloadOrders();
				} else {
                    alert('Не удалось отказаться от заказа.');
				}
            },
            'POST', {
                type: 'dontTake',
                orderid: id
            }
        );
    }

    /* Функция подгрузки заказов (вызывается при загрузке страницы, а так же после действий в таблице) */
    function reloadOrders()
    {
        $('#my_orders').text('Загрузка...');
        $('#other_orders').text('Загрузка...');

        /* Подгрузка моих заказов */
        getAPI('/controllers/api/employ_reverse_get.php?orders=my', function (result) {
            let { status, content } = result;
            if (status) {
                let table = createTable(column, content, true);
                $('#my_orders').html(table);
            } else {
                $('#my_orders').text('Не удалось получить данные.');
            }
        });

        /* Подгрузка свободных заказов */
        getAPI('/controllers/api/employ_reverse_get.php?orders=other', function (result) {
            let { status, content } = result;
            if (status) {
                let table = createTable(column, content, false);
                $('#other_orders').html(table);
            } else {
                $('#other_orders').text('Не удалось получить данные.');
            }
        });
	}

    /* Ожидание загрузки страницы, после идет вызов функции ajax-запросов */
    $(document).ready(function() {
        reloadOrders();
    });
</script>