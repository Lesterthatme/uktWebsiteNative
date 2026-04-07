<?php
include 'connection/dbconnection.php';

$query = "SELECT university_mission, university_vision, university_goal, university_core FROM university_vmgo";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

$mission = $vision = $goal = $core =  "";

if ($row = mysqli_fetch_assoc($result)) {
    $mission = $row['university_mission'];
    $vision = $row['university_vision'];
    $goal = $row['university_goal'];
    $core = $row['university_core'];
}
?>

<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>

<div class="container">
    <div class="row my-5 justify-content-center">

        <!-- VISION -->
        <div class="col-md-4 mb-2">
            <div class="vmgo_card vision p-4 text-start">

                <div class="d-flex flex-row justify-content-center align-items-center gap-2 mb-3">
                    <i class="ri-eye-line"></i>
                    <h5 class="mb-0">ចក្ខុវិស័យ</h5>
                </div>

                <div class="w-100 flex-grow-1">
                    <?php echo $vision; ?>
                </div>

            </div>
        </div>

        <!-- MISSION -->
        <div class="col-md-4 mb-2">
            <div class="vmgo_card mission p-4 text-start">

                <div class="d-flex flex-row justify-content-center align-items-center gap-2 mb-3">
                    <i class="ri-flag-line"></i>
                    <h5 class="mb-0">បេសកកម្ម</h5>
                </div>

                <div class="w-100 flex-grow-1">
                    <?php echo $mission; ?>
                </div>

            </div>
        </div>

        <!-- GOALS -->
        <div class="col-md-4 mb-2">
            <div class="vmgo_card goal p-4 text-start">

                <div class="d-flex flex-row justify-content-center align-items-center gap-2 mb-3">
                    <i class="ri-trophy-line"></i>
                    <h5 class="mb-0">គោលដៅ</h5>
                </div>

                <div class="w-100 flex-grow-1">
                    <?php echo $goal; ?>
                </div>

            </div>
        </div>
        <div class="col-12 mb-2">
            <div class="vmgo_card core p-4 text-start">
                <div class="d-flex flex-row justify-content-start align-items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <h5 class="mb-0">តម្លៃស្នូល</h5>
                </div>

                <p class="flex-grow-1">
                    ដើម្បីសម្រេចបាននូវចក្ខុវិស័យ និងបេសកកម្មខាងលើ យើងខ្ញុំប្តេជ្ញាកែលម្អតម្លៃដែលមានស្រាប់ និងបន្តលើកកម្ពស់ និងធានាបាននូវមូលដ្ឋានគ្រឹះក្នុងការកសាងវប្បធម៌នៃការចែករំលែក និងប្រសិទ្ធភាពក្នុងប្រតិបត្តិការនៅក្នុងសាកលវិទ្យាល័យ ដូចបានរៀបរាប់ខាងក្រោម៖
                </p>
                <div class="flex-grow-1">
                    <?php echo $core; ?>
                </div>


            </div>
        </div>

    </div>

</div>