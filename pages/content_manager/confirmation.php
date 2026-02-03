<?php
include '../../connection/dbconnection.php';

?>
<!-- START >> HIGHLIGHTS DELETE CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="confirmationModal-Hightlights" onclick="closeModalOutside(event)"
    style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p>Do you want to remove this item? This action cannot be undone.</p>
        <div class="custom-confirmation-button-container">
            <button class="custom-confirmation-button custom-confirmation-cancel-btn"
                onclick="closeModal()">Cancel</button>
            <a id="confirmDelete"
                class="custom-confirmation-button custom-confirmation-remove-btn text-decoration-none">Remove</a>
        </div>
    </div>
</div>
<!-- START >> HIGHLIGHTS DELETE CONFIRMATION MODAL -->

<!-- START >> NEWS DELETE CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="deleteConfirmationModal-news" onclick="closeModalOutside(event)"
     style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p>Do you want to delete <strong id="newsTitlePlaceholder"></strong>? This action cannot be undone.</p>
        <form id="deleteNewsForm" method="POST" action="../../function/content_manager/news_function.php">
            <input type="hidden" name="news_id" id="modalNewsId">
            <input type="hidden" name="delete_news" value="1">
            <div class="custom-confirmation-button-container">
                <button type="button" class="custom-confirmation-button custom-confirmation-cancel-btn"
                        onclick="closeModal()">Cancel
                </button>
                <button type="submit" name="deleteNews"
                        class="custom-confirmation-button custom-confirmation-remove-btn">Delete
                </button>
            </div>
        </form>
    </div>
</div>
<!-- END >> NEWS DELETE CONFIRMATION MODAL -->

<!-- START >> PARTNERSHIP DELETE CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="confirmationModal-partnership" onclick="closeModalOutside(event)"
    style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p>Do you want to remove this partnership? This action cannot be undone.</p>
        <form id="deleteForm" method="POST" action="../../function/content_manager/partnership_function.php">
            <input type="hidden" name="up_id" id="modalUpId">
            <input type="hidden" name="delete_partnership" value="1">
            <div class="custom-confirmation-button-container">
                <button type="button" class="custom-confirmation-button custom-confirmation-cancel-btn"
                    onclick="closeModal()">Cancel</button>
                <button type="submit" class="custom-confirmation-button custom-confirmation-remove-btn">Remove</button>
            </div>
        </form>
    </div>
</div>
<!-- END >> PARTNERSHIP DELETE CONFIRMATION MODAL -->

<!-- START >> DELETE CALENDAR CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="confirmationModal-calendar" onclick="closeModalOutside(event)"
    style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p>Do you want to remove this event? This action cannot be undone.</p>
        <form id="deleteForm" method="POST" action="../../function/content_manager/event_calendar.php">
            <input type="hidden" name="uc_id" id="modalUcId">
            <input type="hidden" name="delete" value="1">
            <div class="custom-confirmation-button-container">
                <button type="button" class="custom-confirmation-button custom-confirmation-cancel-btn"
                    onclick="closeModal()">Cancel</button>
                <button type="submit" class="custom-confirmation-button custom-confirmation-remove-btn">Remove</button>
            </div>
        </form>
    </div>
</div>
<!-- END >> DELETE CALENDAR CONFIRMATION MODAL -->

<!-- START >> PAGE POSTER DELETE CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="confirmationModal" onclick="closeModalOutside(event)"
    style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p>Do you want to remove this poster? This action cannot be undone.</p>
        <form id="deleteForm" method="POST" action="../../function/content_manager/poster_function.php">
            <input type="hidden" name="poster_id" id="modalPosterId">
            <input type="hidden" name="delete" value="1">
            <div class="custom-confirmation-button-container">
                <button type="button" class="custom-confirmation-button custom-confirmation-cancel-btn"
                    onclick="closeModal()">Cancel</button>
                <button type="submit" class="custom-confirmation-button custom-confirmation-remove-btn">Remove</button>
            </div>
        </form>
    </div>
