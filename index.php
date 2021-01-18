<?php
$error = NULL;

if (isset($_POST['submit'])){

    //connect to database
    $mysqli = NEW MySQLi ('localhost','deb85590_buitenplanner','$KT^8L4qiRDL!e','deb85590_buitenplanner');

    //get form data
    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $password = md5($password);

    //database querry
    $resultSet = $mysqli->query("SELECT * FROM users WHERE email = '$email' AND password = '$password' LIMIT 1");

    if ($resultSet-> num_rows !=0){
        //go login
        $row = $resultSet->fetch_assoc();
        $verified = $row['verified'];
        $email1 = $row['email'];
        $create = $row['createdate'];
        $create = strtotime($create);
        $create = date('d M Y' , $create);
        if ($verified == 1){
            //login
            session_start();
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['email'];

            header('Location: dashboard');
        }else{
            $error = "<hr> <p class='error'> Dit account is nog niet geferivieerd. Er is een email verstuurd naar $email1 op $create </p>";
        }
    }else{
        //not right
        $error = "<div class='container' style='max-width: 600px; margin-top: 10px'>  <div class='alert alert-danger' role='alert'>Email en of wachtwoord niet correct </div></div> ";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <!-- custom stylesheet -->
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">

    <title>Login</title>

    <script src="maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>


<body>
</head>
<body class="bg">

    <div class="login-form form-middle" >
        <form action="" method="post" >
            <h2 class="text-center">Login</h2>
            <div class="form-group has-error">
                <input required type="email" name="email" id="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group">
                <input required type="password" name="password" id="password" class="form-control" placeholder="Wachtwoord">
            </div>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-info btn-md" value="Login">
            </div>
            <!--        <p><a href="#">Lost your Password?</a></p>-->
            <?php echo $error?>
            <p class="text-center small">Nog geen account? <a id="register" href="include/createLocation.php">Registreer hier!</a></p>
        </form>

    </div>
</body>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>
