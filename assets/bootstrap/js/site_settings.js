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
  let boxShadowColor = `${savedColor}4D`;

//   document.documentElement.style.setProperty(
//     "--calendar-border-color",
//     savedColor
//   );
//   document.documentElement.style.setProperty(
//     "--calendar-box-shadow",
//     `0 8px 16px ${boxShadowColor}`
//   );
//   document.documentElement.style.setProperty(
//     "--calendar-text-color",
//     savedColor
//   );
//   document.documentElement.style.setProperty(
//     "--calendar-hr-border",
//     savedColor
//   );
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
  document
    .querySelectorAll(".custom-pagination .page-item.active .page-link")
    .forEach((item) => {
      item.style.backgroundColor = savedColor;
      item.style.color = "#fff";
    });
  document.querySelectorAll(".Developer_card .header").forEach((header) => {
    header.style.backgroundColor = savedColor;
  });

  document.querySelectorAll(".Developer_card h3").forEach((heading) => {
    heading.style.color = savedColor;
  });
  document.querySelectorAll(".Developer_card .socials a").forEach((link) => {
    link.style.color = savedColor;

    link.addEventListener("mouseenter", function () {
      this.style.color = darkenColor(savedColor, -15);
    });

    link.addEventListener("mouseleave", function () {
      this.style.color = savedColor;
    });
  });

  document.querySelectorAll(".vmgo_card").forEach((card) => {
    card.style.color = savedColor;
    card.style.borderTop = `3px solid ${savedColor}`;
  });

  document.querySelectorAll(".info_list i").forEach((icon) => {
    icon.style.color = savedColor;
  });

  document.querySelectorAll(".vmgo_card h5").forEach((heading) => {
    heading.style.color = savedColor;
  });
  document.querySelectorAll(".contact-card").forEach((card) => {
    card.style.color = savedColor;
  });

  document.querySelectorAll(".contact-card i").forEach((icon) => {
    icon.style.color = savedColor;
    icon.style.borderColor = savedColor;
  });

  document.querySelectorAll(".forgot_pass").forEach((link) => {
    link.style.color = savedColor;
  });
  document.querySelectorAll(".forgot_pass").forEach((link) => {
    link.style.color = savedColor;
  });

  //calendar update color start
  document.querySelectorAll(".day").forEach((heading) => {
    heading.style.color = savedColor;
  });
  document.querySelectorAll(".custom-hr").forEach((hr) => {
    hr.style.borderColor = savedColor;
  });

  // faq
  document.querySelectorAll(".accordion-button").forEach((button) => {
    button.addEventListener("click", function () {
      setTimeout(() => {
        if (!this.classList.contains("collapsed")) {
          this.style.color = savedColor;
        } else {
          this.style.backgroundColor = "";
          this.style.color = "";
        }
      }, 10);
    });
  });

  document.addEventListener("DOMContentLoaded", () => {
    let savedColor = localStorage.getItem("buttonColor") || "#186428";

    document.querySelectorAll(".edit_site").forEach((link) => {
      link.style.color = savedColor;
    });
  });

  // for carousel start
  document.addEventListener("DOMContentLoaded", () => {
    let savedColor = localStorage.getItem("buttonColor") || "#186428";

    document.querySelectorAll(".custom-carousel-btn").forEach((button) => {
      button.style.backgroundColor = savedColor;
      button.style.borderColor = savedColor;
    });

    document
      .querySelectorAll(".carousel-indicators button")
      .forEach((button) => {
        button.style.backgroundColor = savedColor;
        button.style.borderColor = savedColor;
      });
    // for carousel end
  });

  // for badge circle start
  document.addEventListener("DOMContentLoaded", () => {
    let savedBorderColor =
      localStorage.getItem("profilePicBorderColor") || "#198754";

    document.querySelectorAll(".badge-circle").forEach((badge) => {
      badge.classList.remove("border-success");

      badge.style.setProperty("border-color", savedBorderColor, "important");
    });
  });
  // for badge circle end

  // boostrap button customizable start
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
  // boostrap button customizable end

  // This is for Landing page start
  document.querySelectorAll(".announcement-btn").forEach((btn) => {
    // Set initial styles
    btn.style.backgroundColor = "#ffffff";
    btn.style.borderColor = savedColor;
    btn.style.color = savedColor;

    btn.addEventListener("mouseenter", () => {
      btn.style.color = "#ffffff"; // Text turns white on hover
      btn.style.backgroundColor = savedHoverColor;
    });

    btn.addEventListener("mouseleave", () => {
      btn.style.backgroundColor = "#ffffff"; // Restore default white background
      btn.style.borderColor = savedColor;
      btn.style.color = savedColor;
    });
  });
  //   document.querySelectorAll(".news-btn").forEach((btn) => {
  //     // Set initial styles
  //     btn.style.backgroundColor = "#ffffff";
  //     btn.style.borderColor = savedColor;
  //     btn.style.color = savedColor;

  //     btn.addEventListener("mouseenter", () => {
  //       btn.style.color = "#ffffff"; // Text turns white on hover
  //       btn.style.backgroundColor = savedHoverColor;
  //     });

  //     btn.addEventListener("mouseleave", () => {
  //       btn.style.backgroundColor = "#ffffff"; // Restore default white background
  //       btn.style.borderColor = savedColor;
  //       btn.style.color = savedColor;
  //     });
  //   });

  document.querySelectorAll(".announcement h2").forEach((header) => {
    header.style.color = savedColor;
  });
  document.querySelectorAll(".announcement h2").forEach((el) => {
    el.style.setProperty("--after-bg", savedColor);
  });

  document.querySelectorAll(".news-section h2").forEach((header) => {
    header.style.color = savedColor;
  });
  document.querySelectorAll(".news-section h2").forEach((el) => {
    el.style.setProperty("--after-bg", savedColor);
  });
  // document.querySelectorAll(".faq-container h2").forEach((header) => {
  //   header.style.color = savedColor;
  // });
  document.querySelectorAll(".separator").forEach((el) => {
    el.style.backgroundColor = savedColor;
  });
  document.querySelectorAll(".calendar-container h2").forEach((header) => {
    header.style.color = savedColor;
  });
  document.querySelectorAll(".calendar-container h2").forEach((el) => {
    el.style.setProperty("--after-bg", savedColor);
  });

  document.querySelectorAll(".calendar-month").forEach((month) => {
    month.style.backgroundColor = savedColor; // Or any style you want
  });

  document.querySelectorAll(".calendar-day").forEach((day) => {
    day.style.color = savedColor;
  });

  document.querySelectorAll(".calendar-label").forEach((label) => {
    label.style.fontWeight = "bold"; // Example change
  });
  document.querySelectorAll(".banner-tag").forEach((tag) => {
    tag.style.color = savedColor;
  });
  document.querySelectorAll(".widget-title").forEach((el) => {
    el.style.borderLeft = `4px solid ${savedColor}`; // sets border-left color
    el.style.color = savedColor; // sets text color
  });
  document.querySelectorAll(".section-title").forEach((el) => {
    el.style.borderLeft = `5px solid ${savedColor}`; // sets border-left color
    el.style.color = savedColor; // sets text color
  });
  document.styleSheets[0].insertRule(
    `.categories-widget ul a::after { background-color: ${savedColor} !important; }`,
    document.styleSheets[0].cssRules.length
  );

  function hexToRgba(hex, opacity) {
    hex = hex.replace("#", "");
    if (hex.length === 3) {
      hex = hex
        .split("")
        .map((h) => h + h)
        .join("");
    }
    const bigint = parseInt(hex, 16);
    const r = (bigint >> 16) & 255;
    const g = (bigint >> 8) & 255;
    const b = bigint & 255;
    return `rgba(${r}, ${g}, ${b}, ${opacity})`;
  }

  const rgbaColor = hexToRgba(savedColor, 0.9); // convert to rgba with opacity
  const style = document.createElement("style");
  style.innerHTML = `
  .recent-posts-widget .post-item h4 a:hover {
    color: ${savedColor} !important;
  }
  .download-link:hover {
    color: ${savedColor} !important;
  }
  .icon-wrapper {
    border:  3px solid ${savedColor} !important;
  }
   .breadcrumb-item a {
    color:   ${savedColor} !important;
  }
   .rector-title {
    background:   ${savedColor} !important;
  }
  .navmenu a:focus i:hover  {
    background-color: ${savedColor} !important;
  }
      .navmenu .dropdown ul a:hover,
    .navmenu .dropdown ul .active:hover,
    .navmenu .dropdown ul li:hover > a {
      color:${savedColor};
    }
.navmenu  .active, .navmenu .active:focus
 {
   color: ${savedColor} !important;
  }
   .navmenu .active i, .navmenu .active:focus i  {
   background-color: ${savedColor} !important;
  }
  .president-card .info a  {
   color: ${savedColor} !important;
  }
  .breadcrumb-link:hover {
      color: ${savedColor} !important;
    }
 .president-card::before {
     background: ${rgbaColor} !important;
  }
   .footer::before {
     background: ${rgbaColor} !important;
  }
  
  .about-banner {
    background: linear-gradient(to right, rgba(78, 78, 78, 0.64), rgba(0, 70, 0, 0.57)), url('assets/images/aboutunivprofile.png');
  }
  .Developer_card .dev_header{
     background:${savedColor} !important;
  }
  .news-btn{
   background: white ;

  }
  .news-btn:hover {
  background: ${savedColor} !important;
  color: white !important;
}
.login-container h3{
color: ${savedColor} !important;
}
 .news-btn {
  background: white;
  color:  ${savedColor} !important;
  border: 2px solid  ${savedColor} !important;
}
 header {
    background: ${savedColor};
    transition: all 0.3s ease;
  }
  header.scrolled {
    background: #ffffff;
    border-top: 3px solid ${savedColor};
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
  }
  .university_logo {
    color: #ffffff;
    transition: color 0.3s ease;
  }
  header.scrolled .university_logo {
    color: ${savedColor};
  }
  .logo-subtitle {
    color: #dfe6e9;
    transition: color 0.3s ease;
  }
  header.scrolled .logo-subtitle {
    color: ${savedColor};
  }
  .three-dots-poster button:hover span{
     background-color: ${savedColor};
  }
  .three-dots:hover span{
   background-color: ${savedColor};
  }
  .official_name {
    color: ${savedColor};
  }
  .officials_image{
  border:3px solid  ${savedColor};
  }
.three-dots-accord:hover span{
   background-color: ${savedColor};
  }
  
`;

  document.head.appendChild(style);

  document.querySelectorAll("h2").forEach((el) => {
    el.style.color = savedColor;
  });
  document.styleSheets[0].insertRule(
    `h2::after { 
     background-color: ${savedColor} !important; 
     content: ''; 
     display: block; 
     height: 3px; 
     width: 50px; 
     margin-top: 5px;
  }`,
    document.styleSheets[0].cssRules.length
  );

  document.querySelectorAll(".view-all-btn").forEach((el) => {
    el.style.color = savedColor;
  });
  document.querySelectorAll(".read-more").forEach((el) => {
    el.style.color = savedColor;
  });
  document.querySelectorAll(".construction-icon").forEach((el) => {
    el.style.color = savedColor;
  });

  document.addEventListener("DOMContentLoaded", function () {
    let header = document.querySelector("header");
    let universityLogo = document.querySelector(".university_logo");
    let logoSubtitle = document.querySelector(".logo-subtitle");

    window.addEventListener("scroll", function () {
      if (window.scrollY > 50) {
        // Adjust this threshold as needed
        header.classList.add("scrolled");
      } else {
        header.classList.remove("scrolled");
      }

      // Apply styles dynamically when scrolled
      if (header.classList.contains("scrolled")) {
        header.style.background = "#ffffff";
        header.style.borderTop = "3px solid " + savedColor;
        header.style.boxShadow = "0 3px 10px rgba(0, 0, 0, 0.1)";

        if (universityLogo) universityLogo.style.color = savedColor;
        if (logoSubtitle) logoSubtitle.style.color = savedColor;
      } else {
        header.style.background = savedColor;
        header.style.borderTop = "none";
        header.style.boxShadow = "0 5px 10px rgba(0, 0, 0, 0.1)";

        if (universityLogo) universityLogo.style.color = "#ffffff"; // Default color
        if (logoSubtitle) logoSubtitle.style.color = "#dfe6e9"; // Default color
      }
    });

    // Apply saved color to header initially
    header.style.background = savedColor;
  });
  // This is for Landing page end
}

window.onload = applyStoredColors;

const colorInput = document.getElementById("colorInput");
if (colorInput) {
  colorInput.addEventListener("input", function () {
    updateButtonColor(this.value);
  });
}

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

const observer = new MutationObserver(() => {
  applyStoredColors();
});

observer.observe(document.body, { childList: true, subtree: true });
