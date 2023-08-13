<?php

$user = $_SESSION['user_id'];

?>

<div class="modal fade" id="modalEditTables" tabindex="-1" role="dialog" aria-labelledby="modalEditTablesTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditTablesTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modal__body" class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" id="modal_button" class="btn btn-info"></button>
            </div>
        </div>
    </div>
</div>


<div class="form-group">
    <label for="select_table">Выберите таблицу:</label>
    <select class="form-control" id="select_table">
        <option disabled selected value> -- Сделайте выбор -- </option>
    </select>
</div>



<div id="loading" style="display: none;">
    <img src="../assets/images/loading.gif" alt="load"></div>
<div id="control-block"></div>



<script>

    /* Непоколебимый state */
    const stateModal = {
        table: null,
        tableFields: [],
        item: {},
        type: null
    };

    /* Функция отправки запросов к API + callback */
    function getAPI(url, doneCallback, method = 'GET', data = {}) {
        const query = {
            url,
            dataType: 'json',
            beforeSend: function() {
                $('#loading').show();
                $('#control-block').hide();
            },
            success: doneCallback,
            error: function () {
                alert('Неизвестная ошибка при загрузке данных.');
            },
            complete: function () {
                $('#loading').hide();
                $('#control-block').show();
            }
        };

        if (method === 'POST') {
            Object.assign(query, { data, method });
        }

        $.ajax(query);
    }

    /* Функция для заполнения option в выпадающем списке */
    function createOptions(data) {
        if (data.length === 0) {
            return '<p>Список сущностей пуст.</p>';
        }

        let options = '';

        data.map(item => {
            options += `<option value="${item}">${item}</option>`;
        });

        return options;
    }

    /* Функция генерирующая таблицу по данным из API */
    function createTable(headers = null, data)
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

        data.map(function(row) {
            bodyRows += `<tr>`;

            cols.map(function(colName) {
                bodyRows += '<td>' + row[colName] + '</td>';
            });

            bodyRows += `
			<td data-full='${JSON.stringify(row)}'>
                <button data-toggle="modal" data-target="#modalEditTables" type="button" data-type="edit" class="btn btn-success">✏️</button>
                <button data-toggle="modal" data-target="#modalEditTables" type="button" data-type="delete" class="btn btn-danger">❌</button>
			</td>`;

            bodyRows += '</tr>';
        });

        return `<table class="table table-striped">
                    <thead>
                        <tr>${headerRow}</tr>
                    </thead>
                    <tbody>
                        ${bodyRows}
                    </tbody
                </table>`;
    }

    const stack = {
        edit: ['Редактирование', 'Сохранить'],
        add: ['Добавление', 'Добавить'],
        delete: ['Удаление', 'Подтвердить'],
        none: ['Информация', 'Ознакомился']
    }

    $('#modalEditTables').on('show.bs.modal', e =>
    {
        const $button = $(e.relatedTarget);
        const btn = $button.closest('td')[0] || $button.closest('div')[0] ;

        const data = JSON.parse(btn.dataset.full);
        const type = $button[0].dataset.type;
        const [modal_title, modal_button] = stack[type] ? stack[type] : stack['none'];

        $('.modal-body').html(`
            <form>${ generateForm(type, data) }</form>
        `)

        $('.modal-title').html(modal_title);


        $('#modal_button').html(modal_button)

    });

    function generateForm(type, data) {
        let text = ``;

        if (Array.isArray(data) && type === 'add')
        {
            data.map((item, index) => {
                let {field, extra} = item; // {field: 44, extra: 434}
                text += `
                <div class="form-group">
                    <label for="fields_${index}">${field}</label>
                    <input type="text" class="form-control" ${extra ? 'disabled' : null} id="fields_${index}" placeholder="Введите ${field}">
                </div>`;

            }).join('');
        } else {
            if (type === 'delete') {
                let object = Object.entries(data)
                object.map((item, index) => {
                    let [key, value] = item; // [324423, 4332423]
                    text += `
                   <div class="form-group">
                    <label for="fields_${index}">${key}</label>
                    <input type="text" class="form-control" disabled id="fields_${index}" placeholder="${value}">
                </div>`;
                })
            } else {
				let object = Object.entries(data)
                object.map((item, index) => {
                    let [key, value] = item; // [324423, 4332423]
					console.log(item);
                    text += `
                   <div class="form-group">
                    <label for="fields_${index}">${key}</label>
                    <input type="text" class="form-control" id="fields_${index}" placeholder="${value}">
                </div>`;
                })
				
			}
        }

        return text;
    }

    function reload(tableName) {
        if (tableName === undefined) {
            tableName = stateModal.table;
        }

        /* Подгрузка колонок нашей текущей таблицы */
        getAPI('/controllers/api/admin_control_get.php?show=column&tableName=' + tableName, function (result) {
            let {status, content} = result;
            if (status) {
                /* Сохраняем названия полей в state */
                stateModal.tableFields = content;
            }
        });

        getAPI('/controllers/api/admin_control_get.php?show=values&tableName=' + tableName, function (result) {
            let {status, content} = result;
            if (status) {

                /* Заполняем таблицу */
                let tbl = createTable(null, content);

                console.log(content)

                let addButton = `<div data-full='${JSON.stringify(stateModal.tableFields)}'>

    <button data-toggle="modal" data-target="#modalEditTables" type="button" data-type="add" class="btn btn-info" >Добавить запись</button>
</div>`;
                $('#control-block').html(`<br>${addButton} <br><br> ${tbl}`);

            } else {
                $('#tables').text('Не удалось загрузить информацию.');
            }
        });
    }

    /* Callback при загрузку страницы */
    $(document).ready(function ()
    {
        /* Подгрузка названий сущностей в выпадающий список */
        getAPI('/controllers/api/admin_control_get.php?show=tables', function (result) {
            let {status, content} = result;
            if (status) {
                /* Заполняем выпадающий список */
                let list = createOptions(content);
                $('#select_table').append(list);
            } else {
                $('#tables').html('<p>Не удалось загрузить информацию.</p>');
            }
        });

        /* ---------------- Модальное окно ---------------- */
        $('.popup-close, .popup-fade').click(function(e)
        {
            if ($(e.target).closest('.popup').length === 0) {
                stateModal.item = {};
                stateModal.type = null;
                $(this).fadeOut();
            }

            $(this).parents('.popup-fade').fadeOut();
            return false;
        });
        /* ----------------------------------------------- */

    });

    /* Отслеживаем событие */
    $('#select_table').change(function () {
        /* Заносим информацию о таблице в state */
        stateModal.table = $(this).val();
        reload();
    });
</script>