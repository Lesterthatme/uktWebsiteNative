// document.addEventListener("DOMContentLoaded", function () {
//   function getQueryParam(param) {
//       const urlParams = new URLSearchParams(window.location.search);
//       return urlParams.get(param);
//   }

//   function updatePageTitle() {
//       let pageTitle = document.querySelector("h1");
//       if (!pageTitle) return; 

//       let page = getQueryParam("page"); 

//       const pageTitles = {
//           "university_background": "University Background",
//           "university_profile": "University Profile",
//           "vmgo": "Vision, Mission & Goals",
//           "university_hymn": "Hymn",
//           "colleges": "College of English",
//           "program_offerings": "Program Offerings",
//           "news": "News",
//           "announcements": "Announcements",
//           "admission_requirements" : "Admission Requirements",
//           "scholarships" : "Scholarships",
//           "university_library" : "University Library",
//           "contactus" : "Contacts & Location",
//           "forms" : "Forms",
//           "university_album" : "University Album",
//           "rector":"Rector",
//           "board_of_directors": "Board of Directors",
//           "univ_heads":  "Head of Department and Head of Office"
        
//       };
//       pageTitle.textContent = pageTitles[page] || "General Information About University";
//   }
//   updatePageTitle(); 
//   const observer = new MutationObserver(updatePageTitle);
//   observer.observe(document.body, { childList: true, subtree: true });
// });

// document.addEventListener("DOMContentLoaded", function () {
//   const bannerText = document.querySelector(".about-banner-updated");
//   const urlParams = new URLSearchParams(window.location.search);
//   const page = urlParams.get("page") || "home";

//   const bannerTexts = {
//     "university_background": "Know more about our university.",
//     "university_profile": "Know more about our university.",
//     "vmgo": "Know more about our university.",
//     "university_hymn": "Know more about our university.",
//     "colleges": "Colleges are institutions of higher learning that offer specialized education, skill development, and research opportunities to prepare students for professional careers.",
//     "program_offerings": "We offer a range of programs designed to equip learners with the skills and knowledge they need for success. Explore our diverse courses across various fields.",
//     "news": "  Stay updated with the latest university news, events, and achievements.",
//     "announcements": " Get the latest updates on academic schedules, events, and important university news. Stay informed and never miss an announcement ",
//     "admission_requirements": " Find out the necessary documents and qualifications needed for admission to ensure a smooth application process.",
//     "scholarships": " Explore available scholarship opportunities and financial aid programs designed to support students in achieving their academic goals.",
//     "university_library": "Welcome to our college library",
//     "contactus": "Have any questions or need assistance?",
//     "forms": "Here are some of the Downloadable forms for UKT Students",
//     "rector" : "Learn more about the management of the university.",
//     "board_of_directors" : "Learn more about the management of the university.",
//     "univ_heads" : "Learn more about the management of the university.",
//     "university_album": "Discover the best memories from campus life, graduation day, sports events, and more. Click an album to explore the images inside."
//   };

//   bannerText.textContent = bannerTexts[page] || "Welcome to our website!";
// });

// document.addEventListener("DOMContentLoaded", function () {
//   const bannerTag = document.querySelector(".banner-tag");
//   const urlParams = new URLSearchParams(window.location.search);
//   const page = urlParams.get("page") || "home";

//   const bannerTags = {
//       "university_background": "ABOUT",
//      "vmgo": "ABOUT",
//       "university_profile": "ABOUT",
//       "university_hymn": "ABOUT",
//       "contactus": "ABOUT",
//       "colleges": "Department",
//       "program_offerings": "Academics",
//       "news": "Bulletin",
//       "announcements": "Bulletin",
//       "admission_requirements": "Student",
//       "scholarships": "Student",
//       "university_library": "Student",
//       "forms": "Student",
//       "university_album": "Campus life",
//       "rector" : "Management",
//       "board_of_directors" : "Management",
//       "univ_heads" : "Management",
//   };

//   bannerTag.textContent = bannerTags[page] || "PAGE NOT FOUND";
// });

// document.addEventListener("DOMContentLoaded", function () {
//   const breadcrumbTitle = document.querySelector(".breadcrumb-item.active");
//   const urlParams = new URLSearchParams(window.location.search);
//   const page = urlParams.get("page") || "home";

