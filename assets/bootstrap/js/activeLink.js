// document.addEventListener("DOMContentLoaded", function () {
//   const pageTitle = document.querySelector("h5.fw-bold");

//   const currentPage = window.location.pathname.split("/").pop();
//   if (currentPage === "announcement.php") {
//     pageTitle.textContent = "Announcement";
//   }
//   else if (currentPage === "news.php") {
//     pageTitle.textContent = "News";
//   }
//   else if (currentPage === "page_poster.php") {
//     pageTitle.textContent = "Page Poster";
//   }
//   else if (currentPage === "Manage_Department.php") {
//     pageTitle.textContent = "Department";
//   }
//   else if (currentPage === "view_department.php") {
//     pageTitle.textContent = "Department";
//   }
//   else if (currentPage === "admission_requirements.php") {
//     pageTitle.textContent = "Student";
//   }
//   else if (currentPage === "downloadable_forms.php") {
//     pageTitle.textContent = "Student";
//   }
//   else if (currentPage === "developers.php") {
//     pageTitle.textContent = "About";
//   }
//   else if (currentPage === "university_profile.php") {
//     pageTitle.textContent = "About";
//   }
//   else if (currentPage === "university_background.php") {
//     pageTitle.textContent = "About";
//   }
//   else if (currentPage === "university_vmgo.php") {
//     pageTitle.textContent = "About";
//   }
//   else if (currentPage === "contact_location.php") {
//     pageTitle.textContent = "About";
//   }
//   else if (currentPage === "scholarship.php") {
//     pageTitle.textContent = "Student";
//   }
//   else if (currentPage === "Board_of_Directors.php") {
//     pageTitle.textContent = "Management";
//   }
//   else if (currentPage === "Head_of_Dep_and_office.php") {
//     pageTitle.textContent = "Management";
//   }
//   else if (currentPage === "view_admin_profile.php") {
//     pageTitle.textContent = "Profile";
//   }
//   else if (currentPage === "update_profile.php") {
//     pageTitle.textContent = "Profile";
//   }
//   else if (currentPage === "Logs.php") {
//     pageTitle.textContent = "Logs";
//   }
//   else if (currentPage === "archive.php") {
//     pageTitle.textContent = "Archive";
//   }
//   else if (currentPage === "site_settings.php") {
//     pageTitle.textContent = "Site Settings";
//   }
//   else if (currentPage === "pending_account.php") {
//     pageTitle.textContent = "User Account";
//   }
//   else if (currentPage === "approved_account.php") {
//     pageTitle.textContent = "User Account";
//   }
//   else if (currentPage === "University_Library_resources.php") {
//     pageTitle.textContent = "University Library";
//   }
//   else if (currentPage === "University_Library_updates.php") {
//     pageTitle.textContent = "University Library";
//   }
//   else if (currentPage === "University_Library_operating_hrs.php") {
//     pageTitle.textContent = "University Library";
//   }
//   else if (currentPage === "University_Library_Research_Projects.php") {
//     pageTitle.textContent = "University Library";
//   }
//   else if (currentPage === "student_org.php") {
//     pageTitle.textContent = "Student Oranizations";
//   }
//   else if (currentPage === "manage_org.php") {
//     pageTitle.textContent = "Manage Organization";
//   }
  
  
  

// });
// document.addEventListener("DOMContentLoaded", function () {
//   const pageTitle = document.querySelector("h5.fw-bold");

//   // Get the last part of the URL and remove ".php" if it exists
//   let currentPage = window.location.pathname.split("/").pop().toLowerCase().replace(".php", "");

//   console.log("Current Page:", currentPage); // Debugging output

