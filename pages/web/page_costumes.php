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

<div class="body-block">
<div class="container marketing">
	<table>
        <figure class="sagestim-lonials">
            <?php
            $result = mysql_query('SELECT * FROM costums');
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
</div>