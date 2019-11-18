<?php

    session_start();
    if(isset($_SESSION['username'])){
        header(" location: welcome.php");
        exit;

    }
    require_once "config.php";
    $username = $password  ="";
    $username_err = $password_err = "";
    if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(empty(trim($_POST["username"]))|| empty(trim($_POST["password"])))
    {
        $err = "please enter the username and password";
    } 
    else
    {
        $username =trim($_POST['username']);
        $password =trim($_POST['password']);
    }
    if(empty($err))
    {
        $sql="SELECT id, username, password FROM users WHERE username=?"; 
        $stmt = mysqli_prepare($conn,$sql);
        mqsqli_stmt_bind_param($stmt,"s",$param_username);
        $param_username = $username;
        mqsqli_stmt_execute($stmt);
        if(mqsqli_stmt_execute($stmt))
        { mqsqli_stmt_store_results($stmt);
            if(mqsqli_stmt_num_rows($stmt)==1)
            {
                mqsqli_stmt_bind_param($stmt,$id,$username,$hashed_password);
                if(mysqli_stmt_fetch($stmt))
                {
                    if(password_verify($password,$hashed_password))
                    {
                        session_start();
                        $_SESSION["username"] = $username;
                        $_SESSION["id"] = $id;
                        $_SESSION["loggedin"] = true;

                        header(" location: welcome.php");   
                    }
                }
            }
        }
    }

    }
    
    ?>   
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class=" container"><hr>
            <h1 class="text-success text-center">Login details </h1><hr>
                <div class="col-lg-8 m-auto d-block">
    
                    <form action="#" onsubmit="return validation()" class="bg-light" method = "post">
                                <div class="form-group">
                                    <label>Email/username:</label>
                                    <input type="text" name="user"class="form-control" id="email" autocomplete="off">
                                    <span id="emails" class="text-danger font-weight-bold"></span>
                                </div>
                                <div class="form-group">
                                    <label>Password:</label>
                                    <input type="password" name="pass"class="form-control" id="pass"autocomplete="off">
                                    <span id="passws" class="text-danger font-weight-bold"></span>
                                </div>
                                <input type="submit" name="login" value="login" class="btn btn-success">
                    </form>
                    </div>
         <script type="text/javascript">
            function validation()
            {
                var user=document.getElementById('user').value;
                var email=document.getElementById('email').value;
                var pass=document.getElementById('pass').value;
                if(user=="")
                {
                    document.getElementById('users').innerHTML="* please fill the user name";
                    return false;
                }
                if(email=="")
                {
                    document.getElementById('emails').innerHTML="* please fill the email id";
                    return false;
                }
                if(email.indexOf('@')<=0)
                {
                    document.getElementById('emails').innerHTML="* invalid email id";
                    return false;
                }
                if((email.charAt(email.length-4)!='.')&&(email.charAt(email.length-3)!='.'))
                {
                    document.getElementById('emails').innerHTML="* invalid email id";
                    return false;
                } 
                if(pass=="")
                {
                    document.getElementById('passws').innerHTML="* please fill the password";
                    return false;
                }
            }
        </script>           
    </body>
</html>