</div>
<!-- START >> PAGE POSTER DELETE CONFIRMATION MODAL -->

<!-- START >> FAQ DELETE  CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="confirmationModal-faq" onclick="closeModalOutside(event)"
    style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p>Do you want to remove this FAQ? This action cannot be undone.</p>
        <form id="deleteForm" method="POST" action="../../function/content_manager/faq_function.php">
            <input type="hidden" name="faq_id" id="modalFaqId">
            <input type="hidden" name="delete" value="1">
            <div class="custom-confirmation-button-container">
                <button type="button" class="custom-confirmation-button custom-confirmation-cancel-btn"
                    onclick="closeModal()">Cancel</button>
                <button type="submit" class="custom-confirmation-button custom-confirmation-remove-btn">Remove</button>
            </div>
        </form>
    </div>
</div>
<!-- END >> FAQ DELETE  CONFIRMATION MODAL -->

<!-- START >> DELETE  CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="confirmationModal-announcement" onclick="closeModalOutside(event)"
    style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p>Do you want to delete this announcement? This action cannot be undone.</p>
        <form id="deleteForm" method="POST" action="../../function/content_manager/announcement_function.php">
            <input type="hidden" name="announcement_id" id="modalAnnouncementId">
            <input type="hidden" name="delete" value="1">
            <div class="custom-confirmation-button-container">
                <button type="button" class="custom-confirmation-button custom-confirmation-cancel-btn"
                    onclick="closeModal()">Cancel</button>
                <button type="submit" class="custom-confirmation-button custom-confirmation-remove-btn">Remove</button>
            </div>
        </form>
    </div>
</div>
<!-- END >> DELETE  CONFIRMATION MODAL -->

<!-- START >> NEWS DELETE  CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="deleteConfirmationModal-news" onclick="closeModalOutside(event)"
    style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p>Do you want to delete this news? This action cannot be undone.</p>
        <form id="deleteNewsForm" method="POST" action="../../function/content_manager/news_function.php">
            <input type="hidden" name="news_id" id="modalNewsId">
            <input type="hidden" name="delete_news" value="1">
            <div class="custom-confirmation-button-container">
                <button type="button" class="custom-confirmation-button custom-confirmation-cancel-btn"
                    onclick="closeModal()">Cancel</button>
                <button type="submit" class="custom-confirmation-button custom-confirmation-remove-btn">Delete</button>
            </div>
        </form>
    </div>
</div>
<!-- END >> NEWS DELETE  CONFIRMATION MODAL -->

<!-- START >> DELETE CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="deleteConfirmationModal-faculty" onclick="closeModalOutside(event)"
    style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p>Do you want to delete <strong id="facultyNamePlaceholder"></strong>? This action cannot be undone.</p>
        <form id="deleteFacultyForm" method="POST" action="../../function/content_manager/department_function.php">
            <input type="hidden" name="fm_id" id="modalFacultyId">
            <input type="hidden" name="delete_faculty" value="1">
            <div class="custom-confirmation-button-container">
                <button type="button" class="custom-confirmation-button custom-confirmation-cancel-btn"
                    onclick="closeModal()">Cancel</button>
                <button type="submit" class="custom-confirmation-button custom-confirmation-remove-btn">Delete</button>
            </div>
        </form>
    </div>
</div>
<!-- END >> DELETE CONFIRMATION MODAL -->

<!-- START >> BOARD OF DIRECTORS DELETE CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="deleteConfirmationModal-director" onclick="closeModalOutside(event)"
    style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p>Do you want to delete <strong id="directorNamePlaceholder"></strong>? This action cannot be undone.</p>
        <form id="deleteDirectorForm" method="POST" action="../../function/content_manager/boardofdirector_function.php">
            <input type="hidden" name="director_id" id="modalDirectorId">
            <input type="hidden" name="delete_director" value="1">
            <div class="custom-confirmation-button-container">
                <button type="button" class="custom-confirmation-button custom-confirmation-cancel-btn"
                    onclick="closeModal()">Cancel</button>
                <button type="submit" name="deleteDirector"
                    class="custom-confirmation-button custom-confirmation-remove-btn">Delete</button>
            </div>
        </form>
    </div>
