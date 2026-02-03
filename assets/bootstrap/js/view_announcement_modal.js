
// script for viewing modal start
document.addEventListener("DOMContentLoaded", function () {
    // Attach click event to all buttons with the class "view-btn"
    document.querySelectorAll('.view-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            // Get data attributes from the clicked button
            const title = this.getAttribute('data-title');
            const description = this.getAttribute('data-description');
            const image = this.getAttribute('data-image');

            // Populate the modal fields
            document.getElementById('modalTitle').value = title;
            document.getElementById('modalDescription').value = description;
            document.getElementById('modalImage').src = image;
        });
    });
});
// script for viewing modal end 

