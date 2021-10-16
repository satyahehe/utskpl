<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<?php
//File      : login.php
//Deskripsi : menampilkan form login dan melakukan login ke halaman admin.php

session_start(); //inisialisasi session
require_once('../bookorama/db_login.php');

//cek apakah user sudah submit form
if(isset($_POST["submit"])){
    $valid = TRUE; //flag validasi
    //cek validasi email
    $email = test_input($_POST['email']);
    if($email == ''){
        $error_email = "Email is required";
        $valid = FALSE;
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error_email = "Invalid email format";
        $valid = FALSE;
    }
    //cek validasi password
    $password = test_input($_POST['password']);
    if($password == ''){
        $error_password = "Password is required";
        $valid = FALSE;
    }

    //cek validasi
    if($valid){
        //Assign a query
        $query =  "SELECT * FROM admin WHERE email = '".$email."' AND password='".$password."' ";
        //Execute the query
        $result = $db->query($query);
        if(!$result){
            die ("Could not query the database: <br/>".$db->error);
        }else{
            if($result->num_rows > 0){
                $_SESSION['username'] = $email;
                header('Location: ../bookorama/view_customer.php');
                exit;
            }else{
                echo '<span class="error">Combination of username and password are not correct.</span>';
            }
        }
        //close db connection
        $db->close();
    }
}

?>
<br>
<div class="card">
    <div class="card-header">Login Form</div>
    <div class="card-body">
        <form method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" size="30" value="<?php if(isset($email)) {echo $email;}?>">
                <div class="error"><?php if(isset($error_email)) echo $error_email;?></div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="">
                <div class="error"><?php if(isset($error_password)) echo $error_password;?></div>
            </div>
            <button type="submit" class="btn btn-primary" name="submit" value="submit">Login</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>