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
  // Function to get the department slug from the URL query string (like 'ics', 'ied', etc.)
  function getPageFromPHP() {
    const path = window.location.pathname;

    // Check if the path contains 'colleges&department_slug=' and extract the value
    const match = path.match(/colleges&department_slug=([^/]+)/);
    return match ? match[1] : null; // Return the department slug or null if not found
  }

  // Function to get the last part of the URL path (if no PHP parameter exists)
  function getPageFromPath() {
    const path = window.location.pathname;
    const pathParts = path.split('/');
    return pathParts[pathParts.length - 1] || "home"; // Use the last part of the URL or "home" as a fallback
  }

  function updatePageTitle() {
    let pageTitle = document.querySelector("h1");
    if (!pageTitle) return;

    // Prioritize the PHP parameter (department slug) over the URL path
    let page = getPageFromPHP() || getPageFromPath();

    // Titles for known pages based on the slug (no hyphens in titles now)
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
      "job_opportunities": "Job Opportunities"
    };

    // If the page is a department slug like 'ics', use it directly
    if (page) {
      pageTitle.textContent = pageTitles[page] || page.replace(/-/g, " ").toUpperCase() || "General Information About University";
    } else {
      pageTitle.textContent = "General Information About University"; // Default title
    }
  }

  updatePageTitle(); // Run on initial page load

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
    "colleges": "Colleges are institutions of higher learning that offer specialized education, skill development, and research opportunities to prepare students for professional careers.",
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
    "university_album": "Discover the best memories from campus life, graduation day, sports events, and more. Click an album to explore the images inside."
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
      "colleges": "Department",
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
      "univ_heads" : "Management",
      "job_opportunities" : "Bulletin"
  };

  bannerTag.textContent = bannerTags[page] || "PAGE NOT FOUND";
});

document.addEventListener("DOMContentLoaded", function () {
  function getPageFromPHP() {
    const path = window.location.pathname;
    const match = path.match(/colleges&department_slug=([^&/]+)/); 
    return match ? match[1] : null; 
  }

  function getPageFromPath() {
    const path = window.location.pathname;
    const pathParts = path.split('/'); 
    return pathParts[pathParts.length - 1] || "home"; 
  }
  
   function formatTitle(title) {
   
    return title
      .replace(/-/g, " ") 
      .split(" ") 
      .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()) 
      .join(" "); 
  }

  const breadcrumbTitle = document.querySelector(".breadcrumb-item.active");
  let page = getPageFromPHP() || getPageFromPath();

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
    "rector": "Rector សាកលវិទ្យាធិការ",
    "board_of_directors": "Board of Directors",
    "univ_heads": "Head of Department and Head of Office",
    "contactus": "Contact & Location",
    "job_opportunities": "Job Opportunities",
  };

  breadcrumbTitle.textContent = breadcrumbTitles[page] || formatTitle(page) ||"Page Not Found";
});


document.addEventListener("DOMContentLoaded", function () {
     function getPageFromPHP() {
    const path = window.location.pathname;
    const match = path.match(/colleges&department_slug=([^&/]+)/); 
    return match ? match[1] : null; 
  }

  function getPageFromPath() {
    const path = window.location.pathname; 
    const pathParts = path.split('/'); 
    return pathParts[pathParts.length - 1] || "home"; 
  }
  const banner = document.querySelector(".about-banner");
  const page = getPageFromPath(); 

  const backgroundImages = {
      "university_background": "assets/images/aboutunivprofile.png",
      "vmgo": "assets/images/aboutunivprofile.png",
      "university_profile": "assets/images/aboutunivprofile.png",
      "university_hymn": "assets/images/aboutunivprofile.png",
      "colleges": "assets/images/colleges/COE.jpg",
      "board_of_directors" : "assets/images/carl eto.gif"
  };

  const bgImage = backgroundImages[page] || "assets/images/aboutunivprofile.png";
  banner.style.background = `linear-gradient(to right, rgba(78, 78, 78, 0.64), rgba(0, 70, 0, 0.57)), url('${bgImage}')`;
  banner.style.backgroundSize = "cover";
  banner.style.backgroundPosition = "center";
  banner.style.backgroundAttachment = "fixed";
});

document.addEventListener("DOMContentLoaded", function () {
  // Function to get the department slug from the URL query string (if it exists)
  function getPageFromPHP() {
    const path = window.location.pathname;
    const match = path.match(/colleges&department_slug=([^&/]+)/);
    return match ? match[1] : null;
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
    "university_library": "University Library",
     "job_opportunities": "Job Opportunities"
  };

  // Get the title for the current page or use a default
  const pageTitle = pageTitles[page] || formatTitle(page) || "University of Kratie";

  // Set the document title with the page title
  document.title = page === "home" ? pageTitle : `${pageTitle} - University of Kratie`;
});

