<?php 
include('database_connections.php');
include('conn.php');
session_start();

if(!isset($_SESSION['user_id']))
{ 
  header("location:logins.php");
}
  
require_once("class.user.php");
$auth_user = new USER();

$user_id = $_SESSION['user_session'];

$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
$stmt->execute(array(":user_id"=>$user_id));

$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

$stmt3 = $auth_user->runQuery("SELECT * FROM users WHERE user_id!=:user_id");
$stmt3->execute(array(":user_id"=>$user_id));

$userRow3=$stmt3->fetch(PDO::FETCH_ASSOC);

if($userRow['user_firstname']=="")
{
  header("Location: logout.php");
}
?>
<!DOCTYPE html>
<html>  
  <head>  
    <title>Winett | Messenger</title>  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="jquery.emojipicker.css">
    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="jquery.emojipicker.js"></script>
    <link rel="stylesheet" href="jquery.emojipicker.g.css">
    <script type="text/javascript" src="jquery.emojis.js"></script>
    <link rel="stylesheet" type="text/css" href="jquery.emojipicker.tw.css">
    <script type="text/javascript" src="js/jquery.emojis.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="icon" sizes="192*192" href="winett.png">
    <script type="text/javascript" src="jquery-ui.js"></script>
    <link rel="stylesheet" href="boot/jquery-ui.css">
    <script src="bootstrap.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="maincss.css"> 
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js"></script>  
    <style>
      body{background-color: #f3f1f0; padding: 0px;}
      .chat_history{ background-image: url("./images/slider1.jpg"); }
      .class2
      {
        border-radius:2px;
      }
      /* Place the container to the left */
      .left
      {
        justify-content:flex-end; 
      }

      /* Place the container to the right */
      .right {
          justify-content:flex-end; 
          padding-left: 8px; padding-right: 8px; padding-top: 3px; padding-bottom: 3px; border-top-left-radius: 15px;
          border-top-right-radius: 12px;border-bottom-left-radius: 15px;border-bottom-right-radius: 15px;  
          background-color: silver; color: black; position: relative; width: initial; padding-left: 15px;
          padding-right: 15px;left: 32px;max-width: 250px;*/
      }
      .this_modal {
          padding: 0px; max-width: 500px; max-height: 550px;
          left: 0;  top: 0; width: 100%; height: 100%;  overflow: hidden; /* Enable scroll if needed */
          background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
      }
      .mi.modal-content {
          padding: 0px; margin: 0px; background-color: transparent;  overflow: hidden;
      }
      .mi_modal-content, .mi_caption {
          -webkit-animation-name: zoom;
          -webkit-animation-duration: 0.10s;
          animation-name: zoom;
          animation-duration: 0.10s;
      }
      .mi_modal-content > .post_image{width: 100%; max-width: 500px; height: 100%; max-height: 550px; padding: 0px; margin: 0px;  overflow: hidden;}
      .closed {
          background-color: red; position: absolute; top: 40px;
          text-align: center; width: 50px; height:50px; right: 40px; color: white;
          font-size: 40px; font-weight: bold; transition: 0.6s;
      }
      .closed:hover,
      .closed:focus {
          background: white; color: red; text-decoration: none; cursor: pointer;
      }
</style>
  </head>  
  <body> 
    <div class="my__panel chat_message">
      <?php include_once('mainheader.php'); ?>
        
        <div id="group_details clearfix"></div>
        <div id="group_model_details"></div>
        <div id="user_details"></div>
        <div id="user_model_details"></div>
        <div class="ui-button-icon "> </div>
    </div>
     <script src=".boot/jquery.js" type="text/javascript"></script>
     <script src=".boot/bootstrap.js" type="text/javascript"></script>
     <script>    
$(document).ready(function(){
  fetch_user(); setInterval(function(){
    fetch_user();
    update_last_activity(); update_chat_history_data(); /*fetch_group_chat_history();*/
  },8000);
  setInterval(function(){
    update_chat_history_data();/*fetch_group_chat_history();*/
  }, 8000);

  function fetch_user()
  {
    $.ajax({
      url:"fetch_user.php",
      method:"POST",
      success:function(data){
        $('#user_details').html(data);
      }
    })
  }

  function update_last_activity()
  {
    $.ajax({
      url:"update_last_activity.php",
      method: "POST",
      success:function(){}
    })
  }

  function make_chat_dialog_box(from_user_id, to_user_id, to_display_name)
  {
    var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" style=" position:fixed; top:6%; width: 100%; max-width: 350px; width: 100vw; min-width: 320px ; max-height: 500px; background-color: grey; /*url(./images/background2.jpg*/ #user_dialog_'+to_user_id+'"><div style=" padding: 4px; background-color: #00868B; margin-left: -15px; margin-right: -15px;"><img id="image" src="./upload/'+to_user_id+'.jpg" alt="X" width="40" height="40" style="border-radius: 5px; margin-right: 10px;"><span style="font-weight: bolder; font-size: 18px; white-space: nowrap; width: 100px; overflow: hidden; text-overflow: ellipsis;">'+to_display_name+'</span><b id="online_'+to_user_id+'"> '+fetch_is_online(to_user_id)+'</b>&nbsp;<button type="button" class="ui-button-icon" style="position: absolute; top: 4px; right: 3px; height: 40px; width: 40px; background-color:red; color: white;" type="button"> X </button></div>';

    modal_content += '<div style="max-height:450px; min-height: 300px; border:1px solid #ccc; overflow-y: scroll; padding: 10px; max-width: 98vw; background-color: white; /*background-image: url(./images/slider1.jpg);*/ " class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
    modal_content += fetch_user_chat_history(to_user_id);
    modal_content += '</div>';
  
    modal_content += '<div class="form-group" style="display: inline-flex; align-items: flex-front; width: 100%; padding-top: 4px;">';
    modal_content += '<form action="chat_upload.php" method="post" enctype="multipart/form-data"><div class="upload_this_file" id="files_" style="display:none;"><input type="hidden" name="MAX_FILE_SIZE" value="409600019" /><div id="filediv"><input name="file[]" type="file" id="file"/></div></div>'
    modal_content += '<div class="form-group" style="display: inline-flex; width: 100%;">';
    /*modal_content += '<div class="live_chat" id="live_chat_'+to_user_id+'">';
    /*modal_content += fetch_live_chat(to_user_id);
    modal_content += '</div>';*/
    modal_content += '<input type="text" style="display: none;" " name="txt_to_user_id" value="'+to_user_id+'"/><textarea id="chat_message'+to_user_id+'" name="chat_message"  class="form-control chat_message" style="height: 44px;"></textarea>';
    modal_content += '<button type="button" class="files__" style="border-radius: 100%; height: 44px; width: 44px; border: none; margin-right: 5px; margin-left: 5px; background-color: #056f57; color: white;"><i class="glyphicon glyphicon-paperclip"></i></button>';
    modal_content += '<button type="submit" name="send_file" id="send_file_" class="send_file" style="border-radius: 100%; height: 44px; background-color: #056f57; color: black; width: 46px; border: none; display: none;"><i class="glyphicon glyphicon-menu-right"></i></button></div></form>';
    modal_content += '<button type="button" name="send_chat" id="'+to_user_id+'" class="send_chat" style="border-radius: 100%; height: 44px; background-color: #056f57; color: white; width: 40px; border: none;"><i class="glyphicon glyphicon-menu-right"></i></button></div>';
    $('#user_model_details').html(modal_content);
    
    $(document).ready(function() 
    {
    
      $('#chat_message'+to_user_id).keyup(function() {
    
      var name = $('#chat_message'+to_user_id).val();

      $.ajax({
          type: "POST",
          url: "amax.php",
          data: 
          {
            name : name,
            to_user : to_user_id,
            from_user_id : from_user_id
          }, 
        });
      });
      $('#chat_message'+to_user_id).blur(function() {
        $.ajax({
          url:"delete_live_chat.php",
          method:"POST",
          data:{to_user_id:to_user_id},
          success:function(){}
        })
      });
    });
     
      $(document).on('click', '.files__', function(){
        myFunction(to_user_id);
      });
      
  }
  function myFunction(to_user_id) {
    var b = to_user_id;
    var x = document.getElementById("files_");
    var y = document.getElementById("send_file_");
    var zss = document.getElementById(b);
    if (x.style.display === "none") {
      x.style.display = "block";
      y.style.display = "block";
      zss.style.display = "none";
    } 
    else {
      x.style.display = "none";
      y.style.display = "none";
      zss.style.display = "block";
    }
  }

  $(document).on('click', '.start_chat', function(){
    var from_user_id = $(this).data('fromuserid');
    var to_user_id = $(this).data('touserid');
    var to_display_name = $(this).data('todisplayname');
    make_chat_dialog_box(from_user_id, to_user_id, to_display_name);
    $("#user_dialog_"+to_user_id).dialog({
      autoOpen:false,
      width:400
    });
    $('#user_dialog_'+to_user_id).dialog('open');
    $('#chat_message'+to_user_id).emojiPicker();
  });
  $(document).on('click', '.send_chat', function(){
  var to_user_id = $(this).attr('id');
  var chat_message = $('#chat_message'+to_user_id).val();
  $.ajax({
   url:"insert_chat.php",
   method:"POST",
   data:{to_user_id:to_user_id, chat_message:chat_message},
   success:function(data)
   {
    //$('#chat_message_'+to_user_id).val('');
    var element = $('#chat_message'+to_user_id).emojiPicker();
    element[0].emojiPicker.setText('');
    $('#chat_history_'+to_user_id).html(data);
   }
  })
  $('#chat_message'+to_user_id).val('');
 });

  function fetch_live_chat(to_user_id)
  {
    //AJAX call to fetch all the messages between two users
    $.ajax({
      url:"fetch_live_chat.php",
      method:"POST",
      data:{to_user_id:to_user_id},
      success:function(data){
        //dispaly the returned data as the html in the chat history dialog of this user.
        $('#live_chat_'+to_user_id).html(data);
      }
    })
  }

  function fetch_is_online(to_user_id)
  {
    //AJAX call to fetch all the messages between two users
    $.ajax({
      url:"fetch_is_online.php",
      method:"POST",
      data:{to_user_id:to_user_id},
      success:function(data){
        //dispaly the returned data as the html in the chat history dialog of this user.
        $('#online_'+to_user_id).html(data);
      }
    })
  }

  function fetch_user_chat_history(to_user_id)
  {
    //AJAX call to fetch all the messages between two users
    $.ajax({
      url:"fetch_user_chat_history.php",
      method:"POST",
      data:{to_user_id:to_user_id},
      success:function(data){
        //dispaly the returned data as the html in the chat history dialog of this user.
        $('#chat_history_'+to_user_id).html(data);
      }
    })
  }

  function update_chat_history_data()
  {
    $('.chat_history').each(function(){
      var to_user_id = $(this).data('touserid');
      fetch_user_chat_history(to_user_id);
    });
  }

  $(document).on('click', '.close_me', function(){
    //When clicking on close button, thepopup must dissapear.
    $('.user_dialog').dialog('destroy').remove();
  });

   $(document).on('click', '.ui-button-icon', function(){
    $('.user_dialog').dialog('destroy').remove();
    
  }); 

   $(document).on('focus', '.my__panel', function(){
    var status = '1';
    $.ajax({
      url:"check_online_status.php",
      method:"POST",
      data:{status:status},
      success:function(){}
    })
  });
   $(document).on('focus', '.user_details', function(){
    var status = '1';
    $.ajax({
      url:"check_online_status.php",
      method:"POST",
      data:{status:status},
      success:function(){}
    })
  });
  $(document).on('focus', '.chat_history', function(){
      var status = '1';
      $.ajax({
        url:"check_online_status.php",
        method:"POST",
        data:{status:status},
        success:function(){}
      })
    });

   $(document).on('focus', '.user_dialog', function(){
    var status = '1';
    $.ajax({
      url:"check_online_status.php",
      method:"POST",
      data:{status:status},
      success:function(){}
    })
  });

  $(document).on('focus', '.chat_message', function(){
    var is_type = 'yes';
    $.ajax({
      url:"update_is_type_status.php",
      method:"POST",
      data:{is_type:is_type},
      success:function(){}
    })
  });

  $(document).on('blur', '.chat_message', function(){
    var is_type = 'no';
    $.ajax({
      url:"update_is_type_status.php",
      method:"POST",
      data:{is_type:is_type},
      success:function(){}
    })
  });
});

  
</script>
 <script type="text/javascript" src="jquery-ui.js"></script>
 <script src="./boot/bootstrap.min.js"></script>
  </body> 
</html>  
 

