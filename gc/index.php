<?php
include('database_connection.php');
session_start();
if(!isset($_SESSION['user_id'])){
	header("location:../index.php");
}
?>

<html>  
    <head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>DEFQON 1 DISSCUSSION</title>
        <link rel="stylesheet" href="msgstyle.css"/>
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  		<script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>
  		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
        <link rel="stylesheet" href="../assets/css/floatingback.css"/>
    </head>  
    <body class="universal" style="background: url(../images/stages.jpg)no-repeat top center / cover; min-height: 100vh; width: 100%; position: relative;">  
        <a href="../index.php" class="home-btn">&larrhk;</a>
        <div class="container">
			<h3 class = "logo" align="center"><span style="color: #FFD300">DEFQON 1</span> Diss<span>cussion</span> </h3><br/>
			<div class="hiuser">
				<div>
					<h4 >Hi - <?php echo $_SESSION['username']; ?> - <a href="logout.php">Logout</a></h4>
				</div>
			</div>
		</div>
		<div class="container">
			<div id="group_chat_dialog" title="Group Chat Window">
				<div id="group_chat_history" style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px;">
				</div>
			</div>
			<div class="form-group">
				<div class="chat_message_area">
					<div id="group_chat_message" contenteditable class="form-control">
					</div>
					<div class="image_upload">
						<form id="uploadImage" method="post" action="upload.php">
						<label for="uploadFile"><img src="upload.png" /></label>
						<input type="file" name="uploadFile" id="uploadFile" accept=".jpg, .png"/>
					</form>
					</div>
				</div>
			</div>
			<div class="form-group" align="right">
			<button type="button" name="send_group_chat" id="send_group_chat" class="btn btn-info" onclick="takecommand()">Send</button>
			</div>
		</div>
	</body>  
</html>

<style>

.chat_message_area
{
	position: relative;
	width: 100%;
	height: auto;
	background-color: #FFF;
    border: 1px solid #CCC;
    border-radius: 3px;
}

#group_chat_message
{
	width: 100%;
	height: auto;
	min-height: 80px;
	overflow: auto;
	padding:6px 24px 6px 12px;
}

.image_upload
{
	position: absolute;
	top:3px;
	right:3px;
}
.image_upload > form > input
{
    display: none;
}

.image_upload img
{
    width: 24px;
    cursor: pointer;
}

</style>  
<script>  
    

$(document).ready(function(){
	fetch_group_chat_history();
	setInterval(function(){
		fetch_group_chat_history();
	}, 5000);

	$(document).on('click', '.send_chat', function(){
		var to_user_id = $(this).attr('id');
		var chat_message = $.trim($('#chat_message_'+to_user_id).val());
		if(chat_message != '')
		{
			$.ajax({
				url:"insert_chat.php",
				method:"POST",
				data:{to_user_id:to_user_id, chat_message:chat_message},
				success:function(data)
				{
					var element = $('#chat_message_'+to_user_id).emojioneArea();
					element[0].emojioneArea.setText('');
					$('#chat_history_'+to_user_id).html(data);
				}
			})
		}
		else
		{
			alert('Type something');
		}
	});


	$(document).on('click', '.ui-button-icon', function(){
		$('.user_dialog').dialog('destroy').remove();
		$('#is_active_group_chat_window').val('no');
	});

	function update_chat_history_data()
	{
		$('.chat_history').each(function(){
			var to_user_id = $(this).data('touserid');
			fetch_user_chat_history(to_user_id);
		});
	}

	$('#send_group_chat').click(function(){
		var chat_message = $.trim($('#group_chat_message').html());
		var action = 'insert_data';
        if(chat_message == "/mc"){
            $.ajax({
				url:"../matrix/matrix.html",
				method:"POST",
				data:{chat_message:chat_message, action:action},
				success:function(data){
					$('#group_chat_message').html('');
					$('#group_chat_history').html(data);
                    window.open("../matrix/matrix.html");
				}
			})
        }
        if(chat_message == "/t"){
            $.ajax({
				url:"../telegram_handling/telegram.php",
				method:"POST",
				data:{chat_message:chat_message, action:action},
				success:function(data){
					$('#group_chat_message').html('');
					$('#group_chat_history').html(data);
                    window.open("../telegram_handling/telegram.php");
				}
			})
        }
		if(chat_message != '')
		{
			$.ajax({
				url:"group_chat.php",
				method:"POST",
				data:{chat_message:chat_message, action:action},
				success:function(data){
					$('#group_chat_message').html('');
					$('#group_chat_history').html(data);
				}
			})
		}
        else
		{
			alert('Type something');
		}  
	});

	function fetch_group_chat_history()
	{
		var group_chat_dialog_active = 'yes';
		var action = "fetch_data";
		if(group_chat_dialog_active == 'yes')
		{
			$.ajax({
				url:"group_chat.php",
				method:"POST",
				data:{action:action},
				success:function(data)
				{
					$('#group_chat_history').html(data);
				}
			})
		}
	}

	$('#uploadFile').on('change', function(){
		$('#uploadImage').ajaxSubmit({
			target: "#group_chat_message",
			resetForm: true
		});
	});

	$(document).on('click', '.remove_chat', function(){
		var chat_message_id = $(this).attr('id');
		if(confirm("Are you sure you want to remove this chat?"))
		{
			$.ajax({
				url:"remove_chat.php",
				method:"POST",
				data:{chat_message_id:chat_message_id},
				success:function(data)
				{
					update_chat_history_data();
				}
			})
		}
	});
	
});  
</script>