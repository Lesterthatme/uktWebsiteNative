<!-- Google Translate Element (Hidden) -->
<div id="google_translate_element" style="display: none;"></div>

<script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
      pageLanguage: 'en',
      includedLanguages: 'en,km',
      autoDisplay: false
    }, 'google_translate_element');
  }
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>
  let currentLang = 'en';

  function changeLanguage(lang) {
    const select = document.querySelector(".goog-te-combo");
    if (select) {
      select.value = lang;
      select.dispatchEvent(new Event("change"));
    }

    setTimeout(() => {
      // Hide Google Translate toolbar and banner elements
      const elementsToHide = [
        'iframe.goog-te-banner-frame',
        '.goog-logo-link',
        '.goog-te-gadget',
        '.goog-te-banner-frame',
        '#goog-gt-tt',
        '.goog-te-balloon-frame',
        '.goog-text-highlight'
      ];
      
      elementsToHide.forEach(selector => {
        const el = document.querySelector(selector);
        if (el) el.style.display = 'none';
      });

      // Also try removing any injected "rate this translation" if it still exists
      const feedbackBox = document.querySelector('[id^=":"]'); // Google sometimes uses generated IDs
      if (feedbackBox && feedbackBox.innerText.includes('Rate this translation')) {
        feedbackBox.style.display = 'none';
      }

      document.body.style.top = '0px'; 
    }, 1000);
  }

  document.addEventListener("DOMContentLoaded", () => {
    const translateBtn = document.getElementById("translateBtn");
    if (translateBtn) {
      translateBtn.addEventListener("click", () => {
        currentLang = (currentLang === 'en') ? 'km' : 'en';
        changeLanguage(currentLang);
      });
    }
  });
</script>
