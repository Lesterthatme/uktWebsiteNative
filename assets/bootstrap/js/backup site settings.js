document.addEventListener("DOMContentLoaded", function () {
    const modalContent = document.querySelector(".modal-content");
    const colorPicker = document.getElementById("colorInput");
    const colorIndicator = document.getElementById("colorIndicator");

    if (!colorPicker || !colorIndicator) {
        console.error("Color picker or indicator not found.");
        return;
    }

    // Function to update --bs-success color
    function updateActiveLinkColor(color) {
        document.documentElement.style.setProperty("--bs-success", color);
        localStorage.setItem("buttonColor", color);
    }

    // Load saved color from localStorage
    const savedColor = localStorage.getItem("buttonColor");
    if (savedColor) {
        updateActiveLinkColor(savedColor);
        colorIndicator.style.backgroundColor = savedColor;
    }

    // Event listener for color picker
    colorPicker.addEventListener("input", function () {
        const selectedColor = colorPicker.value;
        updateActiveLinkColor(selectedColor);
        colorIndicator.style.backgroundColor = selectedColor;
    });

    // Highlight the active menu item
    const currentPage = window.location.pathname.split("/").pop();
    document.querySelectorAll(".sidebar-menu-item a").forEach(link => {
        if (link.getAttribute("href") === currentPage) {
            link.parentElement.classList.add("active");
        }
    });
});

function openColorPicker() {
    const colorInput = document.getElementById("colorInput");
    if (colorInput) colorInput.click();
}

function darkenColor(color, percent) {
    let R = parseInt(color.substring(1, 3), 16);
    let G = parseInt(color.substring(3, 5), 16);
    let B = parseInt(color.substring(5, 7), 16);

    R = Math.max(0, Math.min(255, parseInt(R * (100 + percent) / 100)));
    G = Math.max(0, Math.min(255, parseInt(G * (100 + percent) / 100)));
    B = Math.max(0, Math.min(255, parseInt(B * (100 + percent) / 100)));

    // Prevent hover color from becoming too light
    if (R > 200 && G > 200 && B > 200) {
        R -= 30;
        G -= 30;
        B -= 30;
    }

    const RR = R.toString(16).padStart(2, "0");
    const GG = G.toString(16).padStart(2, "0");
    const BB = B.toString(16).padStart(2, "0");

    return `#${RR}${GG}${BB}`;
}

function updateButtonColor(color) {
    let hoverColor = darkenColor(color, -15);

    document.documentElement.style.setProperty("--button-color", color);
    document.documentElement.style.setProperty("--button-hover-color", hoverColor);

    const colorIndicator = document.getElementById("colorIndicator");
    if (colorIndicator) {
        colorIndicator.style.backgroundColor = color;
    }

    localStorage.setItem("buttonColor", color);
    localStorage.setItem("buttonHoverColor", hoverColor);

    applyStoredColors(); // Apply color updates immediately
}

function applyStoredColors() {
    let savedColor = localStorage.getItem("buttonColor") || "#186428";
    let savedHoverColor = localStorage.getItem("buttonHoverColor") || "#135322";

    document.documentElement.style.setProperty("--button-color", savedColor);
    document.documentElement.style.setProperty("--button-hover-color", savedHoverColor);

    const colorIndicator = document.getElementById("colorIndicator");
    if (colorIndicator) {
        colorIndicator.style.backgroundColor = savedColor;
    }

    document.querySelectorAll(".btn-dynamic").forEach((btn) => {
        btn.style.backgroundColor = savedColor;
        btn.style.borderColor = savedColor;
        btn.style.color = "#ffffff";

        btn.addEventListener("mouseenter", () => {
            btn.style.backgroundColor = savedHoverColor;
        });
        btn.addEventListener("mouseleave", () => {
            btn.style.backgroundColor = savedColor;
        });
    });
}

// Load saved colors on page load
window.onload = applyStoredColors;

