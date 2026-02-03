document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editHighlightModal');
    if (editModal) {
      editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const hId = button.getAttribute('data-id');
        const hIcon = button.getAttribute('data-icon');
        const hTitle = button.getAttribute('data-title');
        const hDescription = button.getAttribute('data-description');
  
        // Populate the modal fields
        document.getElementById('modal_h_id').value = hId;
        document.getElementById('modal_h_icon').value = hIcon;
        document.getElementById('modal_h_title').value = hTitle;
        document.getElementById('modal_h_description').value = hDescription;
      });
    }
  });
  