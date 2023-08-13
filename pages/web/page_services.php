<script type = "text/javascript" src = "https://www.gstatic.com/charts/loader.js"> </script>
<script type = "text/javascript"> 
	google.charts.load('current', {packages: ['corechart']});  
	google.charts.setOnLoadCallback(drawChart);
</script>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script> 

<?php
	$connect = new PDO("mysql:host=localhost;dbname=justfun", "root", "");
	$query = "SELECT categoty_name FROM category_serv";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
?>

<div class="body-block">
    <div class="container marketing">
        <br>

        <div class="form-group">
            <label for="selectCategory" name="category">Выберите категорию для генерации прайс-листа:</label>
            <select class="form-control" id="selectCategory">
                <option value="3-6 лет">3-6 лет</option>
                <option value="7-10 лет">7-10 лет</option>
                <option value="11-15 лет">11-15 лет</option>
                <option value="Для любых возрастов">Для любых возрастов</option>
            </select>
        </div>


		<button class="btn btn-info" onclick="getResult()">Сгенерировать прайс-лист</button>
        <br><br>
		
		<?php
		$result = mysql_query('SELECT * FROM services, category_serv WHERE services.categoryid = category_serv.categoryid ');

		while ($row = mysql_fetch_array($result)): ?>
			<div class="row featurette">
				<div class="col-md-7">
					<h2 class="featurette-heading">
						<?= $row['title']; ?> (<?= $row['categoty_name'] ?>)
						<span class="text-muted">Стоимость: <?= $row['amount']; ?></span>
					</h2>
					<p class="lead"><?= $row['description_serv']; ?></p>
				</div>
				<div class="col-md-5">
					<img src="assets/images/services/<?= $row['serviceid']; ?>.jpg" alt="photo_<?= $row['serviceid'];?>" width="370" >
				</div>
			</div>
			
			<hr class="featurette-divider">
		<?php endwhile; ?>
	</div>
</div>

<script>
    const state = []

    let modifyState = []

    function getResult() {
        if (! modifyState.length) {
            modifyState = state.filter(({categoryService}) => categoryService === '3-6 лет').map(x => Object.values(x));
        }

        console.log(['Категория', 'Название', 'Цена'], modifyState)

        window.open('/controllers/graphic/workers_pdf.php?meta='+encodeURIComponent(JSON.stringify({
            keys: [['Название', 'Категория','Цена']],
            values: modifyState
        })), '_blank').focus();

    }

    $(document).ready(function ()
    {
        $('.featurette-heading').map((_, e) => {
            let current = $(e)[0].innerText
            let [nameService, next] = current.split(' (')
            let [preNext, sumService] = next.split(': ')
            let [categoryService] = preNext.split(')')

            state.push({
                nameService,
                categoryService,
                sumService
            })
        })

        $('#selectCategory').change(function () {
            let current = $(this).val();
            modifyState = state.filter(({categoryService}) => categoryService === current).map(x => Object.values(x));
        })
    })

</script>