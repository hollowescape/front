<?php
 require_once "config.php";

 $username = $password = $confirm_password = "";
 $username_err = $password_err = $confirm_password_err="";
 if($_SERVER['REQUEST_METHOD'] == "POST"){
 {
    
    if(empty(trim($_POST["username"]))){
        $username_err="username cannot be blank";
    }
    else
    {
        $sql="SELECT id FROM users WHERE username=?";
        $stmt = mysqli_prepare($conn,$sql);
        if($stmt)
        {
                mqsqli_stmt_bind_param($stmt,"s",$param_username);
                $param_username = trim($_POST['username']);

                if(mqsqli_stmt_execute($stmt))
                {
                    mqsqli_stmt_store_results($stmt);
                    if(mqsqli_stmt_num_rows($stmt)==1)
                    {
                        $username_err="this username  is already taken";

                    }
                    else
                    {
                        $username=trim($_POST['username']);
                    }
                }
                else
                {
                    echo "something wrong";
                }
        }
    }

     bool mqsqli_stmt_close(mysqli_stmt stmt);
}
    if(empty(trim($_POST["password"]))){
    $password_err="username cannot be blank";
    }
    else if(strlen(trim($_POST['password'])) < 5)
    {
     $password_err=" password cannot be less than 5";
    }
 else{
     $password = trim($_POST['password']); 
 }
 if(trim($_POST["password"]) !=trim($_POST['confirm_password'])){
     $password_err="passwords should match";
 }
 if(empty($username_err)&& empty($password_err)&&empty($confirm_password_err))
 {
     $sql = "INSERT INTO users(username,password) VALUES (?,?)";
     $stmt = mysqli_prepare($conn,$sql);
     if($stmt)
     {
         mysqli_stmt_bind_param($stmt,"ss");

         $param_username = $username;
         $param_password = password_hash($password,
         PASSWORD_DEFAULT);
         if(mysqli_stmt_execute($stmt))
         {
             header("location: login.php");

         }
         else
         {
             echo "something went wroong";
         }
     }
     mysqli_stmt_close($stmt);

 }
    mysqli_close($conn);
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>

        </title>
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
            <h1 class="text-success text-center">Registeration form </h1><hr>
            <div class="col-lg-8 m-auto d-block">

                <form action="" onsubmit="return validation()" class="bg-light" method="post">
                            <div class="form-group">
                                <label>First Name:</label>
                                <input type="text" name="first"class="form-control" id="firstn" autocomplete="off">
                                <span id="firsts" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label>Last Name:</label>
                                <input type="text" name="last"class="form-control" id="lastn" autocomplete="off">
                                <span id="lasts" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label>Username:</label>
                                <input type="text" name="username" class="form-control" id="user" autocomplete="off">
                                <span id="users" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="text" name="email"class="form-control" id="email" autocomplete="off">
                                <span id="emails" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label>Phone No:</label>
                                <input type="text" name="phone"class="form-control" id="phone"autocomplete="off">
                                <span id="phones" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label>Password:</label>
                                <input type="password" name="confirm_password"class="form-control" id="pass"autocomplete="off">
                                <span id="passws" class="text-danger font-weight-bold"></span>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password:</label>
                                <input type="password" name="conpass"class="form-control" id="conpass"autocomplete="off">
                                <span id="conpasws" class="text-danger font-weight-bold"></span>
                            </div>
                            
                        <input type="submit" name ="submit" value="submit"class="btn btn-success" >
                </form>
            </div>

        </div>
        <script type="text/javascript">
            function validation(){
                var firstn=document.getElementById('firstn').value;
                var lastn=document.getElementById('lastn').value;
                var user=document.getElementById('user').value;
                var email=document.getElementById('email').value;
                var phone=document.getElementById('phone').value;
                var pass=document.getElementById('pass').value;
                var conpass=document.getElementById('conpass').value;
                
                if(firstn=="")
                {
                    document.getElementById('firsts').innerHTML="* please fill the first name";
                    return false;
                }
                if(firstn.length<=2||firstn.length>10)
                {
                    document.getElementById('firsts').innerHTML="*first name should contain(2-10)characters";
                    return false;
                }
                if(!isNaN(firstn))
                {
                    document.getElementById('firsts').innerHTML="* please fill valid first name";
                    return false;                    
                }
                if(lastn=="")
                {
                    document.getElementById('lasts').innerHTML="* please fill the last name";
                    return false;
                }
                if(lastn.length<=2||lastn.length>10)
                {
                    document.getElementById('lasts').innerHTML="*last name should contain(2-10)characters";
                    return false;
                }
                if(!isNaN(lastn))
                {
                    document.getElementById('lasts').innerHTML="* please fill valid last name";
                    return false;                    
                }
                if(user=="")
                {
                    document.getElementById('users').innerHTML="* please fill the user name";
                    return false;
                }
                if(user.length<=2||user.length>20)
                {
                    document.getElementById('users').innerHTML="*user name should contain(2-10)characters";
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

                if(phone=="")
                {
                    document.getElementById('phones').innerHTML="* please fill the phone number";
                    return false;
                }
                if(isNaN(phone))
                {
                    document.getElementById('phones').innerHTML="* please fill the correct phone number";
                    return false;
                }
                if(phone.length!==10)
                {
                    document.getElementById('phones').innerHTML="* please fill the correct (10 digit)phone number";
                    return false;
                }

                if(pass=="")
                {
                    document.getElementById('passws').innerHTML="* please fill the password";
                    return false;
                }
                if(pass.length<=4||pass.length>10)
                {
                    document.getElementById('passws').innerHTML="*password should contain(4-10)characters";
                    return false;
                }
                if(conpass=="")
                {
                    document.getElementById('conpasws').innerHTML="* please fill the confrorm Password";
                    return false;
                }
                if(pass!=conpass)
                {
                    document.getElementById('conpasws').innerHTML="* please enter same the Password";
                    return false;
                }
            }
        </script>
    </body>
</html>
