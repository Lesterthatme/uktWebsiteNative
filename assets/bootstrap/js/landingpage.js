document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("fullImage");
    const closeBtn = document.querySelector(".developer-close-btn");

    // Check if modal elements exist to prevent errors
    if (!modal || !modalImg || !closeBtn) return;

    // Ensure modal is hidden on page load
    modal.style.display = "none";
    // When clicking an image, show it in the modal
    document.querySelectorAll(".Developer_card .header img").forEach(img => {
        img.addEventListener("click", function () {
            modal.style.display = "flex"; // Show modal
            modalImg.src = this.src;
        });
    });

    // Close modal when clicking the close button
    closeBtn.addEventListener("click", function () {
        modal.style.display = "none";
    });

    // Close modal when clicking outside the image
    modal.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".announcement-desc").forEach(desc => {
        let maxLength = 100; // Adjust character limit
        let fullText = desc.textContent.trim();

        if (fullText.length > maxLength) {
            desc.textContent = fullText.substring(0, maxLength) + "...";
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".news-desc").forEach(desc => {
        let maxLength = 100; // Adjust character limit
        let fullText = desc.textContent.trim();

        if (fullText.length > maxLength) {
            desc.textContent = fullText.substring(0, maxLength) + "...";
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const maxTitleLength = 18; // Adjust the character limit as needed
    const titleElements = document.querySelectorAll(".news-item p");
  
    titleElements.forEach((title) => {
      let text = title.textContent.trim();
      if (text.length > maxTitleLength) {
        title.textContent = text.substring(0, maxTitleLength) + "...";
      }
    });
  });
  