</div>
<!-- END >> BOARD OF DIRECTORS DELETE CONFIRMATION MODAL -->

<!-- START >> RECTOR DELETE CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="deleteConfirmationModal-rector" onclick="closeModalOutside(event)"
    style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p>Do you want to delete <strong id="RectorNamePlaceholder"></strong>? This action cannot be undone.</p>
        <form id="deleteRectorForm" method="POST" action="../../function/content_manager/rector_function.php">
            <input type="hidden" name="rector_id" id="modalRectorId">
            <input type="hidden" name="delete_rector" value="1">
            <div class="custom-confirmation-button-container">
                <button type="button" class="custom-confirmation-button custom-confirmation-cancel-btn"
                    onclick="closeModal()">Cancel</button>
                <button type="submit" name="deleteRector"
                    class="custom-confirmation-button custom-confirmation-remove-btn">Delete</button>
            </div>
        </form>
    </div>
</div>
<!-- END >> RECTOR DELETE CONFIRMATION MODAL -->

<!-- START >> DEAN DELETE CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="deleteConfirmationModal-dean" onclick="closeModalOutside(event)" style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p>Do you want to delete <strong id="deanNamePlaceholder"></strong>? This action cannot be undone.</p>
        <form id="deleteDeanForm" method="POST" action="../../function/content_manager/dean_function.php">
            <input type="hidden" name="dean_id" id="modalDeanId">
            <input type="hidden" name="delete_dean" value="1">
            <div class="custom-confirmation-button-container">
                <button type="button" class="custom-confirmation-button custom-confirmation-cancel-btn" onclick="closeModal()">Cancel</button>
                <button type="submit" name="deleteDean" class="custom-confirmation-button custom-confirmation-remove-btn">Delete</button>
            </div>
        </form>
    </div>
</div>
<!-- END >> DEAN DELETE CONFIRMATION MODAL -->

<!-- START >> FORM DELETE CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="deleteConfirmationModal-Form" onclick="closeModalOutside(event)" style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p>Do you want to delete <strong id="FormNamePlaceholder"></strong>? This action cannot be undone.</p>
        <form id="deleteForm" method="POST" action="../../function/content_manager/downloadable_formfunction.php">
            <input type="hidden" name="form_id" id="modalFormId">
            <input type="hidden" name="delete_form" value="1">
            <div class="custom-confirmation-button-container">
                <button type="button" class="custom-confirmation-button custom-confirmation-cancel-btn" onclick="closeModal()">Cancel</button>
                <button type="submit" name="deleteForm" class="custom-confirmation-button custom-confirmation-remove-btn">Delete</button>
            </div>
        </form>
    </div>
</div>
<!-- END >> FORM DELETE CONFIRMATION MODAL -->

<!-- START >> PROGRAM DELETE CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="confirmationModal-program" onclick="closeModalOutside(event)" style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p>Do you want to delete <strong id="programTitlePlaceholder"></strong>? This action cannot be undone.</p>
<form method="POST" action="../../function/content_manager/programoffered_function.php">
    <input type="hidden" name="program_id" id="modalProgramId">
    <input type="hidden" name="department_id" id="modalDepartmentId"> <!-- New input field -->
    <div class="custom-confirmation-button-container">
        <button class="custom-confirmation-button custom-confirmation-cancel-btn" onclick="closeModal()">Cancel</button>
        <button type="submit" name="deleteProgram" class="custom-confirmation-button custom-confirmation-remove-btn">Delete</button>
    </div>
</form>

    </div>
</div>
<!-- END >> PROGRAM DELETE CONFIRMATION MODAL -->