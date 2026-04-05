<!-- Google Translate Element (Hidden) -->
<div id="google_translate_element" style="display: none;"></div>

<!-- Language Buttons -->
<button onclick="changeLanguage('km')">ខ្មែរ</button>
<button onclick="changeLanguage('en')">English</button>

<script>
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
      pageLanguage: 'km', // ✅ Your website is Khmer
      includedLanguages: 'en,km',
      autoDisplay: false
    }, 'google_translate_element');
  }

  function changeLanguage(lang) {
    const select = document.querySelector(".goog-te-combo");

    if (select) {
      select.value = lang;
      select.dispatchEvent(new Event("change"));
    }

    // Remove Google UI elements after translation
    setTimeout(() => {
      const elementsToHide = [
        'iframe.goog-te-banner-frame',
        '.goog-logo-link',
        '.goog-te-gadget',
        '#goog-gt-tt',
        '.goog-te-balloon-frame',
        '.goog-text-highlight'
      ];

      elementsToHide.forEach(selector => {
        const el = document.querySelector(selector);
        if (el) el.style.display = 'none';
      });

      document.body.style.top = '0px';
    }, 500);
  }
</script>

<!-- Google Translate Script -->
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<!-- Optional: Extra CSS to fully hide toolbar spacing -->
<style>
  body {
    top: 0px !important;
  }

  iframe.goog-te-banner-frame {
    display: none !important;
  }
</style>