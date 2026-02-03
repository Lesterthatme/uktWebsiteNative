<section class="news-section p-4 my-3" data-aos="fade-up" data-aos-duration="2000">
  <h2>Research Projects</h2>
  <p class="news-text-muted">ព័ត៌មានបណ្តាញបណ្ណាល័យ</p>

  <div class="container bg-white">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
      <div class="d-flex align-items-center mb-md-0">
        <label class="me-2 text-dark">Show</label>
        <select id="entriesSelect" class="form-select custom-dropdown">
          <option value="5">5</option>
          <option value="10" selected>10</option>
          <option value="15">15</option>
          <option value="20">20</option>
        </select>
        <label class="ms-2 me-3 text-dark">entries</label>
      </div>
      <div class="search-container me-2">
        <i class="ri-search-line"></i>
        <input type="text" id="searchBar" class="form-control" placeholder="Search" />
      </div>
      <div class="d-flex align-items-center ms-md-auto mt-1">

        <select id="sortBy" class="form-select">
          <option value="">Sort By</option>
          <option value="date">Sort by Date</option>
          <option value="time">Sort by Time</option>
        </select>
      </div>
    </div>
    <div class="table-container">
      <?php
      include 'connection/dbconnection.php';
      $query = "SELECT research_id, research_title, researcher_name, research_adviser, publication_year, research_type 
          FROM research_project 
          ORDER BY publication_year DESC";

      $result = mysqli_query($conn, $query);
      ?>
      <div class="table-responsive">
        <table class="table table-hover table-bordered" id="activityTable">
          <thead>
            <tr>
              <th>Title</th>
              <th>Author</th>
              <th>Research Adviser</th>
              <th>Publication Year</th>
              <th>Category</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['research_title']); ?></td>
                  <td><?php echo htmlspecialchars($row['researcher_name']); ?></td>
                  <td><?php echo htmlspecialchars($row['research_adviser']); ?></td>
                  <td><?php echo htmlspecialchars($row['publication_year']); ?></td>
                  <td><?php echo htmlspecialchars($row['research_type']); ?></td>
                </tr>
                <?php
              }
            } else {
              echo "<tr><td colspan='5' class='text-center text-danger'>No research projects found.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>


      <div class="d-flex justify-content-center">
        <ul class="pagination custom-pagination mt-2"></ul>
      </div>
    </div>
  </div>
</section>