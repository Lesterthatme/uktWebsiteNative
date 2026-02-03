<?php
include '../../connection/dbconnection.php';

?>
<!-- START >> LIBRARY UPDATES DELETE CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="confirmationModal-LibraryUpdates" onclick="closeModalOutside(event)" style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p>Do you want to remove this item? This action cannot be undone.</p>
        <div class="custom-confirmation-button-container">
            <button class="custom-confirmation-button custom-confirmation-cancel-btn" onclick="closeModal()">Cancel</button>
            <a id="UpdatesconfirmDelete" class="custom-confirmation-button custom-confirmation-remove-btn text-decoration-none">Remove</a>
        </div>
    </div>
</div>
<!-- START >> LIBRARY UPDATES DELETE CONFIRMATION MODAL -->


<!-- START >> LIBRARY RESOURCES DELETE CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="confirmationModal-LibraryResources" onclick="closeModalOutside(event)" style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p>Do you want to remove this item? This action cannot be undone.</p>
        <div class="custom-confirmation-button-container">
            <button class="custom-confirmation-button custom-confirmation-cancel-btn" onclick="closeModal()">Cancel</button>
            <a id="ResourcesconfirmDelete" class="custom-confirmation-button custom-confirmation-remove-btn text-decoration-none">Remove</a>
        </div>
    </div>
</div>
<!-- END >> LIBRARY RESOURCES DELETE CONFIRMATION MODAL -->

<!-- START >> RESEARCH PROJECTS DELETE CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="confirmationModal-Research-Projects" onclick="closeModalOutside(event)" style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p id="researchTitleDisplay">Do you want to remove this research project? This action cannot be undone.</p>
        <div class="custom-confirmation-button-container">
            <button class="custom-confirmation-button custom-confirmation-cancel-btn" onclick="closeModal()">Cancel</button>
            <a id="ResearchconfirmDelete" class="custom-confirmation-button custom-confirmation-remove-btn text-decoration-none">Remove</a>
        </div>
    </div>
</div>
<!-- END >> RESEARCH PROJECTS DELETE CONFIRMATION MODAL -->

<!-- START >> STAFF DELETE CONFIRMATION MODAL -->
<div class="custom-confirmation-modal-overlay" id="confirmationModal-staff" onclick="closeModalOutside(event)" style="display: none;">
    <div class="custom-confirmation-modal-box">
        <div class="custom-confirmation-icon"><i class="ri-alert-line"></i></div>
        <h2>Are you sure?</h2>
        <p id="staffTitleDisplay">Do you want to remove this staff member? This action cannot be undone.</p>
        <div class="custom-confirmation-button-container">
            <button class="custom-confirmation-button custom-confirmation-cancel-btn" onclick="closeModal()">Cancel</button>
            <a id="staffconfirmDelete" class="custom-confirmation-button custom-confirmation-remove-btn text-decoration-none">Remove</a>
        </div>
    </div>
</div>
<!-- END >> STAFF DELETE CONFIRMATION MODAL -->



