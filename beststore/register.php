<?php
include "layout/header.php";

if(isset($_SESSION["email"])){
    header("location: ./index.php");
    exit;
}

$first_name = "";
$last_name = "";
$email = "";
$phone = "";
$address = "";

$first_name_error = "";
$last_name_error = "";
$email_error = "";
$phone_error = "";
$address_error = "";
$password_error = "";
$confirm_password_error = "";

$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // validate
    if(empty($first_name)){
        $first_name_error = "First Name Is Required";
        $error = true;
    }
    if(empty($last_name)){
        $last_name_error = "Last Name Is Required";
        $error = true;
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email_error = "Email Formate is Not Valid";
        $error = true;
    }
    
    include "tool/db.php";
   
    
    $dbConnection =getDatabaseConnection();

    $statement = $dbConnection->prepare("SELECT id FROM users WHERE email = ?");

    // bind variable to prepare statment  as parameters
    $statement->bind_param("s",$email);

    // execute statement
    $statement->execute();

    // check email if email is already in database
    $statement->store_result();
    if($statement->num_rows > 0){
        $email_error = "Email already Used";
        $error = true;
    }

    // close statement otherwise we cannot prepare another statement
    $statement->close();

    if (!preg_match('/^[6-9]\d{9}$/', $phone)) {
        $phone_error = "Phone format is not valid";  
        $error = true;
    }    
    if(strlen($password)<6){
        $password_error = "Password Must Have at Leat 6 Characters";
        $error = true;
    }
    if($confirm_password != $password){
        $confirm_password_error = "Password And Confirm Password do not match";
        $error = true;
    }

    if(!$error){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $create_at = date('Y-m-d H:i:s');
    }
    // let use prepared statement to avoid sql injection attack
    $statement = $dbConnection->prepare(
        "INSERT INTO users (first_name, last_name, email, phone, address, password, create_at) " .
        "VALUES (?,?,?,?,?,?,?)"
    );
    // bind variable to prepare statment  as parameters
    $statement->bind_param("sssssss",$first_name, $last_name,$email,$phone, $address,$password,$create_at);

    // execute statement

    $statement->execute();

    $insert_id = $statement->insert_id;
    $statement->close();



    // new account craeted
    // save session data
    $_SESSION["id"]=$insert_id;
    $_SESSION["first_name"]=$first_name;
    $_SESSION["last_name"]=$last_name;
    $_SESSION["email"]=$email;
    $_SESSION["phone"]=$phone;
    $_SESSION["address"]=$address;
    $_SESSION["craete_at"]=$create_at;

    header("location: ./index.php");
    exit;

}
?>

<div class="container py-5 ">
  <div class="row">
    <div class="col-lg-6 mx-auto border shadow p-6">
           <h2 class="text-center mb-4">Register</h2>
           <hr>
           <form method="post">
           <div class="row mb-3">
                <label class="col-sm-4 col-form-label">First Name</label>
                <div class="col-sm-8">
                    <input class="form-control" name="first_name" value="<?= $first_name ?>">  
                    <span class="text-danger"> <?= $first_name_error ?> </span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 col-form-label">Last Name</label>
                <div class="col-sm-8">
                    <input class="form-control" name="last_name" value="<?= $last_name ?>">
                    <span class="text-danger"> <?= $last_name_error ?> </span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 col-form-label">Email</label>
                <div class="col-sm-8">
                    <input class="form-control" name="email" value="<?= $email ?>">
                    <span class="text-danger"> <?= $email_error ?></span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 col-form-label">Phone</label>
                <div class="col-sm-8">
                    <input class="form-control" name="phone" value="<?= $phone ?>">
                    <span class="text-danger"><?= $phone_error ?></span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 col-form-label">Address</label>
                <div class="col-sm-8">
                    <input class="form-control" name="address" value="<?= $address ?>">
                    <span class="text-danger"><?= $address_error ?></span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 col-form-label">Password</label>
                <div class="col-sm-8">
                    <input class="form-control" type="password" name="password" value="">
                    <span class="text-danger"><?= $password_error ?></span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 col-form-label">Confirm Password</label>
                <div class="col-sm-8">
                    <input class="form-control" type="password" name="confirm_password" value="">
                    <span class="text-danger"><?= $confirm_password_error ?></span>
                </div>
            </div>
            <div class="row mb-3">
                <div class="offset-sm-4 col-sm-4 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class=" col-sm-4 d-grid">
                    <a class="btn btn-outline-primary" href="/index.php" role="button">Cancel</a>
                </div>
            </div>
           </form>
  </div>
</div>

<?php
include "layout/footer.php"
?>