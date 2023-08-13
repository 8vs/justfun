<script type = "text/javascript" src = "https://www.gstatic.com/charts/loader.js"> </script>
<script type = "text/javascript"> 
	google.charts.load('current', {packages: ['corechart']});  
	google.charts.setOnLoadCallback(drawChart);
</script>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<script type="text/javascript">
    function createOptions(data) {
        if (data.length === 0) {
            return '<p>Список рассылок пуст.</p>';
        }

        let options = '';

        data.map(({ employid, name }) => {
            options += `<option value="${name}">${name}</option>`;
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


    function createTable(data, headers = null, tableId)
    {
        if (Object.keys(data).length === 0)
        {
            return '<p>Список пуст.</p>';
        }

        let cols = Object.keys(data[0]);
        let customHeaders = headers || cols;

        let headerRow = '';
        let bodyRows = '';

        customHeaders.map(function(col) {
            headerRow += '<th>' + col + '</th>';
        });

        // headerRow += '<th>Действие</th>';

        data.map(function(row) {
            bodyRows += `<tr>`;

            cols.map(function(colName) {
                console.log()
                bodyRows += `<td>${row[colName].length ? row[colName] : 'Пусто'}</td>`;
            });

            // bodyRows += `
            // <td data-full='${JSON.stringify(row)}'>
            //     <button data-toggle="modal" data-target="#modalEditTables" type="button" data-type="edit" class="btn btn-success">✏️</button>
            //     <button data-toggle="modal" data-target="#modalEditTables" type="button" data-type="delete" class="btn btn-danger">❌</button>
            // </td>`;

            bodyRows += '</tr>';
        });

        return `<table class="table table-striped" id="${tableId}">
                    <thead>
                        <tr>${headerRow}</tr>
                    </thead>
                    <tbody>
                        ${bodyRows}
                    </tbody
                </table>`;
    }


    function preload() {
        getAPI('/controllers/api/statistik_list.php?method=groupByAnimators', function (data) {
            const { status, content } = data;
            if (status) {
                let optionsList = createOptions(content);
                $('#groupByAnimatorsSelector').append(optionsList);
                // console.log(content);
                let table = createTable(content, ['ID', 'Имя', 'Заказы'], 'tableGroupByAnimators');
                $('#groupByAnimators').append(table);

                $("#selectPrevOrders").val('01').change().val('-1').change();
            }
        })
    }

    function getResult(type) {
        let amount = 0;
        let table = 'body';
        const keys = [];
        const values = [];

        if (type === 'group') {
            table = '#tableGroupByAnimators'
        }

        else if (type === 'prev_orders') {
            table = '#prev_orders';
            amount = state.amount;

        } else if (type === 'post_orders') {
            table = '#post_orders';
            amount = state.amount;
        }

        $(`${table } > thead > tr:visible`).map((_, e) => keys.push(e.innerText.split(`\t`)));
        $(`${table } > tbody > tr:visible`).map((_, e) => values.push(e.innerText.split(`\t`)));

        console.log(values);

        window.open('/controllers/graphic/workers_pdf.php?meta='+encodeURIComponent(JSON.stringify({
            keys,
            values,
            amount
        })), '_blank').focus();
    }

    const state = {
        amount: 0
    }

    $(document).ready(function () {
        preload()

        $("#selectPostOrders").val('02').change().val('-1').change();

        $('#groupByAnimatorsSelector').change(function ()
        {
            let current = $(this).val();
            $('#groupByAnimators tbody tr').show();

            if (current !== '-1') {
                $(`#groupByAnimators tbody tr:not(:contains("${current}"))`).hide();
            }
        });

        $('#selectPrevOrders').change(function ()
        {
            let val = $(this).val();
            let current = `2022-${ val }-`;

            $('#prev_orders').show();
            $('#prev_orders tbody tr').show();

            if (val !== '-1') {
                $(`#prev_orders tbody tr:not(:contains("${current}"))`).hide();
            }

            let counters = $('#prev_orders tbody tr:visible #prev_orders_tr_counters');
            let desk = 0, result;

            counters.map((_, el) => desk += +$(el).text());

            if (counters.length) {
                result = `Общая прибыль по предстоящим заказам: ${desk}`;
                state.amount = desk;
                result += `<br><br><button class="btn btn-info" onclick="getResult('prev_orders')">Создать отчет</button>`;
            } else {
                $('#prev_orders').hide();
                result = 'В этом месяце не было заказов.';
            }

            $('#prev_orders_itog').html(result);
        })

        // --------------------------------------------------- //

        $('#selectPostOrders').change(function ()
        {
            let val = $(this).val();
            let current = `2022-${ val }-`;

            $('#post_orders tbody tr').show();
            $('#post_orders').show();

            if (val !== '-1') {
                $(`#post_orders tbody tr:not(:contains("${current}"))`).hide();
            }

            let counters = $('#post_orders tbody tr:visible #post_orders_tr_counters');
            let desk = 0, result;

            counters.map((_, el) => desk += +$(el).text());

            if (counters.length) {
                result = `Общая прибыль по завершенным заказам: ${desk}`;
                state.amount = desk;
                result += `<br><br><button class="btn btn-info" onclick="getResult('post_orders')">Создать отчет</button>`;
            } else {

                $('#post_orders').hide();
                result = 'В этом месяце не было заказов.';
            }

            $('#post_orders_itog').html(result);
        })
    });

</script>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Предстоящие заказы</a>
        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Завершённые заказы</a>
<!--        <a class="nav-item nav-link" id="nav-anim-tab" data-toggle="tab" href="#nav-anim" role="tab" aria-controls="nav-anim" aria-selected="false">Итоги с группировкой по аниматорам</a>-->
<!--        <a class="nav-item nav-link" id="nav-usl-tab" data-toggle="tab" href="#nav-usl" role="tab" aria-controls="nav-usl" aria-selected="false">Итоги с группировкой по услугам</a>-->
    </div>
</nav>

<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active mb-auto" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

        <br>

        <div class="form-group">
            <label for="selectPrevOrders">Выберите конкретный месяц:</label>
            <select class="form-control" id="selectPrevOrders">
                <option value="-1">Все месяцы</option>
                <option value="01">Январь</option>
                <option value="02">Февраль</option>
                <option value="03">Март</option>
                <option value="04">Апрель</option>
                <option value="05">Май</option>
                <option value="06">Июнь</option>
                <option value="07">Июль</option>
                <option value="08">Август</option>
                <option value="09">Сентябрь</option>
                <option value="10">Октябрь</option>
                <option value="11">Ноябрь</option>
                <option value="12">Декабрь</option>
            </select>
        </div>

        <table class="table table-striped" id="prev_orders" >


        <?php
		
		$connect = new PDO("mysql:host=localhost;dbname=justfun", "root", "");
		$query = "SELECT year(date_ord) FROM orders group by year(date_ord)";
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();

        $result2 = mysql_query("select * from orders where date_ord >= CURRENT_DATE");

        echo '<thead>';
            echo '<tr>';
                echo '<th>ID</th>';
                echo '<th>Дата, время и место</th>';
                echo '<th>Услуги</th>';
                echo '<th>Аниматоры</th>';
                echo '<th>Выручка</th>';
            echo '</tr>';
        echo '</thead>';

        echo '<tbody>';

        while ($row1 = mysql_fetch_row($result2))
        {
            $sum = 0;
            $an = 0;

            echo '<tr>';

            echo '<td>' . $row1[0] .'</td>';

            echo '<td>';
            echo 'Дата: ' . $row1[2] . "<br><br>";
            echo 'Место: ' . $row1[3] . "<br><br>";
            echo "Время: <b>" . $row1[4] . "</b><br>";

            echo '</td>';

            echo '<td>';

            $result4 = mysql_query("select orders.orderid, services.title, services.amount from order_items, services, orders where orders.orderid=order_items.orderid and order_items.serviceid=services.serviceid and orders.orderid='$row1[0]'");

            $services_temp = array();
            while ($row2 = mysql_fetch_row($result4))
            {
                $services_temp[] = "$row2[1] <b>($row2[2])</b>";
                $sum += $row2[2];
            }

            echo join(", <br>", $services_temp);

            echo '</td>';
            echo '<td>';

            $result7 = mysql_query("select workers.employid from workers, orders where orders.orderid=workers.orderid and orders.orderid='$row1[0]'");

            $animatorsTemp = array();
            $animatorsFreeSlots = 0;
            while ($row5 = mysql_fetch_row($result7))
            {
                if ($row5[0] !== '0') {
                    $result9 = mysql_query("select employees.name from employees, workers where workers.employid=employees.employid and employees.employid='$row5[0]'");
                    $row3 = mysql_fetch_row($result9);

                    $animatorsTemp[] = $row3[0];
                } else {
                    $animatorsFreeSlots++;
                }

                $an += 1;
            }

            echo count($animatorsTemp) ? join(', ', $animatorsTemp) . "<br><br>" : '';
            echo $animatorsFreeSlots !== 0 ? "Свободно: <br> <b>" . $animatorsFreeSlots. "</b>" : '';

            echo '</td>';
            echo '<td>';

            $result11 = mysql_query("select amount from price where priceid='$an'");
            $row11 = mysql_fetch_row($result11);

            echo "Оплата аниматорам: <b>$row11[0]</b><br>";
            echo "Ожидаемая выручка: <b>$sum</b><br>";

            echo "Прибыль (за вычетом зарплаты аниматорам): ";
            echo "<b><span id=\"prev_orders_tr_counters\">".($sum - $row11[0])."</div></b><br>";

        }
        echo '</td>';
        echo '</tr>';

        echo '</tbody>';

        ?>

        </table>

        <h4 id="prev_orders_itog"></h4>
		<br>
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-9">
						<h4 class="panel-title">График выручки организации по месяцам</h4>
					</div>
					<div class="col-md-3">
						<select name="categorys" class="form-control" id="categorys">
							<option value="">Выберите категорию</option>
							<?php
								foreach($result as $row)
								{
									echo '<option value="'.$row["year(date_ord)"].'">'.$row["year(date_ord)"].'</option>';
								}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div id="chart_area" style="width: 1000px; height: 620px;"></div>
			</div>
		</div>
	  
		<script language = "JavaScript">
			$(document).ready(function(){

				$('#categorys').change(function(){
					var category = $(this).val();
					if(category != "")
					{
						var temp_title = 'График выручки организации по месяцам за ' + category;
						
						$.ajax({
							url:"/pages/web/fetch_adm.php",
							method:"POST",
							data:{categorys:category},
							dataType:"JSON",
							success:function(data)
							{
								var tabl = new google.visualization.DataTable();
								tabl.addColumn('string', 'Номер месяца');
								tabl.addColumn('number', 'Выручка');
								$.each(data, function(i, data){
									var title = data.title;
									var amount = data.amount;
									tabl.addRows([[title, amount]]);
								});
								var options = {'title':temp_title, 'width':650, 'height':620, hAxis: { title: "Номер месяца" }, vAxis: { title: 'Выручка' }};

								var chart = new google.visualization.LineChart(document.getElementById('chart_area'));
								chart.draw(tabl, options);
							}
						});
				
						
					}
				});

			});
		</script>

    </div>

    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

        <br>
        <div class="form-group">
            <label for="selectPostOrders">Выберите конкретный месяц:</label>
            <select class="form-control" id="selectPostOrders">
                <option value="-1">Все месяцы</option>
                <option value="01">Январь</option>
                <option value="02">Февраль</option>
                <option value="03">Март</option>
                <option value="04">Апрель</option>
                <option value="05">Май</option>
                <option value="06">Июнь</option>
                <option value="07">Июль</option>
                <option value="08">Август</option>
                <option value="09">Сентябрь</option>
                <option value="10">Октябрь</option>
                <option value="11">Ноябрь</option>
                <option value="12">Декабрь</option>
            </select>
        </div>


        <table class="table table-striped" id="post_orders" >

            <?php

            $result2 = mysql_query("select * from orders where date_ord <= CURRENT_DATE");

            echo '<thead>';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Дата, время и место</th>';
            echo '<th>Услуги</th>';
            echo '<th>Аниматоры</th>';
            echo '<th>Выручка</th>';
            echo '</tr>';
            echo '</thead>';

            echo '<tbody>';

            while ($row1 = mysql_fetch_row($result2))
            {
                $sum = 0;
                $an = 0;

                echo '<tr>';

                echo '<td>' . $row1[0] .'</td>';

                echo '<td>';
                echo 'Дата: ' . $row1[2] . "<br><br>";
                echo 'Место: ' . $row1[3] . "<br><br>";
                echo "Время: <b>" . $row1[4] . "</b><br>";

                echo '</td>';

                echo '<td>';

                $result4 = mysql_query("select orders.orderid, services.title, services.amount from order_items, services, orders where orders.orderid=order_items.orderid and order_items.serviceid=services.serviceid and orders.orderid='$row1[0]'");

                $services_temp = array();
                while ($row2 = mysql_fetch_row($result4))
                {
                    $services_temp[] = "$row2[1] <b>($row2[2])</b>";
                    $sum += $row2[2];
                }

                echo join(", <br>", $services_temp);

                echo '</td>';
                echo '<td>';

                $result7 = mysql_query("select workers.employid from workers, orders where orders.orderid=workers.orderid and orders.orderid='$row1[0]'");

                $animatorsTemp = array();
                $animatorsFreeSlots = 0;
                while ($row5 = mysql_fetch_row($result7))
                {
                    if ($row5[0] !== '0') {
                        $result9 = mysql_query("select employees.name from employees, workers where workers.employid=employees.employid and employees.employid='$row5[0]'");
                        $row3 = mysql_fetch_row($result9);

                        $animatorsTemp[] = $row3[0];
                    } else {
                        $animatorsFreeSlots++;
                    }

                    $an += 1;
                }

                echo count($animatorsTemp) ? join(', ', $animatorsTemp) . "<br><br>" : '';
                echo $animatorsFreeSlots !== 0 ? "Свободно: <br> <b>" . $animatorsFreeSlots. "</b>" : '';

                echo '</td>';
                echo '<td>';

                $result11 = mysql_query("select amount from price where priceid='$an'");
                $row11 = mysql_fetch_row($result11);

                echo "Оплата аниматорам: <b>$row11[0]</b><br>";
                echo "Ожидаемая выручка: <b>$sum</b><br>";

                echo "Прибыль (за вычетом зарплаты аниматорам): ";
                echo "<b><span id=\"post_orders_tr_counters\">".($sum - $row11[0])."</div></b><br>";

            }
            echo '</td>';
            echo '</tr>';

            echo '</tbody>';

            ?>

        </table>


        <h4 id="post_orders_itog"></h4>

    </div>

    <div class="tab-pane fade" id="nav-anim" role="tabpanel" aria-labelledby="nav-anim-tab">

        <br>

        <div class="form-group">
            <label for="groupByAnimatorsSelector">Выберите аниматора:</label>
            <select class="form-control" id="groupByAnimatorsSelector">
                <option selected value="-1">Все аниматоры</option>
            </select>
        </div>

        <div id="groupByAnimators"></div>

        <button class="btn btn-info" onclick="getResult('group')">Создать отчет</button>
    </div>


    <div class="tab-pane fade" id="nav-usl" role="tabpanel" aria-labelledby="nav-usl-tab">

        <br>

        <p>SOON</p>
        <?php


//        $result2=mysql_query("select * from services");
//
//        while ($row1 = mysql_fetch_row($result2))
//        {
//            $sum = 0;
//            $an=0;
//
//            echo 'ИД: ';
//            echo stripslashes($row1[0]);
//
//            echo '<br/> Название: ';
//            echo stripslashes($row1[1]);
//
//            $result4 = mysql_query("select order_items.orderid from order_items, orders where orders.orderid=order_items.orderid and order_items.serviceid='$row1[0]' and orders.date_ord <= CURRENT_DATE");
//
//            while ($row2 = mysql_fetch_row($result4))
//            {
//                echo '<br/> Был на заказe: ';
//                echo stripslashes($row2[0]);
//
//                $sum = $sum+1;
//            }
//
//            echo '<br/> Общее кол-во заказов: ';
//            echo $sum;
//
//            echo '<br/>';echo '<br/>';
//        }

        ?>

    </div></div>