//   const breadcrumbTitles = {
//       "university_background": "University Background",
//       "vmgo": "Vision, Mission & Goals",
//       "university_profile": "University Profile",
//       "university_hymn": "Hymn",
//       "news": "News",
//       "announcements": "Announcements",
//       "program_offerings" : "Program Offerings",
//       "admission_requirements" : "Admission Requirements",
//       "forms": "Forms",
//       "university_album": "University Album",
//       "rector": "Rector សាកលវិទ្យាធិការ",
//       "board_of_directors": "Board of Directors",
//       "univ_heads": "Head of Department and Head of Office",
//       "contactus": "Contact & Location",
//   };

//   breadcrumbTitle.textContent = breadcrumbTitles[page] || "Page Not Found";
// });


// document.addEventListener("DOMContentLoaded", function () {
//   const banner = document.querySelector(".about-banner");
//   const urlParams = new URLSearchParams(window.location.search);
//   const page = urlParams.get("page") || "home";

//   const backgroundImages = {

//       "university_background": "assets/images/aboutunivprofile.png",
//       "vmgo": "assets/images/aboutunivprofile.png",
//       "university_profile": "assets/images/aboutunivprofile.png",
//       "university_hymn": "assets/images/aboutunivprofile.png",
//       "colleges": "assets/images/colleges/COE.jpg",
//       "board_of_directors" : "assets/images/carl eto.gif"
      
//   };

//   const bgImage = backgroundImages[page] || "assets/images/aboutunivprofile.png";
//   banner.style.background = `linear-gradient(to right, rgba(78, 78, 78, 0.64), rgba(0, 70, 0, 0.57)), url('${bgImage}')`;
//   banner.style.backgroundSize = "cover";
//   banner.style.backgroundPosition = "center";
//   banner.style.backgroundAttachment = "fixed";
// });



// document.addEventListener("DOMContentLoaded", function () {
//   function getPageFromPath() {
//     const path = window.location.pathname; 
//     const pathParts = path.split('/'); 
//     return pathParts[pathParts.length - 1] || "home"; 
//   }

//   function updatePageTitle() {
//     let pageTitle = document.querySelector("h1");
//     if (!pageTitle) return; 

//     let page = getPageFromPath(); 

//     const pageTitles = {
//       "university_background": "University Background",
//       "university_profile": "University Profile",
//       "vmgo": "Vision, Mission & Goals",
//       "university_hymn": "Hymn",
//       "colleges": "College of English",
//       "program_offerings": "Program Offerings",
//       "news": "News",
//       "announcements": "Announcements",
//       "admission_requirements" : "Admission Requirements",
//       "scholarships" : "Scholarships",
//       "university_library" : "University Library",
//       "contactus" : "Contacts & Location",
//       "forms" : "Forms",
//       "university_album" : "University Album",
//       "rector":"Rector",
//       "board_of_directors": "Board of Directors",
//       "univ_heads":  "Head of Department and Head of Office"
//     };
//     pageTitle.textContent = pageTitles[page] || "General Information About University";
//   }
//   updatePageTitle(); 
//   const observer = new MutationObserver(updatePageTitle);
//   observer.observe(document.body, { childList: true, subtree: true });
// });

// document.addEventListener("DOMContentLoaded", function () {
//   // Function to get the department slug from the URL query string (like 'ics', 'ied', etc.)
//   function getPageFromPHP() {
//     const path = window.location.pathname;

//     // Check if the path contains 'colleges&department_slug=' and extract the value
//     const match = path.match(/colleges&department_slug=([^/]+)/);
//     return match ? match[1] : null; // Return the department slug or null if not found
//   }

//   // Function to get the last part of the URL path (if no PHP parameter exists)
//   function getPageFromPath() {
//     const path = window.location.pathname;
//     const pathParts = path.split('/');
//     return pathParts[pathParts.length - 1] || "home"; // Use the last part of the URL or "home" as a fallback
//   }

//   function updatePageTitle() {
//     let pageTitle = document.querySelector("h1");
//     if (!pageTitle) return;

//     // Prioritize the PHP parameter (department slug) over the URL path
//     let page = getPageFromPHP() || getPageFromPath();

