<?php
include 'connection/dbconnection.php';

$query = "SELECT job_id, job_description, posted_date, application_deadline, contact_email
          FROM job_opportunities 
          WHERE up_id = 1 
          LIMIT 1";

$result = mysqli_query($conn, $query);
$job_data = mysqli_fetch_assoc($result);
?>

<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="container py-5">
                <h3 class="my-4 section-title">Job Opportunities</h3>
                <?php if ($job_data): ?>
                    <!-- Job description rendered with HTML from Summernote -->
                    <div class="lead">
                        <?php echo $job_data['job_description']; ?>
                    </div>

                    <p>
                        <strong>Contact Email:</strong>
                        <?php echo htmlspecialchars($job_data['contact_email']); ?>
                    </p>

                    <p class="text-muted mb-0">
                        <strong>Application Deadline:</strong>
                        <?php echo date("F j, Y", strtotime($job_data['application_deadline'])); ?>
                    </p>

                    <p class="text-muted mb-0">
                        <strong>Date Posted:</strong>
                        <?php echo date("F j, Y", strtotime($job_data['posted_date'])); ?>
                    </p>
                <?php else: ?>
                    <p class="text-danger">No job opportunity found.</p>
                <?php endif; ?>
            </div>

            <h3 class="my-4 section-title">Job vacancies</h3>

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
                // Fetch job vacancies
                $query = "SELECT job_position, manpower_need, date_posted, job_forms, remarks, location FROM job_vacancy ORDER BY date_posted DESC";
                $result = mysqli_query($conn, $query);
                
                if (!$result) {
                    die("Query failed: " . $conn->error);
                }

                $fileIcons = [
                    'pdf' => 'ri-file-pdf-line text-danger text-center',
                    'doc' => 'ri-file-word-line text-primary',
                    'docx' => 'ri-file-word-line text-primary',
                    'xls' => 'ri-file-excel-line text-success text-center',
                    'xlsx' => 'ri-file-excel-line text-success',
                    'csv' => 'ri-file-excel-line text-success',
                    'ppt' => 'ri-file-ppt-line text-warning',
                    'pptx' => 'ri-file-ppt-line text-warning',
                    'txt' => 'ri-file-text-line text-muted',
                    'zip' => 'ri-folder-zip-line text-secondary',
                    'rar' => 'ri-folder-zip-line text-secondary',
                    'default' => 'ri-file-line text-dark'
                ];

                if ($result->num_rows > 0):
                ?>
                <table class="table table-bordered" id="activityTable">
                    <thead style="font-size:13px">
                        <tr>
                            <th class="text-center">Position</th>
                            <th class="text-center">No. of Vacancies</th>
                            <th class="text-center">Date Posted</th>
                            <th class="text-center">Campus/College/Office</th>
                            <th class="text-center">Remarks</th>
                            <th class="text-center">Attachment</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody style="font-size:13px">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center"><?= $row['job_position'] ?></td>
                                <td class="text-center"><?= $row['manpower_need'] ?></td>
                                <td class="text-center"><?= date('F d, Y', strtotime($row['date_posted'])) ?></td>
                                <td class="text-center"><?= $row['location'] ?></td>
                                <td class="text-center">
                                    <?php if ($row['remarks'] === 'Filled'): ?>
                                        <span class="badge bg-success"><?= $row['remarks'] ?></span>
                                    <?php elseif ($row['remarks'] === 'Unfilled'): ?>
                                        <span class="badge bg-danger"><?= $row['remarks'] ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?= $row['remarks'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($row['job_forms'])):
                                        $filePath = str_replace('../', '', $row['job_forms']);
                                        $fileExt = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                        $iconClass = $fileIcons[$fileExt] ?? $fileIcons['default'];
                                    ?>
                                        <a href="<?= $filePath ?>" target="_blank" class="text-decoration-none" title="Open File">
                                            <i class="<?= $iconClass ?>" style="font-size: 24px;"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">No Attachment</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($row['job_forms'])): ?>
                                        <a href="<?= $filePath ?>" download class="download-link" title="Download File">
                                            <i class="ri-download-2-line" style="font-size: 24px;"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No Job Vacancy available</td>
                    </tr>
                <?php endif; ?>
            </div>
                      <div class="d-flex justify-content-center">
            <ul class="pagination custom-pagination mt-2"></ul>
          </div>
        </div>

        <!-- Sidebar column (4 columns on large screens) -->
        <div class="col-lg-4 sidebar mt-0">
            <?php include 'widgets.php'; ?>
        </div>
    </div>
</div>