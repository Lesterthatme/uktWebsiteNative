<?php
session_start();
include '../../connection/dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $conn->real_escape_string($_POST['ap_firstname']);
    $mi = $conn->real_escape_string($_POST['ap_mi']);
    $last_name = $conn->real_escape_string($_POST['ap_lastname']);
    $birthday = $conn->real_escape_string($_POST['birthday']);
    $age = $conn->real_escape_string($_POST['age']);
    $full_address = $conn->real_escape_string($_POST['full_address']);
    $contact_number = $conn->real_escape_string($_POST['contact_number']);
    $sex = $conn->real_escape_string($_POST['sex']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $confirm_password = $conn->real_escape_string($_POST['confirm_password']);

    // Check if email already exists
    $email_query = "SELECT email FROM user_account WHERE email = '$email'";
    $email_result = $conn->query($email_query);

    if ($email_result->num_rows > 0) {
        $_SESSION['alreadyExist_message'] = 'Email already exists!';
        header("Location: signup.php");
        exit;
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['passNotMatch'] = 'Password and Confirm Password do not match!';
        header("Location: signup.php");
        exit;
    }

    // Handle image upload
    $upload_folder = '../../assets/uploads/librarian_profilepic/';
    $default_image = "default-profile.jpeg";
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    if (!empty($image)) {
        if (!file_exists($upload_folder)) {
            mkdir($upload_folder, 0777, true); // Ensure folder exists
        }
        move_uploaded_file($image_tmp, $upload_folder . $image);
        $final_image = $image;
    } else {
        $final_image = $default_image;
    }

    // Insert into user_account
    $insert_user_account = "INSERT INTO user_account (username, email, password, image, user_type, account_status) 
                            VALUES ('$username', '$email', '$password', '$final_image', 'Librarian', 'pending')";

    if ($conn->query($insert_user_account)) {
        $user_id = $conn->insert_id;

        // Insert into authorized_person
        $insert_authorized_person = "INSERT INTO authorized_person (ap_firstname, ap_mi, ap_lastname, birthday, age, sex, full_address, contact_number, user_id) 
                                     VALUES ('$first_name', '$mi', '$last_name', '$birthday', '$age', '$sex', '$full_address','$contact_number', '$user_id')";

        if ($conn->query($insert_authorized_person)) {
            echo "<script>
                alert('Signup successful!');
                window.location.href = 'login.php';
            </script>";
            exit;
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../../assets/images/officiallogo (1).png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/signup.css">
    <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-success">Signup Form</h2>
                            <p class="text-muted fs-7">Join us by filling out the details below</p>
                        </div>
                        <?php
                        if (isset($_SESSION['passNotMatch'])) {
                            echo "<script>
                            alert('{$_SESSION['passNotMatch']}');
                        </script>";
                            unset($_SESSION['passNotMatch']);
                        }

                        if (isset($_SESSION['alreadyExist_message'])) {
                            echo "<script>
                                alert('{$_SESSION['alreadyExist_message']}');
                            </script>";
                            unset($_SESSION['alreadyExist_message']);
                        }

                        if (isset($_SESSION['imageError'])) {
                            echo "<script>alert('{$_SESSION['imageError']}');</script>";
                            unset($_SESSION['imageError']);
                        }
                        ?>
                        <form id="signup" action="" method="post" enctype="multipart/form-data"
                            onsubmit="return validateForm()">
                            <div class="profile-pic-container">
                                <img src="../../assets/images/officiallogo (1).png" alt="Profile Picture"
                                    id="profile-pic">
                                <label for="profile-upload" class="upload-icon">
                                    <i class="ri-camera-fill"></i>
                                </label>
                                <input type="file" id="profile-upload" name="image" accept="images/*" onchange="previewImage(event)">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="ap_firstname" class="form-label">First Name <span
                                            style="color: red;">*</span></label>
                                    <input type="text" class="form-control" id="ap_firstname" name="ap_firstname"
                                        placeholder="Enter your first name" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="ap_mi" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" name="ap_mi"
                                        placeholder="Enter your Middle name" id="ap_mi">
                                </div>
                                <div class="col-md-4">
                                    <label for="ap_lastname" class="form-label">Last Name <span
                                            style="color: red;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter your Last name"
                                        name="ap_lastname" id="ap_lastname" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="birthday" class="form-label">Birthday <span
                                            style="color: red;">*</span></label>
                                    <input type="date" class="form-control" name="birthday" id="birthday" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="number" class="form-control" name="age" placeholder="(Auto-filled)"
                                        id="age" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="username" class="form-label">Username <span
                                            style="color: red;">*</span></label>
                                    <input type="text" class="form-control" name="username"
                                        placeholder="Enter your Username" id="lastname" required>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label class="form-label">Address <span style="color: red;">*</span></label>
                                    <input type="text" name="full_address" class="form-control"
                                        placeholder="Enter your Address" id="address" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="contact_number" class="form-label">contact number <span
                                            style="color: red;">*</span></label>
                                    <input type="number" name="contact_number" class="form-control"
                                        placeholder="Enter your contact number" id="contact_number" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Sex <span style="color: red;">*</span></label>
                                    <select class="form-select" id="sex" name="sex" required>
                                        <option value="">Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span
                                            style="color: red;">*</span></label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Enter your E-mail" id="email" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password <span
                                            style="color: red;">*</span></label>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Enter your Password" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="confirm-password" class="form-label">Confirm Password <span
                                            style="color: red;">*</span></label>
                                    <input type="password" class="form-control" name="confirm_password"
                                        placeholder="Confirm Password" required>
                                </div>
                            </div>
                            <button type="submit" name="save" class="btn btn-success w-100 mb-3">Sign Up</button>
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
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js"></script>
    <script>
        $('#multiple-select-field').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
    </script>
    <!-- auto get the profile pic start -->
    <script>
        function triggerFileInput() {
            document.getElementById("fileInput").click();
        }

        function previewImage() {
            const fileInput = document.getElementById("fileInput");
            const profilePic = document.getElementById("profilePic");
            const file = fileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePic.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        document.getElementById("signup").addEventListener("submit", function(event) {
            const fileInput = document.getElementById("fileInput");
            if (!fileInput.files.length) {
                alert("Please upload your profile picture.");
                event.preventDefault(); // Prevent form submission
            }
        });
    </script>
    <!-- auto get the profile pic end -->
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('profile-pic');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

    <script>
        // Function to calculate age based on birthday
        function calculateAge(birthday) {
            const today = new Date();
            const birthDate = new Date(birthday);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDifference = today.getMonth() - birthDate.getMonth();
            // Adjust age if the birthday hasn't occurred yet this year
            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        }

        // Add an event listener to the birthday field
        document.getElementById('birthday').addEventListener('change', function() {
            const birthday = this.value; // Get the selected date
            const ageField = document.getElementById('age');
            if (birthday) {
                const age = calculateAge(birthday);
                ageField.value = age > 0 ? age : ""; // Set age or clear if invalid
            } else {
                ageField.value = ""; // Clear age if no date is selected
            }
        });
    </script>

</body>

</html>