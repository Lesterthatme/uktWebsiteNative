document.addEventListener("DOMContentLoaded", function() {
    const readMoreButtons = document.querySelectorAll(".read-more-btn");

    readMoreButtons.forEach(button => {
      button.addEventListener("click", function() {
        const newsTitle = this.getAttribute("data-title");
        const newsDescription = this.getAttribute("data-description");
        const newsImage = this.getAttribute("data-image");

        document.getElementById("newsTitle").innerText = newsTitle;
        document.getElementById("newsDescription").innerText = newsDescription;
        document.getElementById("newsImage").src = newsImage;
      });
    });
  });