const colorInput = document.getElementById("colorInput");
if (colorInput) {
    colorInput.addEventListener("input", function () {
        updateButtonColor(this.value);
    });
}

// **MutationObserver to Detect New Elements**
const observer = new MutationObserver(() => {
    applyStoredColors(); // Reapply color when new elements are added
});

// Observe changes in the entire document
observer.observe(document.body, { childList: true, subtree: true });

// **MODAL COLOR FUNCTIONS**
function updateModalStyles(color) {
    const modalContent = document.querySelector(".modal-content");
    const textSuccessElements = document.querySelectorAll(".text-success");

    if (!modalContent) return;

    let shadowColor = darkenColor(color, -30);
    
    // Update only the box-shadow
    modalContent.style.boxShadow = `-6px 6px 0 ${shadowColor}`;

    // Update all text-success elements color
    textSuccessElements.forEach(el => {
        el.style.color = color;
    });

    localStorage.setItem("modalShadowColor", shadowColor);
    localStorage.setItem("textSuccessColor", color);
}

function applyStoredModalStyles() {
    const modalContent = document.querySelector(".modal-content");
    const textSuccessElements = document.querySelectorAll(".text-success");

    if (!modalContent) return;

    let savedShadowColor = localStorage.getItem("modalShadowColor") || "#155724";
    let savedTextColor = localStorage.getItem("textSuccessColor") || "#198754"; // Bootstrap default success color

    modalContent.style.boxShadow = `-6px 6px 0 ${savedShadowColor}`;

    textSuccessElements.forEach(el => {
        el.style.color = savedTextColor;
    });
}

// Update styles when color picker changes
const colorPicker = document.getElementById("colorInput");
if (colorPicker) {
    colorPicker.addEventListener("input", function () {
        updateModalStyles(this.value);
    });
}

// Apply stored styles when modal is shown
document.querySelectorAll(".modal").forEach(modal => {
    modal.addEventListener("shown.bs.modal", applyStoredModalStyles);
});

