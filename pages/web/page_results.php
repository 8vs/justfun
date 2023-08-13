<style>
	.caption-border {
    width: 300px;
    border: 4px solid #17a2b8;
    background: #F5FFFA;
    padding: 10px;
	border-radius: 8px;
}
.caption-border img {
    max-width: 100%;
    height: auto;
    margin: 10px auto 20px;
    display: block;
}
.caption-border figcaption {
    padding: 10px;
    color: #17a2b8;
    text-align: center;
    text-transform: uppercase;
}
</style>

<p> </p>

<?php

$user = $_SESSION['user_id'];

?>

<div class="body-block">
<div class="container marketing">
    <form action="results.php" method="post">
		<div class="form-group">
            <label for="subList">
                Выберите критерий поиска:
            </label>
            <select class="form-control" name="searchtype">
                <option disabled selected value> -- Сделайте выбор -- </option>
                <option value="services">По услуге</option>
                <option value="costums">По костюму</option>
                <option value="employees">По сотруднику</option>
            </select>
        </div>

        <input name="searchterm" type="text" class="form-control" placeholder="Здесь введите информацию для поиска">
        <br />
        <button type="submit" name="submit" id="submit" class="btn btn-info"> Найти </button>
		
		<p> </p>
		
		<?php
			$searchtype=$_POST['searchtype'];
			$searchterm=$_POST['searchterm'];
			
			$searchterm= trim($searchterm);

			if (!$searchtype || !$searchterm)
			{
				echo 'Вы не ввели параметры поиска. Пожалуйста, повторите ввод.';
				exit;
			}
		?>
		
		<?php if ($searchtype == 'costums'){?>
			<table>
				<figure class="sagestim-lonials">
					<?php
					$result = mysql_query("select * from costums where description_cost like '%".$searchterm."%'");
					$i = 0;

					while ($row = mysql_fetch_array($result)): ?>

						<?php if ($i > 0 and $i % 3 == 0) echo '</tr><tr>'; ?>
				
						<td>
							<figure class="caption-border">
								<img src="assets/images/costumes/<?= $row['costumeid']; ?>.jpg" alt="photo_<?= $row['costumeid'];?>">
								<figcaption> <?= $row['description_cost']; ?></figcaption>
							</figure>
						</td>

						<?php $i++; 
						
						echo '<td>'; echo '</td>'; echo '<td>'; echo '</td>'; echo '<td>'; echo '</td>';
						echo '<td>'; echo '</td>'; echo '<td>'; echo '</td>';
						echo '<td>'; echo '</td>'; echo '<td>'; echo '</td>';?>

					<?php endwhile; ?>

				</figure>
			</table>
		<?php }?>
		
		<?php if ($searchtype == 'services'){?>
			<table>
				<?php
				$result = mysql_query("select * from services where title like '%".$searchterm."%'");

				while ($row = mysql_fetch_array($result)): ?>
					<div class="row featurette">
						<div class="col-md-7">
							<h2 class="featurette-heading"> <?= $row['title']; ?> <span class="text-muted">Стоимость: <?= $row['amount']; ?></span></h2>
							<p class="lead"><?= $row['description_serv']; ?></p>
						</div>
						<div class="col-md-5">
							<img src="assets/images/services/<?= $row['serviceid']; ?>.jpg" alt="photo_<?= $row['serviceid'];?>" width="370" >
						</div>
					</div>
					
					<hr class="featurette-divider">

				<?php endwhile; ?>
			</table>
		<?php }?>
		
		<?php 
			if ($searchtype == 'employees')
			{
				$result=mysql_query("select * from employees where name like '%".$searchterm."%'");
				$i = 0;
					
				echo '<table border=0>';
					
				while ($row = mysql_fetch_row($result))
				{
					if ($i==3) { echo '<tr>'; $i=0;}
			
					echo '<td>';
						echo '<figure class="caption-border">';
							echo '<img src="assets/images/workers/'.$row[0].'.jpg">';
							echo '<figcaption> Имя: ',stripslashes($row[3]),'</figcaption>';
							echo '<figcaption> Работает с вами с ',stripslashes($row[4]),' года</figcaption>';
							echo '<figcaption> Должность: ',stripslashes($row[5]),'</figcaption>';
						echo '</figure> ';
					echo '</td>';
					
					echo '<td>'; echo '</td>'; echo '<td>'; echo '</td>'; echo '<td>'; echo '</td>';
					echo '<td>'; echo '</td>'; echo '<td>'; echo '</td>';
					echo '<td>'; echo '</td>'; echo '<td>'; echo '</td>';
						
					if ($i==3) { echo '</tr>';  }
					else{ $i=$i+1; }
				}
				echo '</table>';
			}
		?>
	</form>
</div>