//     // Titles for known pages based on the slug (no hyphens in titles now)
//     const pageTitles = {
//       "university_background": "University Background",
//       "university_profile": "University Profile",
//       "vmgo": "Vision, Mission & Goals",
//       "university_hymn": "Hymn",
//       "colleges": "College of English",
//       "program_offerings": "Program Offerings",
//       "news": "News",
//       "announcements": "Announcements",
//       "admission_requirements": "Admission Requirements",
//       "scholarships": "Scholarships",
//       "university_library": "University Library",
//       "contactus": "Contacts & Location",
//       "forms": "Forms",
//       "university_album": "University Album",
//       "rector": "Rector",
//       "board_of_directors": "Board of Directors",
//       "univ_heads": "Head of Department and Head of Office"
//     };

//     // If the page is a department slug like 'ics', use it directly
//     if (page) {
//       pageTitle.textContent = pageTitles[page] || page.replace(/-/g, " ").toUpperCase() || "General Information About University";
//     } else {
//       pageTitle.textContent = "General Information About University"; // Default title
//     }
//   }

//   updatePageTitle(); // Run on initial page load

//   // Observe DOM changes to update the page title if the page changes dynamically
//   const observer = new MutationObserver(updatePageTitle);
//   observer.observe(document.body, { childList: true, subtree: true });
// });

document.addEventListener("DOMContentLoaded", function () {
  function getQueryParams() {
    const query = new URLSearchParams(window.location.search);
    return {
      departmentSlug: query.get("department_slug"),
      newsSlug: query.get("news_slug"),
      announcementSlug: query.get("announcement_slug")
    };
  }

  function getPageFromPath() {
    const path = window.location.pathname;
    const pathParts = path.split('/');
    return pathParts[pathParts.length - 1] || "home";
  }

  function formatTitle(title) {
    const lowercaseWords = ['of', 'and', 'the', 'in', 'to', 'with', 'a', 'an', 'for', 'on', 'at', 'by', 'between', 'from'];
    const words = title.split(' ');

    return words.map((word, index) => {
      if (index === 0 || !lowercaseWords.includes(word.toLowerCase())) {
        return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
      }
      return word.toLowerCase();
    }).join(' ');
  }

  function updatePageTitle() {
    let pageTitle = document.querySelector("h1");
    if (!pageTitle) return;

    const rawPath = getPageFromPath();
    const { departmentSlug, newsSlug, announcementSlug } = getQueryParams();

    let page = rawPath;

    if (newsSlug) {
      page = newsSlug;
    } else if (announcementSlug) {
      page = announcementSlug;
    } else if (rawPath === "colleges" && departmentSlug) {
      page = departmentSlug;
    }

    const pageTitles = {
      "university_background": "University Background",
      "university_profile": "University Profile",
      "vmgo": "Vision, Mission & Goals",
      "university_hymn": "Hymn",
      "colleges": "College of English",
      "program_offerings": "Program Offerings",
      "news": "News",
      "announcements": "Announcements",
      "admission_requirements": "Admission Requirements",
      "scholarships": "Scholarships",
      "university_library": "University Library",
      "contactus": "Contacts & Location",
      "forms": "Forms",
      "university_album": "University Album",
      "rector": "Rector",
      "board_of_directors": "Board of Directors",
      "univ_heads": "Head of Department and Head of Office",
      "job_opportunities": "Job Opportunities",
      "university_calendar": "University Calendar",
      "university_gallery": "University Gallery",
      "computer_laboratory": "Computer Laboratory"
    };

    if (page) {
      const fallbackTitle = formatTitle(page.replace(/-/g, " "));
      const title = pageTitles[page] || fallbackTitle;
      pageTitle.textContent = title;

      if (title.length > 80) {
        pageTitle.style.fontSize = "1.5rem";
      } else {
        pageTitle.style.fontSize = "";
      }
    } else {
      pageTitle.textContent = "General Information About University";
    }
  }

  updatePageTitle();
});







