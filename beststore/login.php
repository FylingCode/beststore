<?php
include "layout/header.php";

// cheeck usser is loggedd in redirected to home page
if(isset($_SESSION["email"])){
    header("location: ./index.php");
    exit;
}   

$email = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST["email"];
    $password = $_POST["password"];

    if(empty($email) || empty($password)){
       $error = "Both Email and Password is Required";
    }
    else{
        include "tool/db.php";
        $dbConnection =getDatabaseConnection();

        $statement = $dbConnection->prepare(
            "SELECT id,first_name,last_name,phone,address,password,create_at FROM users WHERE email = ?"
        );
        // bind variable to prepare statment  as parameters
    $statement->bind_param("s",$email);

    // execute statement
    $statement->execute();

    // bind result variable\
    $statement->bind_result($id, $first_name,$last_name, $phone, $address, $stored_password, $created_at);


    // fetch values
    if ($statement->fetch()){
       if(password_verify($password, $stored_password)){
       // password is corerect

       // store data in session bvaribale
         // save session data
    $_SESSION["id"]=$insert_id;
    $_SESSION["first_name"]=$first_name;
    $_SESSION["last_name"]=$last_name;
    $_SESSION["email"]=$email;
    $_SESSION["phone"]=$phone;
    $_SESSION["address"]=$address;
    $_SESSION["craete_at"]=$create_at;

       // redirect user
       header("location: ./index.php");
       exit;
    }
}
    $statement->close();

    $error = "Invalid Email or Password";
    }

}

?>

<div class="container py-5 ">
  <div class="row">
    <div class="col-lg-6 mx-auto border shadow p-6">
           <h2 class="text-center mb-4">Login</h2>
           <hr>
           <?php if(!empty($error)){  ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong><?= $error ?></strong> 
  <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">
  </button>
</div>
         <?php  } ?>
           
           <form method="post">
            <div class=" mb-3">
                <label class="form-label">Email</label>
                    <input class="form-control" name="email" value="<?= $email ?>">
            </div>
            <div class=" mb-3">
                <label class="form-label">Password</label>
                    <input class="form-control" type="password" name="password" value="">
            </div>
            <div class="row mb-3">
                <div class="col d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                <div class=" col d-grid">
                    <a class="btn btn-outline-primary" href="./index.php" role="button">Cancel</a>
                </div>
            </div>
           </form>
  </div>
</div>

<?php
include "layout/footer.php";


?>