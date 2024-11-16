<?php

include "layout/header.php";

//check if login , if not redirect it to that page
// if(!isset($_SESSION["$email"])){
//     header("location: ./login.php");
//     exit;
// }
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-6 mx-auto    border shadow p-4">
          <h2 class="text-center mb-4">
               Your Profile
          </h2>
          <hr>
          <div class="row mb-3">
                <label class="col-sm-4 ">First Name</label>
                <div class="col-sm-8"><?= $_SESSION["first_name"] ?></div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 ">Last Name</label>
                <div class="col-sm-8"><?= $_SESSION["last_name"] ?></div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 ">Email</label>
                <div class="col-sm-8"><?= $_SESSION["email"] ?></div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 ">Phone</label>
                <div class="col-sm-8"><?= $_SESSION["phone"] ?></div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-4 ">Address</label>
                <div class="col-sm-8"><?= $_SESSION["address"] ?></div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-4 ">Registered At</label>
                <div class="col-sm-8"><?= $_SESSION["create_at"] ?></div>
            </div>
        </div>
    </div>

</div>


<?php
include "layout/footer.php";
?>