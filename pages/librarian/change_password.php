<?php
require 'change_password_process.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../custom css and js/For sign in and sign up assets/loginPageStyle.css">
    <link rel="stylesheet" href="../assets/style.css" />
    <title>Sci-Games</title>
</head>

<body>
    <div class="container">


        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="row border rounded-5 p-3 bg-white shadow box-area">
                <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background-color: #5ba6f1; height: 450px;">
                    <div class="featured-image mb-3">
                        <img src="pictures/2.png" class="img-fluid" style="width: 250px" />
                    </div>
                    <p class="text-white fs-2 text-uppercase">
                        <!-- auto type sci games -->
                        <b><span class="auto-type"><b></b></b>
                        <!-- auto type sci games end -->
                    </p>
                    <small class="text-white text-wrap text-center">Online Application for Science 8</small>
                </div>

                <div class="col-md-6 right-box">
                    <div class="start-screen">
                        <div class="mb-3">
                            <h1 class="heading" style="font-weight: bold;">Change Password</h1>
                        </div>
                        <div class="card mt-5" style="background-color: #3FA2F6;">
                            <form action="" method="post">
                                <div class="container-fluid">
                                    <div class="row ">
                                        <div class="col-12">
                                            <h5 class="mb-2 text-dark mt-3">Enter your Email-Address</h5>
                                            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Enter email address" required>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <h5 class="mb-2 text-dark">Enter New Password</h5>
                                            <input type="password" name="new_password" id="inputPassword" class="form-control" placeholder="Enter new password" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ">
                                        <div class="col-12 mt-3 d-flex justify-content-center align-items-center">
                                            <button type="submit" class="btn btn-primary " name="change">Change</button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>
    </div>


    <!-- <script src="../assets/script.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script>
        var typed = new Typed(".auto-type", {
            strings: ["Welcome to Sci-games"],
            typeSpeed: 50,
            loop: true,
        });
        var typed = new Typed(".happy", {
            strings: [
                "We are happy to have you back.",
            ],
            typeSpeed: 70,
            loop: true,
        });
    </script>
</body>

</html>