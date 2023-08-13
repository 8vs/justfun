<style>
	.reviews-block {
    border: 2px solid #17a2b8;
	border-radius: 8px;
    margin: 20px;
	background: #F5FFFA;
}

.reviews-block > div.item {
    color: #4794c3;
    padding: 10px;
}

.reviews-block > div.item > p {
    text-align: left;
	font-size: 17px;
	font-style: italic;
	font-weight: 500;
    word-wrap: break-word;
}

.reviews-img {
    height: 40px;
    text-align: left;
    border-radius: 50%;
}

.span {
    color: #17a2b8;
}

    .child_active {
        border-right: none;
        padding-right: 0;
        margin-right: 0;
    }

    .card-body {
        padding-right: 0!important;
        margin-right: 0!important;
    }

    .marketing {
        padding-top: 25px;
    }

    span {
        float: right;
        padding-right: 10px;
    }
</style>

<div class="modal fade" id="modalEditTables" tabindex="-1" role="dialog" aria-labelledby="modalEditTablesTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditTablesTitle">Список лайкнувших</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modal__body" class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal" aria-label="Close">Закрыть</button>
            </div>
        </div>
    </div>
</div>


<?php

global $result;
$query = mysql_query("SELECT comment.date_comment, customers.name, comment.comment_id, comment.author_id, comment.text, comment.com_parent FROM customers, comment WHERE customers.customerid = comment.author_id and comment.com_parent='0';");
$user = $_SESSION['user_id'];


function getComment($row, $childActive = false)
{
	global $user;

    /*
<div class="card">
  <h5 class="card-header">Featured</h5>
  <div class="card-body">

  </div>
</div>
     */

    $isChild = $childActive ? 'child_active mt-4' : 'mb-4';

	echo '<div class="card '.$isChild.'">';

    $i = 0;
    $is_like = false;
    $likes = mysql_query("SELECT * FROM likes WHERE comment_id=".$row['comment_id']);

    while ($like = mysql_fetch_array($likes)):
        $i++;
        if ($like['customerid'] === $user) $is_like = true;
    endwhile;

    echo '<h5 class="card-header">'. $row['name'] .'</h5>';
    // echo "<img src=\"../../assets/images/otz.jpg\" class=\"reviews-img\" alt=\"otz\">";

    echo '<div class="card-body">';

        echo '<p class="card-text">'. $row['text'] .'</p>';

        $ilike = $is_like ? 'danger' : 'default';
        $method = $is_like ? 'un_like' : 'add_like';

        $buttonLike = isset($user) ? "<button type=\"button\" onclick=\"$method($row[comment_id], this);\" class=\"btn btn-$ilike\">$i</button>" : "<button disabled type=\"button\" onclick=\"$method($row[comment_id], this);\" class=\"btn btn-$ilike\">$i</button>";
        $buttonReply = isset($user) ? "<a href=\"#\" class=\"btn btn-default reply\" id=\"".$row['comment_id']."\" > Ответить </a>" : "";
        //     <button data-toggle="modal" data-target="#modalEditTables" type="button" data-type="add" class="btn btn-info" >Добавить запись</button>
		echo "$buttonLike <button onclick=\"showLikes($row[comment_id])\" data-toggle=\"modal\" data-target=\"#modalEditTables\" class=\"btn btn-default\">❤</button> $buttonReply<span>".date('d M Y в H:i', strtotime($row['date_comment']))."</span>";

        $query = mysql_query("SELECT comment.date_comment, customers.name, comment.comment_id, comment.author_id, comment.text, comment.com_parent FROM customers, comment WHERE customers.customerid = comment.author_id and comment.com_parent=".$row['comment_id']);

        if (mysql_num_rows($query) > 0)  {
            while ($row = mysql_fetch_array($query)) getComment($row, true);
        }



    echo '</div>';
				
    echo "</div>";
}

?>

<?php if (isset($user) && $_SESSION['role'] === 1): ?>
    <div class="container marketing">
        <form id="comment-form" action="" method="post">

            <div class="input-group mb-3">
                <input type="text" name="text" class="form-control" placeholder="Введите сообщение">
                <input type="hidden" name="com_parent" value="0"/>
                <div class="input-group-append">
                    <button type="submit" name="submit" id="submit" class="btn btn-info">Отправить</button>
                </div>
            </div>

            <?php if (! empty($result)) echo '<div class="alert alert-info" role="alert">'.$result.'</div>'; ?>

        </form>
    </div>
<?php else: ?>

<div class="container marketing">
    <p><?= (isset($user)) ? 'Нет доступа для оставления сообщения.' : 'Чтобы оставить сообщение, пожалуйста, авторизируйтесь.'?></p>
</div>
<?php endif; ?>

<div class="container marketing">

        <?php while ($row = mysql_fetch_array($query)):

            getComment($row);
			
		endwhile; ?>


<script>

    /* Функция отправки запросов к API + callback */
    function getAPI(url, doneCallback, method = 'GET', data = {}) {
        const query = {
            url,
            dataType: 'json',
            beforeОтправить: function() {
                /*$('#loading').show();
                $('#control-block').hide();*/
            },
            success: doneCallback,
            error: function (done) {
                if (done.status === 400 && done.responseJSON) {
                    // let {content} = done;
                    alert(done.responseJSON.content);
                }
            },
            complete: function () {
                /*$('#loading').hide();
                $('#control-block').show();*/
            }
        };

        if (method === 'POST') {
            Object.assign(query, { data, method });
        }

        $.ajax(query);
    }

    function add_like(id, x)
    {
        getAPI('/controllers/comment.php', function(done) {
            let current = +$(x).text();

            $(x)
                .attr("onclick",`un_like(${id}, this)`)
                .text((current + 1).toString())
                .removeClass('btn-default').addClass('btn-danger');


        }, 'POST', {
            like: true,
            method: 'add',
            comment_id: id
        });
    }

    function un_like(id, x)
    {
        getAPI('/controllers/comment.php', function(done) {
            let current = +$(x).text();

            $(x)
                .attr("onclick",`add_like(${id}, this)`)
                .text((current - 1).toString())
                .removeClass('btn-danger').addClass('btn-default');

        }, 'POST', {
            like: true,
            method: 'un',
            comment_id: id
        })
    }
	
	function showLikes(comment_id) {
	
		  getAPI('/controllers/likes.php', function(done) {
			  let {status, content } = done;
			  
			  if (status) 
			  {
				  let list = '';
				  
					if (content.length === 0) {
						list = `Список пуст`;
					} else {
						list = content.join('<br>');
					}
					
					$('#modal__body').html(list);
			  }
		  }, 'POST', { comment_id });
	}

    const replies = document.querySelectorAll('a.reply');
    const subClass = '--reply-true';
    for (let i = 0; i < replies.length; i++) {
        replies[i].addEventListener('click', function() {


            let current = $(this);
            let id = current.attr('id');
            let form_id = "#comment-form-" + id;

            if (current.parent().hasClass(subClass)) {
                $(form_id).remove();
                current.parent().removeClass(subClass);
            } else {
                current.parent().addClass(subClass);
                current.parent().append(
                    `
                     <form id="comment-form-${id}" action="" method="post">
                        <div class="input-group mb-3 pt-4">
                          <input type="text" name="text" class="form-control" placeholder="Введите сообщение">
                            <input type="hidden" name="com_parent" value="${id}"/>
                          <div class="input-group-append">
                            <button type="submit" name="submit" id="submit" class="btn btn-info">Отправить</button>
                          </div>
                        </div>
                    </form>
            `);
            }

        });
    }


</script>

