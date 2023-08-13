<?php

$user = $_SESSION['user_id'];

?>

<p> </p>

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
    </form>
</div>

