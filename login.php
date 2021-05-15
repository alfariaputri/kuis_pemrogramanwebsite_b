<?php 
	session_start();	
	$koneksi = mysqli_connect("localhost","root","","login");
	$eror        = "";
	$username   = "";
	$rememberme   = "";


	if(isset($_COOKIE['cookie_username'])){
    $cookie_username = $_COOKIE['cookie_username'];
    $cookie_password = $_COOKIE['cookie_password'];
    $sql_1 = "SELECT * FROM login WHERE username = '$cookie_username'";
    $q_1   = mysqli_query($koneksi,$sql_1);
    $r_1   = mysqli_fetch_array($q_1);

    if($r_1['password'] == $cookie_password){
        $_SESSION['session_username'] = $cookie_username;
        $_SESSION['session_password'] = $cookie_password;
    }
}

if(isset($_SESSION['session_username'])){
    header("location:admin.php");
    exit();
}

if(isset($_POST['login'])){
    $username   = $_POST['username'];
    $password   = $_POST['password'];
    $rememberme   = $_POST['rememberme'];

    if($username =='' or $password ==''){
        $eror .= "Masukkan Username dan Password";
    	}else{
	        $sql1 = "SELECT* FROM login WHERE username = '$username'";
	        $q1   = mysqli_query($koneksi,$sql1);
	        $r1   = mysqli_fetch_array($q1);

        if($r1['username'] == ''){
            $eror .= "<li>Username <b>$username</b> tidak tersedia.</li>";
        }elseif($r1['password'] != md5($password)){
            $eror  .= "<li>Password yang dimasukkan tidak sesuai.</li>";
        }       
        
        if(empty($eror)){
            $_SESSION['session_username'] = $username; 
            $_SESSION['session_password'] = md5($password);

            if($rememberme == 1){
                $cookie_name = "cookie_username";
                $cookie_value = $username;
                $cookie_time = time() + (60 * 60 * 24 * 30);
                setcookie($cookie_name,$cookie_value,$cookie_time,"/");

                $cookie_name = "cookie_password";
                $cookie_value = md5($password);
                $cookie_time = time() + (60 * 60 * 24 * 30);
                setcookie($cookie_name,$cookie_value,$cookie_time,"/");
            }
            header("location:admin.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>
<body>
	<div class="container my-4">    
	    <div id="loginbox" 
	    	 style="margin-top:50px;" 
	    	 class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
	    <div class="panel panel-info" >
	    <div class="panel-heading">
	    <div class="panel-title">Login dan Masuk Ke Sistem</div>
	  	</div>      
	    <div style="padding-top:30px" class="panel-body" >
	         <?php if($eror){ ?>
	  	<div id="login-alert" class="alert alert-danger col-sm-12">
	         <ul><?php echo $eror ?></ul>
	    </div>
	         <?php } ?>                
	  	<form id="loginform" class="form-horizontal" action="" method="post" role="form">       
	    <div style="margin-bottom: 25px" 
	    	 class="input-group">
	    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
	    <input id="login-username" 
	    	   type="text" 
	    	   class="form-control" 
	    	   name="username" 
	    	   value="<?php echo $username ?>"
	    	   placeholder="Username : admin">                                        
	    </div>
	    <div style="margin-bottom: 25px" 
	    	 class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input id="login-password" type="password" class="form-control" name="password" placeholder="password : admin">
  	    </div>
	    <div class="input-group">
	    <div class="checkbox">
        <label>
            <input id="login-remember" 
            	   type="checkbox" 
            	   name="rememberme" 
            	   value="1" <?php if($rememberme=='1') echo "checked"?>> Remember Me
        </label>
	    </div>
	    </div>
	    <div style="margin-top:10px" 
	    	 class="form-group">
	    <div class="col-sm-12 controls">
	    <input type="submit" 
	    	   name="login"
	    	   class="btn btn-success" 
	    	   value="Login"/>
	    </div>
	    </div>
	   	</form>    
	    </div>                     
	    </div>  
	    </div>
	</div>
	</body>
	</html>