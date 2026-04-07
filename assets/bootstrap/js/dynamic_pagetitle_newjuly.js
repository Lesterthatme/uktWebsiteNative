document.addEventListener("DOMContentLoaded", function () {
  function getQueryParams() {
    const query = new URLSearchParams(window.location.search);
    return {
      departmentSlug: query.get("department_slug"),
      newsSlug: query.get("news_slug"),
      announcementSlug: query.get("announcement_slug"),
    };
  }

  function getPageFromPath() {
    const path = window.location.pathname;
    const pathParts = path.split("/");
    return pathParts[pathParts.length - 1] || "home";
  }

  function formatTitle(title) {
    const lowercaseWords = [
      "of",
      "and",
      "the",
      "in",
      "to",
      "with",
      "a",
      "an",
      "for",
      "on",
      "at",
      "by",
      "between",
      "from",
    ];
    const words = title.split(" ");

    return words
      .map((word, index) => {
        if (index === 0 || !lowercaseWords.includes(word.toLowerCase())) {
          return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
        }
        return word.toLowerCase();
      })
      .join(" ");
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
      university_background: "ប្រវត្តិសាកលវិទ្យាល័យ",
      university_profile: "ប្រវត្តិរូបសាកលវិទ្យាល័យ",
      vmgo: "ចក្ខុវិស័យ បេសកកម្ម និងគោលដៅ",
      university_hymn: "ទំនុកតម្កើង",
      colleges: "មហាវិទ្យាល័យភាសាអង់គ្លេស",
      program_offerings: "ការផ្តល់ជូនកម្មវិធី",
      news: "ព័ត៌មាន",
      announcements: "ការប្រកាស",
      admission_requirements: "តម្រូវការចូលរៀន",
      scholarships: "អាហារូបករណ៍",
      university_library: "បណ្ណាល័យសាកលវិទ្យាល័យ",
      contactus: "ទំនាក់ទំនង និងទីតាំង",
      forms: "ទម្រង់បែបបទ",
      university_album: "អាល់ប៊ុមសាកលវិទ្យាល័យ",
      rector: "សាកលវិទ្យាធិការ",
      board_of_directors: "ក្រុមប្រឹក្សាភិបាល",
      univ_heads: "ប្រធាននាយកដ្ឋាន និងប្រធានការិយាល័យ",
      job_opportunities: "ឱកាសការងារ",
      university_calendar: "ប្រតិទិនសាកលវិទ្យាល័យ",
      university_gallery: "វិចិត្រសាលសាកលវិទ្យាល័យ",
      computer_laboratory: "មន្ទីរពិសោធន៍កុំព្យូទ័រ",
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
    const pathParts = path.split("/");
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
    university_background: "ស្វែងយល់បន្ថែមអំពីសាកលវិទ្យាល័យរបស់យើង។",
    university_profile: "ស្វែងយល់បន្ថែមអំពីសាកលវិទ្យាល័យរបស់យើង។",
    vmgo: "ស្វែងយល់បន្ថែមអំពីសាកលវិទ្យាល័យរបស់យើង។",
    university_hymn: "ស្វែងយល់បន្ថែមអំពីសាកលវិទ្យាល័យរបស់យើង។",
    colleges: "ស្វែងយល់បន្ថែមអំពីសាកលវិទ្យាល័យរបស់យើង។",

    program_offerings:
      "យើងផ្តល់ជូនកម្មវិធីសិក្សាជាច្រើន ដែលត្រូវបានរចនាឡើងដើម្បីបំពាក់ជំនាញ និងចំណេះដឹងដល់សិស្សនិស្សិតសម្រាប់ភាពជោគជ័យ។ សូមស្វែងរកវគ្គសិក្សាចម្រុះនៅក្នុងវិស័យផ្សេងៗ។",

    news: "សូមធ្វើបច្ចុប្បន្នភាពជាមួយព័ត៌មានថ្មីៗ ព្រឹត្តិការណ៍ និងសមិទ្ធផលរបស់សាកលវិទ្យាល័យ។",

    announcements:
      "ទទួលបានព័ត៌មានថ្មីៗអំពីកាលវិភាគសិក្សា ព្រឹត្តិការណ៍ និងព័ត៌មានសំខាន់ៗរបស់សាកលវិទ្យាល័យ។ សូមរក្សាការយល់ដឹង និងកុំឲ្យខកខានសេចក្តីជូនដំណឹងណាមួយ។",

    admission_requirements:
      "សូមពិនិត្យឯកសារ និងលក្ខខណ្ឌដែលត្រូវការសម្រាប់ការចូលរៀន ដើម្បីធានាដំណើរការដាក់ពាក្យមានភាពរលូន។",

    scholarships:
      "ស្វែងរកឱកាសអាហារូបករណ៍ និងកម្មវិធីជំនួយហិរញ្ញវត្ថុ ដែលមានគោលបំណងគាំទ្រសិស្សនិស្សិតឲ្យសម្រេចគោលដៅសិក្សា។",

    university_library: "សូមស្វាគមន៍មកកាន់បណ្ណាល័យសាកលវិទ្យាល័យរបស់យើង។",

    contactus: "មានសំណួរ ឬត្រូវការជំនួយមែនទេ?",

    forms: "នេះជាបែបបទដែលអាចទាញយកបានសម្រាប់និស្សិត UKT។",

    rector: "ស្វែងយល់បន្ថែមអំពីការគ្រប់គ្រងរបស់សាកលវិទ្យាល័យ។",

    board_of_directors: "ស្វែងយល់បន្ថែមអំពីការគ្រប់គ្រងរបស់សាកលវិទ្យាល័យ។",

    univ_heads: "ស្វែងយល់បន្ថែមអំពីការគ្រប់គ្រងរបស់សាកលវិទ្យាល័យ។",

    job_opportunities:
      "ស្វែងរកឱកាសការងារដ៏គួរឱ្យចាប់អារម្មណ៍នៅ UKT។ យើងផ្តល់ជូនតួនាទីជាច្រើននៅក្នុងនាយកដ្ឋានផ្សេងៗ ដែលមានបរិយាកាសការងារល្អ និងឱកាសអភិវឌ្ឍន៍ខ្លួន។ សូមពិនិត្យមើលឱកាសបច្ចុប្បន្ន និងដាក់ពាក្យថ្ងៃនេះ!",

    university_album:
      "ស្វែងរកអនុស្សាវរីយ៍ល្អៗពីជីវិតក្នុងសាលា ពិធីបញ្ចប់ការសិក្សា ព្រឹត្តិការណ៍កីឡា និងច្រើនទៀត។ ចុចលើអាល់ប៊ុមដើម្បីមើលរូបភាពខាងក្នុង។",

    news_view: "អានព័ត៌មានលម្អិតពេញលេញ",

    announcement_view: "អានសេចក្តីជូនដំណឹងលម្អិតពេញលេញ",

    university_calendar:
      "ធ្វើបច្ចុប្បន្នភាពជាមួយព្រឹត្តិការណ៍សំខាន់ៗ កាលវិភាគសិក្សា ថ្ងៃឈប់សម្រាក និងសកម្មភាពផ្សេងៗ តាមរយៈប្រតិទិនសាកលវិទ្យាល័យ។",

    university_gallery:
      "ស្វែងរកវិចិត្រសាលសាកលវិទ្យាល័យ ដែលបង្ហាញពីព្រឹត្តិការណ៍ សកម្មភាព និងជីវិតនិស្សិតនៅក្នុងបរិវេណសាលា។ សូមស្វែងយល់អំពីប្រវត្តិសាស្ត្រ និងសហគមន៍ដ៏រឹងមាំរបស់យើង។",

    computer_laboratory:
      "ស្វែងយល់បន្ថែមអំពីមន្ទីរពិសោធន៍កុំព្យូទ័ររបស់សាកលវិទ្យាល័យ។",
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
    const pathParts = path.split("/");
    return pathParts[pathParts.length - 1] || "home";
  }
  const bannerTag = document.querySelector(".banner-tag");
  const page = getPageFromPHP() || getPageFromPath(); // Prioritize department_slug detection

  const bannerTags = {
    university_background: "អំពី",
    vmgo: "អំពី",
    university_profile: "អំពី",
    university_hymn: "អំពី",
    contactus: "អំពី",
    colleges: "ពី",
    program_offerings: "ពី",
    news: "ព្រឹត្តិបត្រ",
    announcements: "ព្រឹត្តិបត្រ",
    admission_requirements: "សិស្ស",
    scholarships: "សិស្ស",
    university_library: "សិស្ស",
    forms: "សិស្ស",
    university_album: "ជីវិតក្នុងបរិវេណសាលា",
    rector: "ការគ្រប់គ្រង",
    board_of_directors: "ការគ្រប់គ្រង",
    founder: "ការគ្រប់គ្រង",
    univ_heads: "ការគ្រប់គ្រង",
    job_opportunities: "ព្រឹត្តិបត្រ",
    news_view: "ព័ត៌មាន",
    announcement_view: "សេចក្តីប្រកាស",
    university_calendar: "ព្រឹត្តិបត្រ",
    university_gallery: "ព្រឹត្តិបត្រ",
    computer_laboratory: "សិស្ស",
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
    const pathParts = path.split("/");
    return pathParts[pathParts.length - 1] || "home";
  }

  function formatTitle(title) {
    // List of small words that should stay lowercase unless they are at the start or end of the title
    const lowercaseWords = [
      "of",
      "and",
      "the",
      "in",
      "to",
      "with",
      "a",
      "an",
      "for",
      "on",
      "at",
      "by",
      "between",
      "from",
    ];

    // Split the title into words
    const words = title.replace(/-/g, " ").split(" ");

    // Function to determine if a word should be uppercase or lowercase
    return words
      .map((word, index) => {
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
      })
      .join(" ");
  }

  // Helper function to detect proper nouns
  function isProperNoun(word) {
    const properNouns = [
      "State",
      "University",
      "Republic",
      "President",
      "Kingdom",
      "City",
    ]; // Add more proper nouns if needed
    return properNouns.includes(
      word.charAt(0).toUpperCase() + word.slice(1).toLowerCase(),
    );
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
    university_background: "ប្រវត្តិសាកលវិទ្យាល័យ",
    vmgo: "វិស័យទស្សនៈ បេសកកម្ម និងគោលដៅ",
    university_profile: "ព័ត៌មានសង្ខេបសាកលវិទ្យាល័យ",
    university_hymn: "បទភ្លេងសាកលវិទ្យាល័យ",
    news: "ព័ត៌មានថ្មីៗ",
    announcements: "សេចក្តីជូនដំណឹង",
    program_offerings: "កម្មវិធីសិក្សា",
    admission_requirements: "លក្ខខណ្ឌចូលរៀន",
    forms: "បែបបទ",
    university_album: "អាល់ប៊ុមសាកលវិទ្យាល័យ",
    rector: "សាកលវិទ្យាធិការ",
    board_of_directors: "ក្រុមប្រឹក្សាភិបាល",
    univ_heads: "ប្រធាននាយកដ្ឋាន និងប្រធានការិយាល័យ",
    contactus: "ទំនាក់ទំនង និងទីតាំង",
    job_opportunities: "ឱកាសការងារ",
    university_calendar: "ប្រតិទិនសាកលវិទ្យាល័យ",
    university_gallery: "វិចិត្រសាលសាកលវិទ្យាល័យ",
    computer_laboratory: "មន្ទីរពិសោធន៍កុំព្យូទ័រ",
  };

  // Logic for handling 'news_view' page breadcrumbs
  if (pageSlug === "news_view") {
    const newsSlug = new URLSearchParams(window.location.search).get(
      "news_slug",
    );
    const newsTitle = newsSlug ? formatTitle(newsSlug) : "News View";

    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <a href="news" class="breadcrumb-link">ព័ត៌មាន</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${newsTitle}</span>
    `;

    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  }

  // Logic for handling 'announcement_view' page breadcrumbs
  else if (pageSlug === "announcement_view") {
    const announcementSlug = new URLSearchParams(window.location.search).get(
      "announcement_slug",
    );
    const announcementTitle = announcementSlug
      ? formatTitle(announcementSlug)
      : "Announcement View";

    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <a href="announcements" class="breadcrumb-link">ការប្រកាស</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${announcementTitle}</span>
    `;

    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "colleges") {
    const collegeSlug = new URLSearchParams(window.location.search).get(
      "department_slug",
    );
    const collegeTitle = collegeSlug ? formatTitle(collegeSlug) : "Colleges";

    breadcrumbContainer.innerHTML = ` 
    <a href="home" class="breadcrumb-link">ផ្ទះ</a>
    <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">អ្នកសិក្សា</span>
    <i class="ri-arrow-right-s-line separator-icon"></i>
    <span class="breadcrumb-active">${collegeTitle}</span>
  `;

    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "forms") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">សិស្ស</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "university_background") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">អំពី</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "university_profile") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">អំពី</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "contactus") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">អំពី</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "hymn") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">អំពី</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "vmgo") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">អំពី</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "university_hymn") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">អំពី</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "news") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">ព្រឹត្តិបត្រ</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "job_opportunities") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">ព្រឹត្តិបត្រ</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "announcements") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">ព្រឹត្តិបត្រ</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "university_gallery") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">ព្រឹត្តិបត្រ</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "program_offerings") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">អ្នកសិក្សា</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "rector") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">ការគ្រប់គ្រង</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "board_of_directors") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">ការគ្រប់គ្រង</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "founder") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">ការគ្រប់គ្រង</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "university_calendar") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">ព្រឹត្តិបត្រ</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "univ_heads") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">ការគ្រប់គ្រង</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "admission_requirements") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">សិស្ស</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "scholarships") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">សិស្ស</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  } else if (pageSlug === "computer_laboratory") {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">សិស្ស</span>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page)}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  }

  // Default breadcrumb for other pages
  else {
    breadcrumbContainer.innerHTML = ` 
      <a href="home" class="breadcrumb-link">ផ្ទះ</a>
      <i class="ri-arrow-right-s-line separator-icon"></i>
      <span class="breadcrumb-active">${breadcrumbTitles[page] || formatTitle(page) || "Page Not Found"}</span>
    `;
    adjustFontSize(breadcrumbContainer.querySelector(".breadcrumb-active"));
  }
});

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
    const matchedValue = deptMatch
      ? deptMatch[1]
      : newsMatch
        ? newsMatch[1]
        : announcementMatch
          ? announcementMatch[1]
          : null;

    return matchedValue ? decodeURIComponent(matchedValue) : null;
  }

  // Function to get the last part of the URL path (if no PHP parameter exists)
  function getPageFromPath() {
    const path = window.location.pathname;
    const pathParts = path.split("/");
    return pathParts[pathParts.length - 1] || "home";
  }

  // Function to format title by replacing hyphens with spaces and capitalizing each word
  function formatTitle(title) {
    return title
      .replace(/-/g, " ") // Replace hyphens with spaces
      .split(" ") // Split into an array of words
      .map((word) => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()) // Capitalize each word
      .join(" "); // Join back into a string
  }

  // Determine the page from PHP or the path
  const page = getPageFromPHP() || getPageFromPath();

  // Page titles mapping
  const pageTitles = {
    university_background: "ប្រវត្តិសាកលវិទ្យាល័យ",
    vmgo: "វិស័យទស្សនៈ បេសកកម្ម និងគោលដៅ",
    university_profile: "ព័ត៌មានសង្ខេបសាកលវិទ្យាល័យ",
    university_hymn: "បទភ្លេងសាកលវិទ្យាល័យ",
    news: "ព័ត៌មានថ្មីៗ",
    announcements: "សេចក្តីជូនដំណឹង",
    program_offerings: "កម្មវិធីសិក្សា",
    admission_requirements: "លក្ខខណ្ឌចូលរៀន",
    forms: "បែបបទ",
    university_album: "អាល់ប៊ុមសាកលវិទ្យាល័យ",
    rector: "សាកលវិទ្យាធិការ",
    board_of_directors: "ក្រុមប្រឹក្សាភិបាល",
    univ_heads: "ប្រធាននាយកដ្ឋាន និងប្រធានការិយាល័យ",
    contactus: "ទំនាក់ទំនង និងទីតាំង",
    scholarships: "អាហារូបករណ៍",
    computer_laboratory: "មន្ទីរពិសោធន៍កុំព្យូទ័រ",
  };

  // Get the title for the current page or use a default
  const pageTitle =
    pageTitles[page] || formatTitle(page) || "សាកលវិទ្យាល័យក្រចេះ";

  // Set the document title with the page title
  document.title =
    page === "home" ? pageTitle : `${pageTitle} - សាកលវិទ្យាល័យក្រចេះ`;
});
