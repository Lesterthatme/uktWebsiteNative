<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../../assets/images/officiallogo (1).png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University of Kratie || Admin</title>
  <!-- start css  -->
  <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/bootstrap/css/style.css?=v2.5">
  <!-- end css -->
  <!-- Remix icon -->
  <link rel="stylesheet" href="../../assets/RemixIcon/fonts/remixicon.css">
  <!-- Coloris CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.css" />


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
            <form action="">

              <div class="row">
                <div class="col-md-6 col-12">
                  <label class="fw-bold d-block mb-2"><i class="ri-h-2"></i> Site Title</label>
                  <input type="text" class="form-control mb-3" placeholder="Enter site title">
                </div>
                <div class="col-md-6 col-12">
                  <label class="fw-bold d-block mb-2"><i class="ri-image-line"></i> Site Logo</label>
                  <input type="file" class="form-control mb-3" accept="image/*">
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 col-12">
                  <label class="fw-bold d-block mb-2"><i class="ri-image-line"></i> Favicon</label>
                  <input type="file" class="form-control mb-3" accept="image/*">
                </div>
                <div class="col-md-6 col-12">
                  <label class="fw-bold d-block mb-2"><i class="ri-edit-line"></i> Site Description</label>
                  <input type="text" class="form-control mb-3" placeholder="Enter site description">
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 col-12">
                  <label class="fw-bold d-block mb-2"><i class="ri-image-line"></i> Update Header Image</label>
                  <input type="file" class="form-control mb-3" accept="image/*">
                </div>
                <div class="col-md-6 col-12">
                  <label class="fw-bold d-block mb-2"><i class="ri-landscape-line"></i> Update Background Image</label>
                  <input type="file" class="form-control mb-3" accept="image/*">
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 col-12">
                  <label class="fw-bold d-block mb-2"><i class="ri-landscape-line"></i> Update Partnership Background Image</label>
                  <input type="file" class="form-control mb-3" accept="image/*">
                </div>
                <div class="col-md-6 col-12">
                  <label class="fw-bold d-block mb-2"><i class="ri-image-edit-line"></i> Update Footer Image</label>
                  <input type="file" class="form-control mb-3" accept="image/*">
                </div>
              </div>

              <div class="row">
                <div class="mt-2">
                  <button class="btn btn-dynamic w-auto float-end"><i class="ri-save-fill"></i> Save Changes</button>
                </div>
              </div>
       
            </form>
            <hr>
            <div class="row">
              <div class="col">
                <div class="mt-1 d-flex align-items-center">
                  <label class="fw-bold d-inline-flex align-items-center mb-0">
                    <i class="ri-palette-line me-1"></i> Text/Button Color
                  </label>
                  <div id="colorIndicator" class="color-indicator ms-2"
                    style="background-color: #186428; width: 20px; height: 20px; border-radius: 50%; cursor: pointer;"
                    onclick="openColorPicker()" title="This is automatically saved when you select a color.">
                  </div>
                </div>
                <small class="text-muted">This is automatically saved when you select a color.</small>
              </div>
              <input id="colorInput" type="text" data-coloris>
            </div>

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
  <script src="../../assets/bootstrap/js/carousel.js?=v1.0"></script>
  <script src="../../assets/bootstrap/js/formDrag_and_Drop.js"></script>
  <script src="../../assets/bootstrap/js/activeLink.js?=v2.0"></script>
  <script src="../../assets/bootstrap/js/Logs.js"></script>
  <script src="../../assets/bootstrap/js/site_settings.js?v=1.8"></script>
  <!-- end js -->
  <script src="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.js"></script>


  <script>
    Coloris({
      el: '#colorInput',
      theme: 'default',
      themeMode: 'light',
      format: 'hex',
      clearButton: true,
      defaultColor: '#198754',
      swatches: [
        '#264653', '#2a9d8f', '#e9c46a', '#f4a261', '#e76f51',
        '#1d3557', '#457b9d', '#a8dadc', '#ff6b6b', '#198754'
      ],
      inline: false,
    });

    function openColorPicker() {
      document.getElementById('colorInput').click();
    }
    document.getElementById('colorInput').addEventListener('input', function() {
      document.getElementById('colorIndicator').style.backgroundColor = this.value;
    });
  </script>
</body>

</html>