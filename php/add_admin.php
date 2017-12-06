<?php
  session_start();
  if( !isset($_SESSION['username']) ){
    header('Location: ./login.php');
        exit();
  }

  

  if(isset($_POST["add_admin"]) && $_POST['username'] != "" && $_POST['password'] != "" ){

    require_once dirname(__FILE__). "/db/connect.php";

    $raw_pass = $_POST['password'];
    $salt = bin2hex(random_bytes( 22 ));
    $hashed_salt = hash('sha256', $salt . $raw_pass);

    $stmt = $dbconn->prepare("INSERT INTO `user` (`username`, `salt`, `salted_password`, `admin`) VALUES (:username, :salt, :salted_password, :admin)");

     $stmt->execute(array(":username" => htmlspecialchars($_POST['username'], ENT_QUOTES), ":salt" => $salt, ":salted_password" => $hashed_salt, ":admin" => 1));

     
     $msg = "Admin Added";
  }





?>


<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" >

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Troy Kitchen CMS</title>
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <link href="/css/login.css" rel="stylesheet">
</head>


<body>
  <div id="form-wrapper">
    <div class="container">
      <div class="row">
        <div class="Absolute-Center is-Responsive">
          <h3>Add Admin Account</h3>
          <form action="?" method="post" id="addAdminForm" onsubmit="" class="medium-12 columns">
              <?php if (isset($msg)) echo "<p class=\"err-msg\">$msg</p>"; $msg = NULL;?>
              <div class="form-group input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input type="text" class="form-control" placeholder="Username" name="username" id="name" />
              </div>

              <div class="form-group input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input class="form-control" type="password" name="password" id="password" placeholder="Password"/>
              </div>

              <div class="form-group">
                <input id="submit" type="submit" class="btn btn-def btn-block" name="add_admin" value="Submit" />
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>