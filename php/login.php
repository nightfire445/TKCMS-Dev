<?php
  ini_set('display_errors',1);
  error_reporting(E_ALL);
  require_once dirname(__FILE__). "/db/connect.php";

  if(isset($_POST['password']) &&  $_POST['password'] == "" || isset($_POST['username']) && $_POST['username'] == "" ){
     $msg = "Username and password must not be left blank.";

}

  if (isset($_POST['login']) || isset($_POST['register']) && isset($_POST['password'])  && isset($_POST['username']) ){
    //Obtain User's Salt
    $select_salt = $dbconn->prepare("SELECT salt FROM user WHERE username = :username");
    $select_salt->execute(array(':username' => $_POST['username']));
    $res = $select_salt->fetch();

    $salt = (isset($res) ) ? $res['salt'] : '';
    $raw_pass = $_POST['password'];
    //Hash the Salt and Raw Pass
    $hashed_salt = hash('sha256', $salt . $raw_pass);
    //Obtain the user info
    $stmt = $dbconn->prepare('SELECT * FROM user WHERE username=:username AND salted_password = :salted_password');
    $stmt->execute(array(':username' => $_POST['username'], ':salted_password' => $hashed_salt));

    //If the login is successful
    if ($stmt->rowCount() != '0'){
        $_SESSION['username'] = $user['username'];
        $_SESSION['uid'] = $user['id'];

        $msg = 'Succesfully Logged in';
        header('Location: ./dashboard.php');
        exit();
    }
    else if(isset($_POST['login']) && isset($_POST['password'])){
        $msg = 'Wrong username or password';
      }

  }
  if(isset($_POST['logout']) && isset($_SESSION['username']))
  {
    unset($_SESSION['username']);
    unset($_SESSION['uid']);
    $msg = "You have been logged out.";
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
  <script>var $_POST = <?php echo !empty($_POST)?json_encode($_POST):'null';?>; </script>
</head>

 <!-- body content here -->

<body>
  <div id="form-wrapper">
   <?php if (isset($_SESSION['username'])):?>
      <form action="login.php" method="post" id="logout-form" class="medium-6 columns">
        <section>
        <h1>Log Out</h1>
        <?php if (isset($msg)) echo "<p class=\"err-msg\">$msg</p>"; $msg = NULL; ?>
        </section>
        <section>
        <input id="submit" class="btn btn-secondary" type = "submit" name="logout" value="logout" />
        </section>
      </form>
  </div>
  <?php else: ?>
    <div class="container">
      <div class="row">
        <div class="Absolute-Center is-Responsive">
          <div class="col-sm-12 col-md-10 col-md-offset-1">
            <form action="login.php" method="post" id="loginForm" onsubmit="return validate_login(this);" class="medium-6 columns">
              <?php if (isset($msg)) echo "<p class=\"err-msg\">$msg</p>"; $msg = NULL;?>
              <div class="form-group input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input type="text" class="form-control" placeholder="Name" name="username" id="name" />
              </div>

              <div class="form-group input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input class="form-control" type="password" name="password" id="password" placeholder="password"/>
              </div>

              <div class="form-group">
                <input id="submit" type="submit" class="btn btn-def btn-block" name="login" value="Login" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</body>
</html>
