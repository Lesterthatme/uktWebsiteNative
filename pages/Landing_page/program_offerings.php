<?php include 'banner.php'; ?>
<?php include 'breadcrumbs.php'; ?>
<?php
include 'connection/dbconnection.php';

$dept_query = "SELECT * FROM department ORDER BY department_id ASC";
$dept_result = mysqli_query($conn, $dept_query);
?>

<div class="container py-4">
    <div class="row">
        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
            <div class="row">
                <div class="col p-4 mt-4">
                    <div class="accordion" id="departmentAccordion">
                        <?php if (mysqli_num_rows($dept_result) > 0): ?>
                            <?php $index = 0; ?>
                            <?php while ($dept = mysqli_fetch_assoc($dept_result)):
                                $dept_id = $dept['department_id'];
                                $dept_name = htmlspecialchars($dept['dm_name']);

                                $prog_query = "SELECT program_name, course_code, program_description FROM program_offering WHERE department_id = $dept_id";
                                $prog_result = mysqli_query($conn, $prog_query);

                                $collapseId = 'collapse' . $index;
                                $headingId = 'heading' . $index;

                                $isFirst = ($index === 0);
                                $buttonClass = $isFirst ? 'accordion-button d-flex align-items-center' : 'accordion-button collapsed d-flex align-items-center';
                                $collapseClass = $isFirst ? 'accordion-collapse collapse show' : 'accordion-collapse collapse';
                                $ariaExpanded = $isFirst ? 'true' : 'false';
                            ?>
                                <div class="accordion-item mb-2 border rounded">
                                    <h3 class="accordion-header" id="<?= $headingId ?>">
                                        <button class="<?= $buttonClass ?>" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>"
                                            aria-expanded="<?= $ariaExpanded ?>" aria-controls="<?= $collapseId ?>">
                                            <span class="toggle-icon me-2"><?= $isFirst ? '−' : '+' ?></span>
                                            <strong><?= $dept_name ?></strong>
                                        </button>
                                    </h3>
                                    <div id="<?= $collapseId ?>" class="<?= $collapseClass ?>"
                                        aria-labelledby="<?= $headingId ?>" data-bs-parent="#departmentAccordion">
                                        <div class="accordion-body">
                                            <?php if (mysqli_num_rows($prog_result) > 0): ?>
                                                <ul style="list-style-type: none; padding-left: 0;">
                                                    <?php while ($program = mysqli_fetch_assoc($prog_result)): ?>
                                                        <li>
                                                            <button class="btn border-0 bg-transparent p-0 m-0 text-start"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#programModal"
                                                                onclick="showProgramDescription(`<?= $program['program_description'] ?>`)">
                                                                <?= htmlspecialchars($program['program_name']) ?> (<?= htmlspecialchars($program['course_code']) ?>)
                                                            </button>

                                                        </li>

                                                    <?php endwhile; ?>
                                                </ul>
                                            <?php else: ?>
                                                <p class="text-danger">No programs available under this department.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php $index++; ?>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="text-danger">No departments found.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4 sidebar" data-aos="fade-up" data-aos-delay="200">
            <?php include 'widgets.php'; ?>
        </div>
    </div>
</div>

<!-- Modal for Program Description START -->
<div class="modal fade" id="programModal" tabindex="-1" role="dialog" aria-labelledby="programModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="programModalLabel"><strong>Program Description</strong></h5>
            </div>
            <div class="modal-body" id="programDescription">
                <!-- Description will be injected here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Program Description END -->

<!-- Custom Styling -->
<style>
    .accordion-button::after,
    .accordion-button::before {
        display: none !important;
        content: none !important;
    }

    .accordion-button {
        background-color: #fff !important;
        color: #212529 !important;
        font-size: 1rem;
        font-weight: 600;
        padding: 0.75rem 1rem;
        box-shadow: none !important;
        border: none !important;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        outline: none !important;
    }

    .accordion-button:focus,
    .accordion-button:active,
    .accordion-button:not(.collapsed) {
        background-color: #fff !important;
        color: #212529 !important;
        box-shadow: none !important;
        border: none !important;
        outline: none !important;
    }

    .accordion-item {
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .toggle-icon {
        font-size: 1rem;
        color: #212529 !important;
        width: 20px;
        display: inline-block;
        transition: all 0.3s ease;
    }
</style>

<!-- JavaScript to toggle + and − -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.accordion-button');

        buttons.forEach(function(button) {
            const icon = button.querySelector('.toggle-icon');
            const targetSelector = button.getAttribute('data-bs-target');
            const collapseEl = document.querySelector(targetSelector);

            if (collapseEl.classList.contains('show')) {
                icon.textContent = '−';
            }

            collapseEl.addEventListener('show.bs.collapse', function() {
                icon.textContent = '−';
            });

            collapseEl.addEventListener('hide.bs.collapse', function() {
                icon.textContent = '+';
            });
        });
    });

    // Function to show the program description in the modal
    function showProgramDescription(description) {
        document.getElementById("programDescription").innerHTML = description;
    }
</script>