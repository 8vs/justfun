<?php

$user = $_SESSION['user_id'];

$result = mysql_query('SELECT * FROM services');

?>

<div class="body-block" >

    <?php if (! isset($result)): ?>
        <div>
            Пока здесь ничего нет.
        </div>
    <?php else: ?>

    <div id="left">

        <form id="item_services">

            <h4>Выбери нужные услуги</h4>

            <?php

            while ($row = mysql_fetch_array($result)): ?>

                <div>
                    <label>
                        <input type="checkbox" name="serv[<?= $row['serviceid']; ?>]" value="<?= ceil($row['amount']); ?>"/> <?= $row['title']; ?> <span> (<?= ceil($row['amount']); ?> руб) </span>
                    </label>
                </div>


            <?php endwhile; ?>

            <h4>Выберите количество аниматоров</h4>

	        <?php
            $phantom = mysql_query('SELECT * FROM price');

	        while ($row = mysql_fetch_array($phantom)): ?>

                <div>
                    <label><input type="radio" name="anim" value="<?= ceil($row['amount']); ?>"/> <?= $row['title']; ?>
                    </label>
                </div>

	        <?php endwhile; ?>

            <h4>Выберите дату и время</h4>
            <div>
                <label>
                    <input type="datetime-local" class="form-control" name="date">
                </label>
            </div>

            <h4>Напишите место</h4>
            <div>
                <label>
                    <input type="text" class="form-control" name="place">
                </label>
            </div>

            <p>Сумма заказа: <span id="val">0</span></p>



            <div class="captcha" style="">

                <div class="captcha__image-reload">
                    <div class="form-group">
                        <img class="captcha__image" src="/assets/php/captcha.php" width="132" alt="captcha">
                        <button type="button" class="captcha__refresh">↺</button>
                    </div>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="captcha" id="captcha" placeholder="Введите код с картинки">
                </div>

            </div>

            <button type="submit" name="submit" id="submit" class="btn btn-info btn-block">Сделать заказ</button>
        </form>

        <hr>

        <div id="result"></div>

    </div>


    <?php endif; ?>

</div>
<script>

    const refreshCaptcha = (target) => {
        const captchaImage = target.closest('.captcha__image-reload').querySelector('.captcha__image');
        captchaImage.src = '/assets/php/captcha.php?r=' + new Date().getUTCMilliseconds();
    }

    const captchaBtn = document.querySelector('.captcha__refresh');
    captchaBtn.addEventListener('click', (e) => refreshCaptcha(e.target));

    let form = $('#item_services');
    let obj = $('#result');

    obj.css('display', 'none');

    $(function () {
        form.on('submit', function (e) {
            obj.css('display', 'block');
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '/controllers/api/user_cart.php',
                data: $('form').serialize(),
                dataType: 'json',
                success: function (result)
                {
                    let { status, content } = result;

                    obj.css('border', status ? '2px solid blue' : '2px solid red');

                    console.log(content);
                    obj.text(content);
                }
            });

        });

    });

    form.change(function() {
        let totalPrice = 0;
        let values = [];

        $('input[type=checkbox], input[type=radio]').each(function() {
            let isset = $(this).is(':checked');
            let current = $(this).val();
            if (isset) {
                values.push(current);
                totalPrice += parseInt(current);
            }
        });

        $('#val').text(totalPrice);
    });
</script>