//   if (currentPage === "announcement") {
//     pageTitle.textContent = "Announcement";
//   }
//   else if (currentPage === "news") {
//     pageTitle.textContent = "News";
//   }
//   else if (currentPage === "page_poster") {
//     pageTitle.textContent = "Page Poster";
//   }
//   else if (currentPage === "Manage_Department") {
//     pageTitle.textContent = "Department";
//   }
//   else if (currentPage === "view_department") {
//     pageTitle.textContent = "Department";
//   }
//   else if (currentPage === "admission_requirements") {
//     pageTitle.textContent = "Student";
//   }
//   else if (currentPage === "downloadable_forms") {
//     pageTitle.textContent = "Student";
//   }
//   else if (currentPage === "developers") {
//     pageTitle.textContent = "About";
//   }
//   else if (currentPage === "university_profile") {
//     pageTitle.textContent = "About";
//   }
//   else if (currentPage === "university_background") {
//     pageTitle.textContent = "About";
//   }
//   else if (currentPage === "university_vmgo") {
//     pageTitle.textContent = "About";
//   }
//   else if (currentPage === "contact_location") {
//     pageTitle.textContent = "About";
//   }
//   else if (currentPage === "scholarship") {
//     pageTitle.textContent = "Student";
//   }
//   else if (currentPage === "Board_of_Directors") {
//     pageTitle.textContent = "Management";
//   }
//   else if (currentPage === "Head_of_Dep_and_office") {
//     pageTitle.textContent = "Management";
//   }
//   else if (currentPage === "view_admin_profile") {
//     pageTitle.textContent = "Profile";
//   }
//   else if (currentPage === "update_profile") {
//     pageTitle.textContent = "Profile";
//   }
//   else if (currentPage === "Logs") {
//     pageTitle.textContent = "Logs";
//   }
//   else if (currentPage === "archive") {
//     pageTitle.textContent = "Archive";
//   }
//   else if (currentPage === "site_settings") {
//     pageTitle.textContent = "Site Settings";
//   }
//   else if (currentPage === "pending_account") {
//     pageTitle.textContent = "User Account";
//   }
//   else if (currentPage === "approved_account") {
//     pageTitle.textContent = "User Account";
//   }
//   else if (currentPage === "University_Library_resources") {
//     pageTitle.textContent = "University Library";
//   }
//   else if (currentPage === "University_Library_updates") {
//     pageTitle.textContent = "University Library";
//   }
//   else if (currentPage === "University_Library_operating_hrs") {
//     pageTitle.textContent = "University Library";
//   }
//   else if (currentPage === "University_Library_Research_Projects") {
//     pageTitle.textContent = "University Library";
//   }
//   else if (currentPage === "student_org") {
//     pageTitle.textContent = "Student Oranizations";
//   }
//   else if (currentPage === "manage_org.php") {
//     pageTitle.textContent = "Manage Organization";
//   }
// });

// document.addEventListener("DOMContentLoaded", function () {
//     const currentPage = window.location.pathname.split("/").pop();
//     const targetPages = ["page_management.php","announcement.php","news.php","page_poster.php","Logs.php","archive.php","site_settings.php"];
//     const menuItems = document.querySelectorAll(".sidebar-menu-item a");
//     menuItems.forEach(item => {
//         const menuHref = item.getAttribute("href");
//         if (targetPages.includes(menuHref)) {
//             if (menuHref === currentPage) {
//                 item.parentElement.classList.add("active");
//             } else {
//                 item.parentElement.classList.remove("active");
//             }
//         }
//     });
// });


