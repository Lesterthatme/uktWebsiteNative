<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>

    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/signup.css?v=1.0">
    <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">

    <!-- added 2026 -->
    <script src="/assets/js/signup.js"></script>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-color-default">Signup Form</h2>
                            <p class="text-muted fs-7">Join us by filling out the details below</p>
                        </div>

                        <form method="POST" action="/ukt/function/php/auth/signup.php">
                            <div class="profile-pic-container">
                                <img src="../../assets/images/officiallogo (1).png" alt="Profile Picture" id="profile-pic">
                                <label for="profile-upload" class="upload-icon">
                                    <i class="ri-camera-fill"></i>
                                </label>
                                <input type="file" id="profile-upload" name="profile-upload" accept="image/*" onchange="previewImage(event)">
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="firstname" class="form-label">First Name <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter your first name" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="middlename" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" placeholder="Enter your Middle name" id="middlename" name="middlename">
                                </div>
                                <div class="col-md-4">
                                    <label for="lastname" class="form-label">Last Name <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter your Last name" id="lastname" required name="lastname">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="birthday" class="form-label">Birthday <span style="color: red;">*</span></label>
                                    <input type="date" class="form-control" id="birthday" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="number" class="form-control" placeholder="(Auto-filled)" id="age" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="lastname" class="form-label">Username <span style="color: red;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter your Username" id="lastname" required>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Sex <span style="color: red;">*</span></label>
                                    <select class="form-select" id="sex" required>
                                        <option value="">Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span style="color: red;">*</span></label>
                                    <input type="email" class="form-control" placeholder="Enter your E-mail" id="email" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password <span style="color: red;">*</span></label>
                                    <input type="password" class="form-control" id="password" placeholder="Enter your Password" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="confirm-password" class="form-label">Confirm Password <span style="color: red;">*</span></label>
                                    <input type="password" class="form-control" id="confirm-password" placeholder="Confirm Password" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dynamic w-100 mb-3 p-2 fw-semibold" name="signupBtn">Sign Up</button>
                        </form>
                        <p class="signup-text">
                            Already Have an account? <a href="login.php">Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/site_settings.js?v=1.8"></script>

</body>

</html>