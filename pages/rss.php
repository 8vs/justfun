<?php

$user = $_SESSION['user_id'];

?>

<form>

    <div class="form-group">
        <label for="subList">Выберите категорию рассылки:</label>
        <select class="form-control" id="subList">
            <option disabled selected value>  -- Сделайте выбор --  </option>
        </select>
    </div>

    <div class="form-group">
        <label for="rss_message">Введите сообщение для рассылки:</label>
        <textarea class="form-control" id="rss_message" rows="2"></textarea>
    </div>
</form>

<button type="button" onclick="send_rss()" class="btn btn-info">Сделать рассылку</button>

<script type="text/javascript">
    function createOptions(data) {
        if (data.length === 0) {
            return '<p>Список рассылок пуст.</p>';
        }

        let options = '';

        data.map(({ id_rss, name_rss }) => {
            options += `<option value="${id_rss}">${name_rss}</option>`;
        });

        return options;
    }

    /* Функция отправки запросов к API + callback */
    function getAPI(url, doneCallback, method = 'GET', data = {}) {
        const query = {
            url,
            dataType: 'json',
            beforeSend: function() {
            },
            success: doneCallback,
            error: function () {
                alert('Неизвестная ошибка при загрузке данных.');
            },
            complete: function () {
                $('#result').hide();
            }
        };

        if (method === 'POST') {
            Object.assign(query, { data, method });
        }

        $.ajax(query);
    }


    function preload() {
        getAPI('/controllers/api/rss_list.php', function (data) {
            const { status, content } = data;
            if (status) {
                let optionsList = createOptions(content);
                $('#subList').append(optionsList);
            }
        })
    }

    function send_rss()
    {
        let message = $( "#rss_message" ).val();
        let id_rss = $( "#subList" ).val();

        if (! message || ! id_rss) {
            alert('Заполните поля.');
        } else {
            getAPI('/controllers/api/admin_rss_send.php', function ({ status, content }) {
                if (status) {
                    alert('Рассылка запущена!');
                }
            }, 'POST', {
                message,
                id_rss
            })
        }
    }

    $(document).ready(function () {
        preload();
    })
</script>