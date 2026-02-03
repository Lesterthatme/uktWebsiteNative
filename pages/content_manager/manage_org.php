<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../../assets/images/officiallogo (1).png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University of Kratie || Admin</title>
  <!-- start css  -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?v=2.8">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">


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
    <!-- include navbar end -->

    <!-- start: Content -->
    <div class="p-4">
      <div class="row">
         

      <div class="card border-0 pb-3">
          <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            </div>
            <p class="card-text text-muted small"></p>
            <div class="doc-tabs-container mt-3">
              <ul class="doc-tabs d-flex list-unstyled">
                <li class="me-3">
                <a class="doc-link active" href="#" data-page="about_org.php">Background</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="#" >Announcement</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="">Seminars</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="#">Workshop</a>
                </li>
                <li class="me-3">
                  <a class="doc-link" href="#">Officers</a>
                </li>
              </ul>
              <hr class="doc-tabs-divider">
            </div>
            
            <div class="content_org">

            </div>

          </div>
        </div>
      </div>
      <?php include 'include/footer.php'; ?>
    </div>
  </main>

  <!-- start js -->

  <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/bootstrap/js/jquery-3.7.1.js"></script>
  <script src="../../assets/bootstrap/js/script.js"></script>
  <script src="../../assets/bootstrap/js/carousel.js"></script>
  <script src="../../assets/bootstrap/js/drag_and_drop.js?=v1.1"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?v=1.89"></script>
  <script src="../../assets/bootstrap/js/logs.js?v=1.4"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.1"></script>
  <script>
        $(document).ready(function () {
    function loadContent(page) {
        console.log("Attempting to load:", page);
        $(".content_org").load(page, function (response, status, xhr) {
            if (status === "error") {
                console.error("Error loading page:", xhr.status, xhr.statusText);
            } else {
                console.log("Page loaded successfully:", page);
                console.log(response); // Log the loaded content
                
                // After loading, reattach event listeners and re-execute scripts
                reinitializeScripts();
            }
        });
    }

    function reinitializeScripts() {
        console.log("Rebinding event listeners and scripts...");

        // Reinitialize Bootstrap components (modals, dropdowns, etc.)
        $(".modal").modal();

        // Rebind event listeners (example: modal button)
        $(document).on("click", "[data-bs-toggle='modal']", function () {
            console.log("Modal triggered:", $(this).data("bs-target"));
        });

        // Reload external JS files (drag & drop, etc.)
        let scriptPaths = [
            "../../assets/bootstrap/js/script.js",
            "../../assets/bootstrap/js/carousel.js",
            "../../assets/bootstrap/js/drag_and_drop.js?v=2.1",
            "../../assets/bootstrap/js/activeLink.js?v=1.7",
            "../../assets/bootstrap/js/logs.js?v=1.4",
            "../../assets/bootstrap/js/site_settings.js?v=1.0"
        ];

        scriptPaths.forEach(path => {
            let script = document.createElement("script");
            script.src = path;
            script.defer = true;
            document.body.appendChild(script);
            script.onload = function () {
                console.log("Script loaded:", path);
            };
        });
    }

    // Load first tab automatically
    let firstTab = $(".doc-link.active");
    if (firstTab.length) {
        loadContent(firstTab.data("page"));
    }

    // Handle tab switching
    $(document).on("click", ".doc-link", function (e) {
        e.preventDefault();
        let page = $(this).data("page");
        loadContent(page);

        $(".doc-link").removeClass("active");
        $(this).addClass("active");
    });
});

    </script>
  <!-- end js -->
</body>

</html>