document.addEventListener("DOMContentLoaded", function () {
  const pageTitle = document.querySelector("h5.fw-bold");

  // Get the last part of the URL and remove ".php" if it exists
  let currentPage = window.location.pathname.split("/").pop().toLowerCase().replace(".php", "");

  console.log("Current Page:", currentPage); // Debugging output

  if (currentPage === "announcement") {
    pageTitle.textContent = "Announcement";
  }
  else if (currentPage === "university_album") {
    pageTitle.textContent = "University Gallery";
  }
  else if (currentPage === "view_album") {
    pageTitle.textContent = "University Gallery";
  }
  else if (currentPage === "news") {
    pageTitle.textContent = "News";
  }
  else if (currentPage === "job_opportunities") {
    pageTitle.textContent = "Job Opportunity";
  }
  else if (currentPage === "job_vacancy") {
    pageTitle.textContent = "Job Vacancy";
  }
  else if (currentPage === "message") {
    pageTitle.textContent = "Messages Inbox";
  }
  else if (currentPage === "sent_items") {
    pageTitle.textContent = "Sent Items";
  }
  else if (currentPage === "view_message") {
    pageTitle.textContent = "Viewing Messages";
  }
  else if (currentPage === "page_poster") {
    pageTitle.textContent = "Page Poster";
  }
  else if (currentPage === "Manage_Department") {
    pageTitle.textContent = "Department";
  }
  else if (currentPage === "view_department") {
    pageTitle.textContent = "Department";
  }
  else if (currentPage === "admission_requirements") {
    pageTitle.textContent = "Student";
  }
  else if (currentPage === "downloadable_forms") {
    pageTitle.textContent = "Student";
  }
  else if (currentPage === "developers") {
    pageTitle.textContent = "About";
  }
  else if (currentPage === "university_profile") {
    pageTitle.textContent = "About";
  }
  else if (currentPage === "university_background") {
    pageTitle.textContent = "About";
  }
  else if (currentPage === "university_vmgo") {
    pageTitle.textContent = "About";
  }
  else if (currentPage === "contact_location") {
    pageTitle.textContent = "About";
  }
  else if (currentPage === "scholarship") {
    pageTitle.textContent = "Student";
  }
  else if (currentPage === "Board_of_Directors") {
    pageTitle.textContent = "Management";
  }
  else if (currentPage === "Head_of_Dep_and_office") {
    pageTitle.textContent = "Management";
  }
  else if (currentPage === "view_admin_profile") {
    pageTitle.textContent = "Profile";
  }
  else if (currentPage === "update_profile") {
    pageTitle.textContent = "Profile";
  }
  else if (currentPage === "logs") {
    pageTitle.textContent = "Logs";
  }
  else if (currentPage === "archive") {
    pageTitle.textContent = "Archived Highlights";
  }
  else if (currentPage === "archive_message") {
    pageTitle.textContent = "Archived Message";
  }
  else if (currentPage === "archive_partnership") {
    pageTitle.textContent = "Archived Partnership";
  }
  else if (currentPage === "archive_calendar") {
    pageTitle.textContent = "Archived Event";
  }
  else if (currentPage === "archive_faq") {
    pageTitle.textContent = "Archived FAQ";
  }
  else if (currentPage === "archive_announcement") {
    pageTitle.textContent = "Archived Announcement";
  }
  else if (currentPage === "archive_album") {
    pageTitle.textContent = "Archived Gallery";
  }
  else if (currentPage === "archive_news") {
    pageTitle.textContent = "Archived News";
  }
  else if (currentPage === "archive_poster") {
    pageTitle.textContent = "Archived Poster";
  }
  else if (currentPage === "archive_admissionrequirements") {
    pageTitle.textContent = "Archived Admission Requirements";
  }
  else if (currentPage === "archive_scholarship") {
    pageTitle.textContent = "Archived Scholarship";
  }
  else if (currentPage === "site_settings") {
    pageTitle.textContent = "Site Settings";
  }
  else if (currentPage === "pending_account") {
    pageTitle.textContent = "User Account";
  }
  else if (currentPage === "approved_account") {
    pageTitle.textContent = "User Account";
  }
  else if (currentPage === "University_Library_resources") {
    pageTitle.textContent = "University Library";
  }
  else if (currentPage === "University_Library_updates") {
    pageTitle.textContent = "University Library";
  }
  else if (currentPage === "University_Library_operating_hrs") {
    pageTitle.textContent = "University Library";
  }
  else if (currentPage === "University_Library_Research_Projects") {
    pageTitle.textContent = "University Library";
  }
  else if (currentPage === "student_org") {
    pageTitle.textContent = "Student Oranizations";
  }
  else if (currentPage === "library_gallery") {
    pageTitle.textContent = "Library Gallery";
  }
  else if (currentPage === "library_images") {
    pageTitle.textContent = "Library Gallery";
  }
  else if (currentPage === "library_staff") {
    pageTitle.textContent = "Library Staff";
  }
  else if (currentPage === "manage_org.php") {
    pageTitle.textContent = "Manage Organization";
  }
  else if (currentPage === "program_offered") {
    pageTitle.textContent = "Student";
  }
  else if (currentPage === "manage_program") {
    pageTitle.textContent = "Manage Program";
  }
     else if (currentPage === "computer_laboratory") {
    pageTitle.textContent = "Computer Laboratory";
  }

});

