<?php
include('database_connections.php');
require_once("session.php");
require_once('class.post.php');
require_once("class.user.php");

$auth_user = new USER();
$user_id = $_SESSION['user_session'] ?? null;

if (!$user_id) {
    // Not logged in, redirect or show error
    header('Location: login.php');
    exit;
}

// Fetch user info securely
$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id = :user_id");
$stmt->execute([':user_id' => $user_id]);
$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

// Sum likes of user's posts securely
$sql30 = $auth_user->runQuery("SELECT likes FROM post_table WHERE poster_id = :user_id");
$sql30->execute([':user_id' => $user_id]);
$count_likes = 0;
while ($reactors = $sql30->fetch(PDO::FETCH_ASSOC)) {
    $count_likes += (int)$reactors['likes'];
}

// Top 3 posts by likes
$stmts = $auth_user->runQuery("SELECT * FROM post_table ORDER BY likes DESC LIMIT 3");

// Handle share post
if (isset($_POST['share'])) {
    $post_content = $_POST['post_content'] ?? '';
    $post_id = $_POST['id'] ?? 0;

    $stmtis = $auth_user->runQuery("SELECT * FROM post_table WHERE post_id = :post_id");
    $stmtis->execute([':post_id' => $post_id]);
    $usrRow = $stmtis->fetch(PDO::FETCH_ASSOC);

    if (!$usrRow) {
        echo "Post not found.";
        exit;
    }

    $share_this = $usrRow['post_content'];
    $poster_id = $usrRow['poster_id'];

    switch ($usrRow['contains']) {
        case 'txt':
            // no change
            break;
        case 'img':
            $share_this = '<img id="img_' . htmlspecialchars($post_id) . '" ' . $share_this;
            break;
        case 'vid':
            $share_this = '<center><video id="vid_' . htmlspecialchars($post_id) . '" ' . $share_this . '<br>';
            break;
        default:
            $share_this = 'There was error trying to get this post content. Try again';
            break;
    }

    // Fetch poster user info
    $stms = $auth_user->runQuery("SELECT * FROM users WHERE user_id = :his");
    $stms->execute([':his' => $poster_id]);
    $uRow = $stms->fetch(PDO::FETCH_ASSOC);

    $him = '<a href="Posts.php#' . htmlspecialchars($post_id) . '">' . htmlspecialchars($uRow['user_firstname'] . ' ' . $uRow['user_lastname']) . '</a>';

    $sharer_id = $user_id;

    if ($auth_user->share($sharer_id, $post_id, $poster_id, $post_content)) {
        $postObj = new POST();
        $poster_id = $user_id;

        $content = $post_content . '<div class="sharing" id="shared_' . htmlspecialchars($post_id) . '">'
            . '<img class="image1" src="./upload/' . htmlspecialchars($poster_id) . '.jpg" alt="X" width="30" height="30">'
            . $him . '<br><br>' . $share_this . '</div>';

        if ($postObj->store($poster_id, $content)) {
            // Insert notification using PDO prepared statement
            $notifStmt = $auth_user->runQuery("INSERT INTO notifications (action, post_id, from_user_id, to_user_id, status) VALUES ('share', :post_id, :from_user_id, :to_user_id, 1)");
            $notifStmt->execute([
                ':post_id' => $post_id,
                ':from_user_id' => $poster_id,
                ':to_user_id' => $poster_id
            ]);
            $auth_user->redirect('Posts.php');
            exit;
        } else {
            echo "<div class='alert alert-danger'>Error! Could not post, try again.</div>";
        }
    }
}

// Handle like action (switch to PDO)
if (isset($_POST['like'])) {
    $post_id = $_POST['post_id'] ?? 0;

    $stmtLike = $auth_user->runQuery("SELECT likes FROM post_table WHERE post_id = :post_id");
    $stmtLike->execute([':post_id' => $post_id]);
    $row_posts = $stmtLike->fetch(PDO::FETCH_ASSOC);

    if ($row_posts) {
        $n = (int)$row_posts['likes'];

        // Insert reaction
        $stmtInsertReaction = $auth_user->runQuery("INSERT INTO reactions (poster_id, post_id) VALUES (:poster_id, :post_id)");
        $stmtInsertReaction->execute([
            ':poster_id' => $user_id,
            ':post_id' => $post_id
        ]);

        // Update likes count
        $stmtUpdateLikes = $auth_user->runQuery("UPDATE post_table SET likes = :likes WHERE post_id = :post_id");
        $stmtUpdateLikes->execute([
            ':likes' => $n + 1,
            ':post_id' => $post_id
        ]);

        echo $n + 1;
    } else {
        echo "Invalid post_id";
    }
    exit();
}

