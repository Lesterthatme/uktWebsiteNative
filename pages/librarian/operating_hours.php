<?php
include 'include/alert.php';
session_start();
if (!isset($_SESSION['session_token'])) {
    header('location:login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../../assets/images/officiallogo (1).png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University of Kratie || Librarian</title>
    <!-- start css  -->
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?v=2.8">
    <!-- end css -->
    <!-- Remix icon -->
    <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
        }

        .operating-hours {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .day-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
        }

        .toggle-switch {
            position: relative;
            width: 40px;
            height: 20px;
        }

        .toggle-switch input {
            display: none;
        }

        .toggle-slider {
            position: absolute;
            background-color: #ccc;
            border-radius: 20px;
            width: 100%;
            height: 100%;
            cursor: pointer;
            transition: 0.3s;
        }

        .toggle-slider::before {
            content: "";
            position: absolute;
            width: 14px;
            height: 14px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            border-radius: 50%;
            transition: 0.3s;
        }

        input:checked+.toggle-slider {
            background-color: #4CAF50;
        }

        input:checked+.toggle-slider::before {
            transform: translateX(20px);
        }

        .time-input {
            width: 120px;
            padding: 6px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .time-input:disabled {
            background: #eee;
            color: #999;
            cursor: not-allowed;
        }
    </style>
</head>

<body class="bg-light">
    <!-- include side bar start -->
    <?php include 'include/sidebar.php';
    ?>
    <!-- include side bar end -->

    <main class="bg-light">

        <!-- include navbar start -->
        <?php include 'include/navbar.php';
        ?>
        <div class="p-4">
            <div class="row">
                <div class="card border-0 pb-3">
                    <div class="card-body">
                        <div class="doc-tabs-container mt-3">
                            <ul class="doc-tabs d-flex list-unstyled">
                                <li class="me-3">
                                    <a class="doc-link" href="University_Library_updates">Library Updates</a>
                                </li>
                                <li class="me-3">
                                    <a class="doc-link" href="University_Library_resources">Library Resources</a>
                                </li>
                                <li class="me-3">
                                    <a class="doc-link active" href="operating_hours">Operating Hours</a>
                                </li>
                                <li class="me-3">
                                    <a class="doc-link" href="University_Library_Research_Projects">Research
                                        Projects</a>
                                </li>

                            </ul>
                            <hr class="doc-tabs-divider">
                        </div>

                        <div class="d-flex flex-column flex-md-row align-items-md-center mb-3">
                            <p class="mb-2 mb-md-0 flex-grow-1">
                                Library Operating Hours.
                            </p>
                        </div>
                        <div class="container mt-4">
                            <div class="operating-hours">
                                <h5 class="text-center">Set Library Operating Hours</h5>
                                <p class="text-muted text-center">Configure the standard hours of operation.</p>
                                <div id="hoursContainer"></div>
                                <div class="d-flex justify-content-between mt-3">
                                    <button id="saveBtn" type="submit" class="btn btn-dynamic">Save Schedule</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'include/footer.php'; ?>
    </main>

    <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
    <script src="../../assets/bootstrap/js/script.js"></script>
    <script src="../../assets/bootstrap/js/carousel.js"></script>
    <script src="../../assets/bootstrap/js/drag_and_drop.js?=v1.1"></script>
    <script src="../../assets/bootstrap/js/activeLink.js?v=1.6"></script>
    <script src="../../assets/bootstrap/js/logs.js?v=1.4"></script>
    <script src="../../assets/bootstrap/js/site_settings.js?v=1.0"></script>

    <script>
        const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        const hoursContainer = document.getElementById("hoursContainer");

        function fetchSchedule() {
            fetch("get_schedule.php")
                .then(response => response.json())
                .then(data => {
                    hoursContainer.innerHTML = "";
                    days.forEach(day => {
                        let schedule = data.schedule.find(d => d.day === day) || {
                            is_open: 0,
                            open_time: "09:00",
                            close_time: "17:00"
                        };
                        let isChecked = schedule.is_open == 1 ? "checked" : "";
                        let disabled = schedule.is_open == 1 ? "" : "disabled";

                        hoursContainer.innerHTML += `
                        <div class="day-row">
                            <strong>${day}</strong>
                            <label class="toggle-switch">
                                <input type="checkbox" id="${day}-toggle" ${isChecked}>
                                <span class="toggle-slider"></span>
                            </label>
                            <input type="time" class="time-input" id="${day}-open" value="${schedule.open_time}" ${disabled}>
                            <span>to</span>
                            <input type="time" class="time-input" id="${day}-close" value="${schedule.close_time}" ${disabled}>
                        </div>
                    `;
                    });

                    document.querySelectorAll(".toggle-switch input").forEach(toggle => {
                        toggle.addEventListener("change", function () {
                            let day = this.id.replace("-toggle", "");
                            document.getElementById(`${day}-open`).disabled = !this.checked;
                            document.getElementById(`${day}-close`).disabled = !this.checked;
                        });
                    });
                });
        }

        fetchSchedule();

        document.getElementById("saveBtn").addEventListener("click", function () {
            let scheduleData = [];
            document.querySelectorAll(".day-row").forEach(row => {
                let day = row.querySelector("strong").textContent;
                let isOpen = row.querySelector("input[type='checkbox']").checked ? 1 : 0;
                let openTime = row.querySelector("input[type='time']").value;
                let closeTime = row.querySelectorAll("input[type='time']")[1].value;

                scheduleData.push({
                    day,
                    is_open: isOpen,
                    open_time: isOpen ? openTime : null,
                    close_time: isOpen ? closeTime : null
                });
            });

            fetch("save_schedule.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    schedule: scheduleData
                })
            })
                .then(response => response.json())
                .then(data => alert(data.message));
        });
    </script>

    <!-- START >> JS SCRIPT IN ALERT -->
    <script>
        document.getElementById("saveBtn").addEventListener("click", function () {
    let scheduleData = [];
    document.querySelectorAll(".day-row").forEach(row => {
        let day = row.querySelector("strong").textContent;
        let isOpen = row.querySelector("input[type='checkbox']").checked ? 1 : 0;
        let openTime = row.querySelector("input[type='time']").value;
        let closeTime = row.querySelectorAll("input[type='time']")[1].value;

        scheduleData.push({
            day,
            is_open: isOpen,
            open_time: isOpen ? openTime : null,
            close_time: isOpen ? closeTime : null
        });
    });

    fetch("save_schedule.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ schedule: scheduleData })
    })
    .then(response => response.json())
    .then(data => {
        showToast(
            data.status === "success" ? "toast-success" : "toast-error", 
            data.status === "success" ? "Success" : "Failed", 
            data.message
        );
    });
});
    </script>
    <!-- END >> JS SCRIPT IN ALERT -->

</body>

</html>