function updateTextColor(newColor = null) {
    if (newColor) {
     
        localStorage.setItem("buttonColor", newColor);
        document.documentElement.style.setProperty("--bs-success", newColor);
    } else {
   
        let savedColor = localStorage.getItem("buttonColor") || "#198754"; 
        document.documentElement.style.setProperty("--bs-success", savedColor);
    }

    
    document.querySelectorAll(".text-color-default").forEach(el => {
        el.style.color = newColor || getComputedStyle(document.documentElement).getPropertyValue("--bs-success");
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const colorPicker = document.getElementById("colorInput");

    function updateActiveTabStyles(color) {
        if (!color) {
            // Reset to default values from your CSS
            document.documentElement.style.removeProperty("--active-link-color");
            document.documentElement.style.removeProperty("--active-link-underline");

            localStorage.removeItem("activeLinkColor");
            localStorage.removeItem("activeLinkUnderline");
        } else {
            let underlineColor = darkenColor(color, -15); // Slightly darken for contrast

            document.documentElement.style.setProperty("--active-link-color", color);
            document.documentElement.style.setProperty("--active-link-underline", underlineColor);

            localStorage.setItem("activeLinkColor", color);
            localStorage.setItem("activeLinkUnderline", underlineColor);
        }
    }

    // Load saved colors from localStorage
    const savedColor = localStorage.getItem("activeLinkColor");
    const savedUnderline = localStorage.getItem("activeLinkUnderline");

    if (savedColor && savedUnderline) {
        document.documentElement.style.setProperty("--active-link-color", savedColor);
        document.documentElement.style.setProperty("--active-link-underline", savedUnderline);
    }

    // Event listener for color picker
    if (colorPicker) {
        colorPicker.addEventListener("input", function () {
            const selectedColor = this.value.trim();
            updateActiveTabStyles(selectedColor);
        });

        // Listen for clearing event (if user resets color)
        colorPicker.addEventListener("change", function () {
            if (!this.value) {
                updateActiveTabStyles(null);
            }
        });
    }
});

// Function to slightly darken color for underline contrast
function darkenColor(color, percent) {
    let R = parseInt(color.substring(1, 3), 16);
    let G = parseInt(color.substring(3, 5), 16);
    let B = parseInt(color.substring(5, 7), 16);

    R = Math.max(0, Math.min(255, parseInt(R * (100 + percent) / 100)));
    G = Math.max(0, Math.min(255, parseInt(G * (100 + percent) / 100)));
    B = Math.max(0, Math.min(255, parseInt(B * (100 + percent) / 100)));

    const RR = R.toString(16).padStart(2, "0");
    const GG = G.toString(16).padStart(2, "0");
    const BB = B.toString(16).padStart(2, "0");

    return `#${RR}${GG}${BB}`;
}
document.addEventListener("DOMContentLoaded", function () {
    function updateTextColor(newColor = null) {
        let savedColor = newColor || localStorage.getItem("buttonColor") || "#198754"; // Default Bootstrap success color
        document.documentElement.style.setProperty("--bs-success", savedColor);

        document.querySelectorAll(".text-color-default").forEach(el => {
            el.style.color = savedColor;
        });
    }

    // Apply the saved color on page load
    updateTextColor();

    // Ensure that when the color picker changes, it updates immediately
    const colorPicker = document.getElementById("colorInput");
    if (colorPicker) {
        colorPicker.addEventListener("input", function () {
            updateTextColor(this.value);
            localStorage.setItem("buttonColor", this.value);
        });

        // Listen for reset (clearing the input)
        colorPicker.addEventListener("change", function () {
            if (!this.value) {
                updateTextColor(null); 
                localStorage.removeItem("buttonColor");
            }
        });
    }
});


document.addEventListener("DOMContentLoaded", function () {
    const modalContent = document.querySelector(".modal-content");
    const colorPicker = document.getElementById("colorInput");
    const colorIndicator = document.getElementById("colorIndicator");
  
    if (!colorPicker || !colorIndicator) {
      console.error("Color picker or indicator not found.");
      return;
    }
  
    function updateActiveLinkColor(color) {
      document.documentElement.style.setProperty("--bs-success", color);
      localStorage.setItem("buttonColor", color);
    }
  
    const savedColor = localStorage.getItem("buttonColor");
    if (savedColor) {
      updateActiveLinkColor(savedColor);
      colorIndicator.style.backgroundColor = savedColor;
    }
  
    colorPicker.addEventListener("input", function () {
      const selectedColor = colorPicker.value;
      updateActiveLinkColor(selectedColor);
      colorIndicator.style.backgroundColor = selectedColor;
    });
  
    const currentPage = window.location.pathname.split("/").pop();
    document.querySelectorAll(".sidebar-menu-item a").forEach((link) => {
      if (link.getAttribute("href") === currentPage) {
        link.parentElement.classList.add("active");
      }
    });
  });
  
  function openColorPicker() {
    const colorInput = document.getElementById("colorInput");
    if (colorInput) colorInput.click();
  }
  
  function darkenColor(color, percent) {
    let R = parseInt(color.substring(1, 3), 16);
    let G = parseInt(color.substring(3, 5), 16);
    let B = parseInt(color.substring(5, 7), 16);
  
    R = Math.max(0, Math.min(255, parseInt((R * (100 + percent)) / 100)));
    G = Math.max(0, Math.min(255, parseInt((G * (100 + percent)) / 100)));
    B = Math.max(0, Math.min(255, parseInt((B * (100 + percent)) / 100)));
  
    if (R > 200 && G > 200 && B > 200) {
      R -= 30;
      G -= 30;
      B -= 30;
    }
  
    const RR = R.toString(16).padStart(2, "0");
    const GG = G.toString(16).padStart(2, "0");
    const BB = B.toString(16).padStart(2, "0");
  
    return `#${RR}${GG}${BB}`;
  }
  
  function updateButtonColor(color) {
    let hoverColor = darkenColor(color, -15);
  
    document.documentElement.style.setProperty("--button-color", color);
    document.documentElement.style.setProperty(
      "--button-hover-color",
      hoverColor
    );
  
    const colorIndicator = document.getElementById("colorIndicator");
    if (colorIndicator) {
      colorIndicator.style.backgroundColor = color;
    }
  
    // Update profile picture border color
    document.querySelectorAll(".profile-pic-container img").forEach((img) => {
      img.style.borderColor = color;
    });
  
    localStorage.setItem("buttonColor", color);
    localStorage.setItem("buttonHoverColor", hoverColor);
    localStorage.setItem("profilePicBorderColor", color);
  
    applyStoredColors();
  }
  
  function applyStoredColors() {
    let savedColor = localStorage.getItem("buttonColor") || "#186428";
    let savedHoverColor = localStorage.getItem("buttonHoverColor") || "#135322";
    let savedBorderColor =
      localStorage.getItem("profilePicBorderColor") || "#198754";
  
    document.documentElement.style.setProperty("--button-color", savedColor);
    document.documentElement.style.setProperty(
      "--button-hover-color",
      savedHoverColor
    );
  
    const colorIndicator = document.getElementById("colorIndicator");
    if (colorIndicator) {
      colorIndicator.style.backgroundColor = savedColor;
    }
  
    document.querySelectorAll(".profile-pic-container img").forEach((img) => {
      img.style.borderColor = savedBorderColor;
    });
  
    document.querySelectorAll(".upload-icon").forEach((icon) => {
      icon.style.backgroundColor = savedColor;
      icon.style.borderColor = savedColor;
    });
  
    document.querySelectorAll(".signup-text a").forEach((link) => {
      link.style.color = savedColor;
    });
    document.querySelectorAll(".login_title").forEach((heading) => {
      heading.style.color = savedColor;
    });
    document.querySelectorAll(".subtitle").forEach((paragraph) => {
      paragraph.style.color = savedColor;
    });
    document.querySelectorAll(".forgot_pass").forEach((link) => {
      link.style.color = savedColor;
    });
  
    document.querySelectorAll(".forgot_pass").forEach((link) => {
      link.style.color = savedColor;
    });
    
  
    document.addEventListener("DOMContentLoaded", () => {
      let savedColor = localStorage.getItem("buttonColor") || "#186428";
  
      document.querySelectorAll(".edit_site").forEach((link) => {
        link.style.color = savedColor;
      });
    });
  
    
  
    document.addEventListener("DOMContentLoaded", () => {
      let savedColor = localStorage.getItem("buttonColor") || "#186428";
  
      document.querySelectorAll(".custom-carousel-btn").forEach((button) => {
        button.style.backgroundColor = savedColor;
        button.style.borderColor = savedColor;
      });
  
      document
        .querySelectorAll(".carousel-indicators button")
        .forEach((indicator) => {
          indicator.classList.remove("bg-success");
          indicator.style.backgroundColor = savedColor;
        });
    });
    document.addEventListener("DOMContentLoaded", () => {
      let savedBorderColor =
        localStorage.getItem("profilePicBorderColor") || "#198754";
  
      document.querySelectorAll(".badge-circle").forEach((badge) => {
        badge.classList.remove("border-success");
  
        badge.style.setProperty("border-color", savedBorderColor, "important");
      });
    });
  
    document.querySelectorAll(".btn-dynamic").forEach((btn) => {
      btn.style.backgroundColor = savedColor;
      btn.style.borderColor = savedColor;
      btn.style.color = "#ffffff";
  
      btn.addEventListener("mouseenter", () => {
        btn.style.backgroundColor = savedHoverColor;
      });
      btn.addEventListener("mouseleave", () => {
        btn.style.backgroundColor = savedColor;
      });
    });
  }
  
  window.onload = applyStoredColors;
  
  const colorInput = document.getElementById("colorInput");
  if (colorInput) {
    colorInput.addEventListener("input", function () {
      updateButtonColor(this.value);
    });
  }
  
  const observer = new MutationObserver(() => {
    applyStoredColors();
  });
  
  observer.observe(document.body, { childList: true, subtree: true });
  
  function updateModalStyles(color) {
    const modalContent = document.querySelector(".modal-content");
    const textSuccessElements = document.querySelectorAll(".text-success");
  
    if (!modalContent) return;
  
    let shadowColor = darkenColor(color, -30);
  
    modalContent.style.boxShadow = `-6px 6px 0 ${shadowColor}`;
  
    textSuccessElements.forEach((el) => {
      el.style.color = color;
    });
  
    localStorage.setItem("modalShadowColor", shadowColor);
    localStorage.setItem("textSuccessColor", color);
  }
  
  function applyStoredModalStyles() {
    const modalContent = document.querySelector(".modal-content");
    const textSuccessElements = document.querySelectorAll(".text-success");
  
    if (!modalContent) return;
  
    let savedShadowColor = localStorage.getItem("modalShadowColor") || "#155724";
    let savedTextColor = localStorage.getItem("textSuccessColor") || "#198754";
  
    modalContent.style.boxShadow = `-6px 6px 0 ${savedShadowColor}`;
  
    textSuccessElements.forEach((el) => {
      el.style.color = savedTextColor;
    });
  }
  
  const colorPicker = document.getElementById("colorInput");
  if (colorPicker) {
    colorPicker.addEventListener("input", function () {
      updateModalStyles(this.value);
    });
  }
  
  document.querySelectorAll(".modal").forEach((modal) => {
    modal.addEventListener("shown.bs.modal", applyStoredModalStyles);
  });
  
  function updateTextColor(newColor = null) {
    let savedColor = newColor || localStorage.getItem("buttonColor") || "#198754";
    document.documentElement.style.setProperty("--bs-success", savedColor);
  
    document.querySelectorAll(".text-color-default").forEach((el) => {
      el.style.color = savedColor;
    });
  }
  
  updateTextColor();
  
  if (colorPicker) {
    colorPicker.addEventListener("input", function () {
      updateTextColor(this.value);
      localStorage.setItem("buttonColor", this.value);
    });
  
    colorPicker.addEventListener("change", function () {
      if (!this.value) {
        updateTextColor(null);
        localStorage.removeItem("buttonColor");
      }
    });
  }
  
  document.addEventListener("DOMContentLoaded", function () {
    const colorPicker = document.getElementById("colorInput");
  
    function updateActiveTabStyles(color) {
      if (!color) {
        document.documentElement.style.removeProperty("--active-link-color");
        document.documentElement.style.removeProperty("--active-link-underline");
  
        localStorage.removeItem("activeLinkColor");
        localStorage.removeItem("activeLinkUnderline");
      } else {
        let underlineColor = darkenColor(color, -15);
  
        document.documentElement.style.setProperty("--active-link-color", color);
        document.documentElement.style.setProperty(
          "--active-link-underline",
          underlineColor
        );
  
        localStorage.setItem("activeLinkColor", color);
        localStorage.setItem("activeLinkUnderline", underlineColor);
      }
    }
  
    const savedColor = localStorage.getItem("activeLinkColor");
    const savedUnderline = localStorage.getItem("activeLinkUnderline");
  
    if (savedColor && savedUnderline) {
      document.documentElement.style.setProperty(
        "--active-link-color",
        savedColor
      );
      document.documentElement.style.setProperty(
        "--active-link-underline",
        savedUnderline
      );
    }
  
    if (colorPicker) {
      colorPicker.addEventListener("input", function () {
        const selectedColor = this.value.trim();
        updateActiveTabStyles(selectedColor);
      });
  
      colorPicker.addEventListener("change", function () {
        if (!this.value) {
          updateActiveTabStyles(null);
        }
      });
    }
  });
  
  