// Handle edit action (switch to PDO)
if (isset($_POST['edit'])) {
    $post_id = $_POST['post_id'] ?? 0;
    $edited = 'I have edited this';

    $stmtEdit = $auth_user->runQuery("UPDATE post_table SET post_content = :post_content WHERE post_id = :post_id");
    $stmtEdit->execute([
        ':post_content' => $edited,
        ':post_id' => $post_id
    ]);
    $auth_user->redirect('Posts.php');
    exit();
}

// TODO: Implement hide and report

include_once('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="icon" sizes="192x192" href="winett.png" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="maincss.css" />
<script src="./js/jquery.js" type="text/javascript"></script>
<script src="./js/bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="scriptz.js"></script>
<title>Posts</title>
</head>
<body>
<div class="my_panel">
    <?php include_once('mainheader.php'); ?>
    <div class="col-md-12">
        <div class="col-md-3">
            <!-- Optional left sidebar content -->
        </div>
        <div class="col-md-5" style="padding-right:6px; padding-left:6px;">
            <br />
            <div class="post_box">
                <?php include_once('makepost.php'); ?>
            </div>
            <?php
                $current_timestamp1 = strtotime(date("Y-m-d H:i:s") . '- 10 second');
                $current_timestamp = date('Y-m-d H:i:s', $current_timestamp1);
            ?>
            <div class="post_area" id="thesetags">
                <?php include_once('indes.php'); ?>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Optional right sidebar -->
        </div>
    </div>
</div>

<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="./boot/jquery-1.12.4.js"></script>

<script>
$(document).on('click', '.usertags', function(){
    var usertag = $(this).data('usertag');
    $.ajax({
        url: "usertags.php",
        method: "POST",
        data: { usertag: usertag },
        success: function(data) {
            $('#thesetags').html(data);
        }
    });
});

function myToggleFunction(x) {
    x.classList.toggle("fa-heart");
}

function myToggleFunctionMale(x) {
    x.classList.toggle("fa-male");
}

$(document).ready(function(){
    $(document).on('focus', '.for_comments', function(){
        var id_com = $(this).data('forthis');
        $.ajax({
            url: "fetch_comments.php",
            method: "POST",
            data: { id: id_com },
            success: function(data) {
                $('#comment_' + id_com).html(data);
            }
        });
        setInterval(function(){
            $('#comment_' + id_com).load('fetch_comments.php').fadeIn('slow');
        }, 1000);
    });
});

$(document).ready(function(){
    // Modal popup for images
    $('.post_image').on('click', function(){
        var my_id = $(this).attr('id');
        var modal = document.getElementById('modal_' + my_id);
        var img = document.getElementById(my_id);
        var modalImg = document.getElementById("image_" + my_id);
        var captionText = document.getElementById("caption_" + my_id);

        if (!modal || !img || !modalImg || !captionText) return;

        modal.style.display = "block";
        modalImg.src = img.src;
        modalImg.alt = img.alt;
        captionText.innerHTML = img.alt;

        var span = modal.querySelector(".close");
        if(span) {
            span.onclick = function() {
                modal.style.display = "none";
            }
        }
    });
});

$(document).ready(function(){
    var id = $(this).val();
    fetch_note();
    setInterval(function(){
        fetch_note();
        showLike(id);
    }, 5000);

    $(document).on('click', '.btn6', function(){
        $.ajax({
            type: "POST",
            url: "Posts.php",
            success: function(data){
                $('.my_panel').html(data);
            }
        });
    });

    $(document).on('click', '.like', function(){
        var id = $(this).val();
        var $this = $(this);
        $this.toggleClass('like');

        $.ajax({
            url: 'Posts.php',
            type: 'POST',
            data: { post_id: id, like: true },
            success: function(data) {
                $this.html(data);
            }
        });
    });
});

function fetch_note() {
    $.ajax({
        url: "notifycount.php",
        method: "POST",
        success: function(data) {
            $('#notifycount').html(data);
        }
    });
}

function showLike(id) {
    $.ajax({
        url: "notifyLike.php",
        method: "POST",
        data: { id: id },
        success: function(data) {
            $('#notifylike').html(data);
        }
    });
}
</script>

</body>
</html>