// document.addEventListener("DOMContentLoaded", function () {
//     const currentPage = window.location.pathname.split("/").pop();
//     const targetPages = ["page_management.php","announcement.php","news.php","page_poster.php","Logs.php","archive.php","site_settings.php"];
//     const menuItems = document.querySelectorAll(".sidebar-menu-item a");
//     menuItems.forEach(item => {
//         const menuHref = item.getAttribute("href");
//         if (targetPages.includes(menuHref)) {
//             if (menuHref === currentPage) {
//                 item.parentElement.classList.add("active");
//             } else {
//                 item.parentElement.classList.remove("active");
//             }
//         }
//     });
// });

document.addEventListener("DOMContentLoaded", function () {
  let currentPage = window.location.pathname.split("/").pop().toLowerCase().replace(".php", "");

  const targetPages = [
      "page_management", "university_album", "message", "sent_items","view_album", "view_message", "announcement",
      "news", "job_opportunities", "page_poster", "logs", "archive", "archive_message", "site_settings",
      "library_gallery", "library_staff"
  ]; 

  const menuItems = document.querySelectorAll(".sidebar-menu-item a");

  menuItems.forEach(item => {
      const menuHref = item.getAttribute("href").split("/").pop().toLowerCase().replace(".php", ""); 

      if (targetPages.includes(menuHref)) {
        if (menuHref === currentPage || (currentPage === "view_album" && menuHref === "university_album")) {
            item.parentElement.classList.add("active");
        }
    }

      if (targetPages.includes(menuHref)) {
          if (menuHref === currentPage || (currentPage === "archive_message" && menuHref === "archive")) {
              item.parentElement.classList.add("active");
          }
      }
      if (targetPages.includes(menuHref)) {
        if (menuHref === currentPage || (currentPage === "sent_items" && menuHref === "message")) {
            item.parentElement.classList.add("active");
        }
      } 
      if (targetPages.includes(menuHref)) {
        if (menuHref === currentPage || (currentPage === "archive_partnership" && menuHref === "archive")) {
            item.parentElement.classList.add("active");
        }
      } 
      if (targetPages.includes(menuHref)) {
        if (menuHref === currentPage || (currentPage === "archive_calendar" && menuHref === "archive")) {
            item.parentElement.classList.add("active");
        }
      } 
      if (targetPages.includes(menuHref)) {
        if (menuHref === currentPage || (currentPage === "archive_faq" && menuHref === "archive")) {
            item.parentElement.classList.add("active");
        }
      } 
      if (targetPages.includes(menuHref)) {
        if (menuHref === currentPage || (currentPage === "archive_announcement" && menuHref === "archive")) {
            item.parentElement.classList.add("active");
        }
      } 
      if (targetPages.includes(menuHref)) {
        if (menuHref === currentPage || (currentPage === "archive_album" && menuHref === "archive")) {
            item.parentElement.classList.add("active");
        }
      } 
      if (targetPages.includes(menuHref)) {
        if (menuHref === currentPage || (currentPage === "archive_news" && menuHref === "archive")) {
            item.parentElement.classList.add("active");
        }
      }
      if (targetPages.includes(menuHref)) {
        if (menuHref === currentPage || (currentPage === "archive_poster" && menuHref === "archive")) {
            item.parentElement.classList.add("active");
        }
      }
      if (targetPages.includes(menuHref)) {
        if (menuHref === currentPage || (currentPage === "archive_admissionrequirements" && menuHref === "archive")) {
            item.parentElement.classList.add("active");
        }
      }
      if (targetPages.includes(menuHref)) {
        if (menuHref === currentPage || (currentPage === "archive_scholarship" && menuHref === "archive")) {
            item.parentElement.classList.add("active");
        }
      }
      if (targetPages.includes(menuHref)) {
        if (menuHref === currentPage || (currentPage === "job_vacancy" && menuHref === "job_opportunities")) {
            item.parentElement.classList.add("active");
        }
      }
      
      
  
  });
});
