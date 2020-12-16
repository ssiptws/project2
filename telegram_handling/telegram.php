<html> 
<head> 
    <title> 
        Telegram Chat
    </title> 
    <link rel="stylesheet" href="../assets/css/floatingback.css"/>
</head> 
<style>
    .inputglow{
        border: 1px solid;
        width: 300px;
        height: 35px;
        border-radius: 4px;
        -moz-border-radius: 4px;
        -webkit-border-radius: 4px;  
        }
    .inputglow:hover{
        outline:none;
        border: 1px solid #0088cc; 
        /* create a BIG glow */
        box-shadow: 0px 0px 5px #0088cc; 
        -moz-box-shadow: 0px 0px 5px #0088cc;
        -webkit-box-shadow: 0px 0px 5px #0088cc;  
    }
    .submit{
        background-color: white;
        border-style: none;
        font-size: 14px;
    }
    .submit:hover{
        color: white;
        background-color: #0088cc; 
    }
</style>
<body style="background-image: url(../images/background_announce.png); background-repeat: no-repeat; background-size: 200%;"> 
    <a href="../gc/index.php" class="home-btn">&larrhk;</a>
    <center>
        <div style="background-color:white; margin: 15%; width: 500px; border-radius: 25px">
            <img src="../images/promotion.png" style="float: right; height:75px; margin:-30px">
            <big>
                <form style="padding: 4%" method="POST" name="form" action="telegram.php"> 
                    <h2 style="color:#0088cc;"> 
                        Announce Something To Telegram
                    </h2> 
                    <input class="inputglow" id="messege" type="text" placeholder="Enter Messege" name="messege">
                    <br>
                    <br>
                    <input style="margin-bottom: 1%; width: 150px; height: 25px" type="submit" value="Submit" class="submit"> 
                </form> 
            </big>
        </div>
    </center>

</body> 
  
</html> 
<?php
    include ('functionsend.php');
    if (isset($_POST['messege'])){
        $msg = $_POST['messege'];
        if($msg == ""){
        }
        else if ($msg != ""){
            telegram ($msg);
            echo "<script>alert('Success')</script>";
        }
        else
            echo "<script>alert('Error')</script>";
    }
    
        
// Function call with your own text or variable
?>