document.addEventListener("DOMContentLoaded", function () {
  function getPageFromPath() {
    const path = window.location.pathname;
    const pathParts = path.split('/');
    return pathParts[pathParts.length - 1] || "home";
  }

  function getPageFromPHP() {
    const path = window.location.pathname;

    // Manually detect "colleges&department_slug=XYZ" format
    const match = path.match(/colleges&department_slug=([^/]+)/);
    
    // If department_slug is detected, return "colleges" to trigger the correct banner
    return match ? "colleges" : null;
  }

  const bannerText = document.querySelector(".about-banner-updated");
  const page = getPageFromPHP() || getPageFromPath(); // Prioritize department_slug detection

  const bannerTexts = {
    "university_background": "Know more about our university.",
    "university_profile": "Know more about our university.",
    "vmgo": "Know more about our university.",
    "university_hymn": "Know more about our university.",
    "colleges": "Know more about our university.",
    "program_offerings": "We offer a range of programs designed to equip learners with the skills and knowledge they need for success. Explore our diverse courses across various fields.",
    "news": "Stay updated with the latest university news, events, and achievements.",
    "announcements": "Get the latest updates on academic schedules, events, and important university news. Stay informed and never miss an announcement.",
    "admission_requirements": "Find out the necessary documents and qualifications needed for admission to ensure a smooth application process.",
    "scholarships": "Explore available scholarship opportunities and financial aid programs designed to support students in achieving their academic goals.",
    "university_library": "Welcome to our college library.",
    "contactus": "Have any questions or need assistance?",
    "forms": "Here are some of the downloadable forms for UKT Students.",
    "rector": "Learn more about the management of the university.",
    "board_of_directors": "Learn more about the management of the university.",
    "univ_heads": "Learn more about the management of the university.",
    "job_opportunities": "Explore exciting career opportunities at UKT. We offer a variety of roles in different departments that provide a great work environment and growth potential. Check out our current openings and apply today!",
    "university_album": "Discover the best memories from campus life, graduation day, sports events, and more. Click an album to explore the images inside.",
    "news_view": "Read full description about this news",
    "announcement_view": "Read full description about this announcement",
     "university_calendar" : " Stay updated with important university events, academic schedules, holidays, and activities through our University Calendar.",
     "university_gallery" : " Explore the vibrant and diverse University Gallery, showcasing memorable events, moments, and student life at our campus. Discover the rich history and community spirit that define us.",
      "computer_laboratory" : "Know more about our University"
     
  };

  // Apply banner text
  bannerText.textContent = bannerTexts[page] || "Welcome to our website!";
});


document.addEventListener("DOMContentLoaded", function () {
    
    function getPageFromPHP() {
    const path = window.location.pathname;

    // Manually detect "colleges&department_slug=XYZ" format
    const match = path.match(/colleges&department_slug=([^/]+)/);
    
    // If department_slug is detected, return "colleges" to trigger the correct banner
    return match ? "colleges" : null;
  }
  function getPageFromPath() {
    const path = window.location.pathname; 
    const pathParts = path.split('/');
    return pathParts[pathParts.length - 1] || "home"; 
  }
  const bannerTag = document.querySelector(".banner-tag");
  const page = getPageFromPHP() || getPageFromPath(); // Prioritize department_slug detection

  const bannerTags = {
      "university_background": "ABOUT",
     "vmgo": "ABOUT",
      "university_profile": "ABOUT",
      "university_hymn": "ABOUT",
      "contactus": "ABOUT",
      "colleges": "Academics",
      "program_offerings": "Academics",
      "news": "Bulletin",
      "announcements": "Bulletin",
      "admission_requirements": "Student",
      "scholarships": "Student",
      "university_library": "Student",
      "forms": "Student",
      "university_album": "Campus life",
      "rector" : "Management",
      "board_of_directors" : "Management",
      "founder" : "Management",
      "univ_heads" : "Management",
      "job_opportunities" : "Bulletin",
      "news_view" : "News",
      "announcement_view" : "Announcement",
      "university_calendar" : "Bulletin",
      "university_gallery" : "Bulletin",
      "computer_laboratory": "Student"
  };

  bannerTag.textContent = bannerTags[page] || "PAGE NOT FOUND";
});

