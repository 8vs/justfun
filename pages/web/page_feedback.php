<?php

require __DIR__ . '\\..\..\controllers\feedback.php';

global $result;

$user = $_SESSION['user_id'];
$query = mysql_query("SELECT * FROM feedbacks WHERE customerid = '$user'");

?>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Вопросы и ответы</a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Мои подписки</a>
    </div>
</nav>


<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active mb-auto" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">


        <form method="post" action="" class="pt-lg-4">
			<?php if (! empty($result)) echo '<div id="result">'. $result .'</div>'; ?>

            <div class="form-group">
                <label for="question"></label>
                <input type="text" class="form-control" id="question" name="question" placeholder="Здесь введите ваш вопрос">
            </div>

            <button type="submit" name="submit" id="submit" class="btn btn-info">Задать вопрос</button>
        </form>



		<?php while ($row = mysql_fetch_array($query)): ?>
            <div class="media text-muted pt-3">
                <p class="media-body">
                    <strong class="d-block text-gray-dark"><?= $row['quastion']; ?></strong>
                    — <?= $row['answer']; ?>
                </p>
            </div>
		<?php endwhile; ?>
    </div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div id="list_sub"></div>
    </div>
</div>

<script type="text/javascript">
    /* Функция отправки запросов к API + callback */
    function getAPI(url, doneCallback, method = 'GET', data = {}) {
        const query = {
            url,
            dataType: 'json',
            beforeSend: function() {
                $('#list_sub').empty()
            },
            success: doneCallback,
            error: function () {
                alert('Неизвестная ошибка при загрузке данных.');
            },
            complete: function () {

            }
        };

        if (method === 'POST') {
            Object.assign(query, { data, method });
        }

        $.ajax(query);
    }

    function createTable(headers = null, data, props = null)
    {
        if (Object.keys(data).length === 0) {
            return '<p>Список пуст.</p>';
        }

        let cols = headers || Object.keys(data[0]);
        let headerRow = '';
        let bodyRows = '';

        cols.map(function(col) {
            headerRow += '<th>' + col + '</th>';
        });

        headerRow += '<th>Действие</th>';

        data.map(function({name_rss,id_rss, sub }) {
            bodyRows += `<tr>`;

            bodyRows += '<td>' + name_rss + '</td>';

            bodyRows += `<td>
                               ${ sub
                                    ? `<button type="button" onclick="unSub(${ id_rss })" class="btn btn-danger btn-block">Отписаться</button>`
                                    : `<button type="button" onclick="sub(${ id_rss })" class="btn btn-success btn-block">Подписаться</button>`
                                }
                        </td>
                    `;

            bodyRows += '</tr>';
        });

        return `<table class="table table-striped"><thead><tr>${headerRow}</tr></thead><tbody>${bodyRows}</tbody></table>`;
    }

    function unSub(id) {
        getAPI('/controllers/api/rss_sub.php', function ({ status }) {
            if (status) preload();
        }, 'POST', {
            method: 'delete',
            id
        })
    }

    function sub(id) {
        getAPI('/controllers/api/rss_sub.php', function ({ status }) {
            if (status) preload();
        }, 'POST', {
            method: 'add',
            id
        })
    }

    function preload() {
        getAPI('/controllers/api/rss_list.php?my', function (data) {
            const { status, content } = data;

            if (status) {
                const desk = createTable([
                    'Название подписки'
                ], content);

                $('#list_sub').append(desk);
            }
        })
    }


    $(document).ready(function() {
        preload();
    })


</script>

