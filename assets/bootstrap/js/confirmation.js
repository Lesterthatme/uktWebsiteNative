function openModal() {
  document.getElementById("confirmationModal").style.display = "flex";
}

function closeModal() {
  document.getElementById("confirmationModal").style.display = "none";
}

function removeItem() {
  alert("Item has been removed.");
  closeModal();
}

function closeModalOutside(event) {
  if (event.target.id === "confirmationModal") {
      closeModal();
  }
}