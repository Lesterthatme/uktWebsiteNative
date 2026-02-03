document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.getElementById("menu-bar");
  const navbar = document.querySelector(".navbar");
  const dropdowns = document.querySelectorAll(".navbar ul li a i");
  let isMobile = window.innerWidth <= 991;

  // Function to check screen size and update behavior
  function checkScreenSize() {
    isMobile = window.innerWidth <= 991;
    if (!isMobile) {
      resetNavbar(); // Reset when returning to desktop view
    }
  }

  // Toggle main mobile menu
  menuToggle.addEventListener("change", function () {
    if (menuToggle.checked) {
      navbar.style.display = "flex";
    } else {
      navbar.style.display = "none";
    }
  });

  // Handle submenu toggling for mobile (click to open)
  dropdowns.forEach((icon) => {
    icon.parentElement.addEventListener("click", function (e) {
      if (isMobile) {
        // Only enable click in mobile view
        e.preventDefault();
        let submenu = this.nextElementSibling;
        if (submenu && submenu.tagName === "UL") {
          submenu.style.display =
            submenu.style.display === "block" ? "none" : "block";
        }
      }
    });
  });

  // Reset navbar when switching back to non-mobile view
  function resetNavbar() {
    navbar.style.display = ""; // Reset to default display
    menuToggle.checked = false; // Uncheck the menu toggle
    document.querySelectorAll(".navbar ul li ul").forEach((submenu) => {
      submenu.style.display = ""; // Reset all submenus
    });
  }

  // Add hover effect for dropdowns on larger screens
  document.querySelectorAll(".navbar ul li").forEach((dropdown) => {
    dropdown.addEventListener("mouseenter", function () {
      if (!isMobile) {
        let submenu = this.querySelector("ul");
        if (submenu) submenu.style.display = "block";
      }
    });

    dropdown.addEventListener("mouseleave", function () {
      if (!isMobile) {
        let submenu = this.querySelector("ul");
        if (submenu) submenu.style.display = "none";
      }
    });
  });

  // Listen for window resize to reset navbar and check screen size
  window.addEventListener("resize", checkScreenSize);
});

// Add scrolled class when user scrolls down
window.addEventListener("scroll", function () {
let header = document.querySelector("header");
let menuLabel = document.querySelector("header label");

if (window.scrollY > 50) {
header.classList.add("scrolled");
menuLabel.classList.add("scrolled"); // Apply scrolled class to label
} else {
header.classList.remove("scrolled");
menuLabel.classList.remove("scrolled"); // Remove scrolled class from label
}
});
window.addEventListener("scroll", function () {
  let header = document.querySelector("header");
  let menuLabel = document.querySelector("header label");

  if (window.scrollY > 50) {
    header.classList.add("scrolled");
    menuLabel.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
    menuLabel.classList.remove("scrolled");
  }
});

// Scroll-to-Top Button Functionality
document.addEventListener("DOMContentLoaded", function () {
  let scrollToTopBtn = document.getElementById("scrollToTop");

  window.addEventListener("scroll", function () {
    scrollToTopBtn.style.display = window.scrollY > 100 ? "flex" : "none";
  });

  scrollToTopBtn.addEventListener("click", function () {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
});