document.addEventListener("DOMContentLoaded", function () {
  function getPageFromPHP() {
    const path = window.location.pathname;

    // Match the department slug from the path like /colleges&department_slug=ics
    const match = path.match(/colleges&department_slug=([^/?#]+)/);

    // Decode the matched value to remove URL encoding (e.g., %20 -> space)
    return match ? decodeURIComponent(match[1]) : null;
  }

  function getPageFromPath() {
    const path = window.location.pathname;
    const pathParts = path.split('/');
    return pathParts[pathParts.length - 1] || "home";
  }

  function formatTitle(title) {
    // List of small words that should stay lowercase unless they are at the start or end of the title
    const lowercaseWords = ['of', 'and', 'the', 'in', 'to', 'with', 'a', 'an', 'for', 'on', 'at', 'by', 'between', 'from'];

    // Split the title into words
    const words = title.replace(/-/g, " ").split(" ");

    // Function to determine if a word should be uppercase or lowercase
    return words.map((word, index) => {
      // Capitalize the first and last word of the sentence
      if (index === 0 || index === words.length - 1) {
        return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
      }

      // Capitalize proper nouns (e.g., "State", "University", etc.)
      if (isProperNoun(word)) {
        return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
      }

      // Lowercase small words unless they are the first or last word
      if (lowercaseWords.includes(word.toLowerCase())) {
        return word.toLowerCase();
      }

      // Default: capitalize significant words (nouns, verbs, adjectives, etc.)
      return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
    }).join(" ");
  }

  // Helper function to detect proper nouns
  function isProperNoun(word) {
    const properNouns = ['State', 'University', 'Republic', 'President', 'Kingdom', 'City']; // Add more proper nouns if needed
    return properNouns.includes(word.charAt(0).toUpperCase() + word.slice(1).toLowerCase());
  }

  function adjustFontSize(element) {
    const title = element.textContent;
    const maxLength = 80; // Set a maximum length threshold for adjusting font size

    // If the title length exceeds the threshold, reduce the font size
    if (title.length > maxLength) {
      element.style.fontSize = "13px"; // Smaller font size for long titles
    } else {
      element.style.fontSize = "inherit"; // Use default font size
    }
  }

  const breadcrumbContainer = document.querySelector(".custom-breadcrumb"); // Use custom-breadcrumb here
  let page = getPageFromPHP() || getPageFromPath();
  const pageSlug = window.location.pathname.split("/").pop(); // Gets the last part of the URL (e.g., news_view or something else)

  const breadcrumbTitles = {
    "university_background": "University Background",
    "vmgo": "Vision, Mission & Goals",
    "university_profile": "University Profile",
    "university_hymn": "Hymn",
    "news": "News",
    "announcements": "Announcements",
    "program_offerings": "Program Offerings",
    "admission_requirements": "Admission Requirements",
    "forms": "Forms",
    "university_album": "University Album",
    "rector": "Rector",
    "board_of_directors": "Board of Directors",
    "univ_heads": "Head of Department and Head of Office",
    "contactus": "Contact & Location",
    "job_opportunities": "Job Opportunities",
    "university_calendar": "University Calendar",
    "university_gallery": "University Gallery",
     "computer_laboratory": "Computer Laboratory",
  };

  // Logic for handling 'news_view' page breadcrumbs
  if (pageSlug === "news_view") {
    const newsSlug = new URLSearchParams(window.location.search).get('news_slug');
    const newsTitle = newsSlug ? formatTitle(newsSlug) : "News View";

    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <a href="news" class="breadcrumb-link">News</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${newsTitle}</span>
    `;

    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }

  // Logic for handling 'announcement_view' page breadcrumbs
  else if (pageSlug === "announcement_view") {
    const announcementSlug = new URLSearchParams(window.location.search).get('announcement_slug');
    const announcementTitle = announcementSlug ? formatTitle(announcementSlug) : "Announcement View";
    
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <a href="announcements" class="breadcrumb-link">Announcements</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${announcementTitle}</span>
    `;

    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
  
   else if (pageSlug === "colleges") {
  const collegeSlug = new URLSearchParams(window.location.search).get('department_slug');
  const collegeTitle = collegeSlug ? formatTitle(collegeSlug) : "Colleges";
  
  breadcrumbContainer.innerHTML = ` 
    <a href="home" class="breadcrumb-link">Home</a>
    <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">Academics</span>
    <i class="ri-arrow-right-s-line separator-icon"></i>
    <span class="breadcrumb-active">${collegeTitle}</span>
  `;

  adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
}

  
  else if (pageSlug === "forms") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">Student</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
 else if (pageSlug === "university_background") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">About</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
  else if (pageSlug === "university_profile") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">About</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
   else if (pageSlug === "contactus") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">About</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
     else if (pageSlug === "hymn") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">About</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
   else if (pageSlug === "vmgo") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">About</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
  else if (pageSlug === "university_hymn") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">About</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
    else if (pageSlug === "news") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">Bulletin</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
   else if (pageSlug === "job_opportunities") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">Bulletin</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
  else if (pageSlug === "announcements") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">Bulletin</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
   else if (pageSlug === "university_gallery") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">Bulletin</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
   else if (pageSlug === "program_offerings") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">Academics</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
   else if (pageSlug === "rector") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">Management</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
  else if (pageSlug === "board_of_directors") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">Management</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
  else if (pageSlug === "founder") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">Management</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
  else if (pageSlug === "university_calendar") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">Bulletin</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
   else if (pageSlug === "univ_heads") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">Management</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
  else if (pageSlug === "admission_requirements") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">Student</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
   else if (pageSlug === "scholarships") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">Student</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
   else if (pageSlug === "computer_laboratory") {
  breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">Student</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
  
  
  // Default breadcrumb for other pages
  else {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">Home</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page) || "Page Not Found"}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector('.breadcrumb-active'));
  }
  
});




// document.addEventListener("DOMContentLoaded", function () {
//      function getPageFromPHP() {
//     const path = window.location.pathname;
//     const match = path.match(/colleges&department_slug=([^&/]+)/); 
//     return match ? match[1] : null; 
//   }

//   function getPageFromPath() {
//     const path = window.location.pathname; 
//     const pathParts = path.split('/'); 
//     return pathParts[pathParts.length - 1] || "home"; 
//   }
//   const banner = document.querySelector(".about-banner");
//   const page = getPageFromPath(); 

//   const backgroundImages = {
//       "university_background": "assets/images/aboutunivprofile.png",
//       "vmgo": "assets/images/aboutunivprofile.png",
//       "university_profile": "assets/images/aboutunivprofile.png",
//       "university_hymn": "assets/images/aboutunivprofile.png",
//       "colleges": "assets/images/colleges/COE.jpg",
//       "board_of_directors" : "assets/images/aboutunivprofile.png"
//   };

//   const bgImage = backgroundImages[page] || "assets/images/aboutunivprofile.png";
//   banner.style.background = `linear-gradient(to right, rgba(78, 78, 78, 0.64), rgba(0, 70, 0, 0.57)), url('${bgImage}')`;
//   banner.style.backgroundSize = "cover";
//   banner.style.backgroundPosition = "center";
//   banner.style.backgroundAttachment = "fixed";
// });

document.addEventListener("DOMContentLoaded", function () {
  // Function to get the department slug from the URL query string (if it exists)
  function getPageFromPHP() {
  const path = window.location.pathname;
  const query = window.location.search;

  // Match department slug from URL path (e.g., /colleges&department_slug=ics)
  const deptMatch = path.match(/colleges&department_slug=([^/?#]+)/);

  // Match news_slug from query string (e.g., ?news_slug=sample-news)
  const newsMatch = query.match(/news_slug=([^&]+)/);

  // Match announcement_slug from query string (e.g., ?announcement_slug=sample-announcement)
  const announcementMatch = query.match(/announcement_slug=([^&]+)/);

  // Decode any matched value to remove %20, etc.
  const matchedValue = deptMatch ? deptMatch[1] :
                       newsMatch ? newsMatch[1] :
                       announcementMatch ? announcementMatch[1] : null;

  return matchedValue ? decodeURIComponent(matchedValue) : null;
  }

  // Function to get the last part of the URL path (if no PHP parameter exists)
  function getPageFromPath() {
    const path = window.location.pathname;
    const pathParts = path.split('/');
    return pathParts[pathParts.length - 1] || "home";
  }

  // Function to format title by replacing hyphens with spaces and capitalizing each word
  function formatTitle(title) {
    return title
      .replace(/-/g, " ") // Replace hyphens with spaces
      .split(" ") // Split into an array of words
      .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()) // Capitalize each word
      .join(" "); // Join back into a string
  }

  // Determine the page from PHP or the path
  const page = getPageFromPHP() || getPageFromPath();

  // Page titles mapping
  const pageTitles = {
    "university_background": "University Background",
    "vmgo": "Vision, Mission & Goals",
    "university_profile": "University Profile",
    "university_hymn": "Hymn",
    "news": "News",
    "announcements": "Announcements",
    "program_offerings": "Program Offerings",
    "admission_requirements": "Admission Requirements",
    "forms": "Forms",
    "university_album": "University Album",
    "rector": "Rector សាកលវិទ្យាធិការ",
    "board_of_directors": "Board of Directors",
    "univ_heads": "Head of Department and Head of Office",
    "contactus": "Contact & Location",
    "scholarships": "Scholarships",
    "computer_laboratory": "Computer Laboratory",
    
  };

  // Get the title for the current page or use a default
  const pageTitle = pageTitles[page] || formatTitle(page) || "University of Kratie";

  // Set the document title with the page title
  document.title = page === "home" ? pageTitle : `${pageTitle} - University of Kratie`;
});

