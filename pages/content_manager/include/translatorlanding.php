<!-- Google Translate Element (Hidden) -->
<div id="google_translate_element" style="display: none;"></div>

<script>
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
      pageLanguage: 'km', // Default = Khmer
      includedLanguages: 'en,km',
      autoDisplay: false
    }, 'google_translate_element');
  }
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>
  let currentLang = 'km'; // default Khmer

  document.getElementById("translateBtn2").addEventListener("click", function() {
    const select = document.querySelector(".goog-te-combo");
    const flag = document.getElementById("flagIcon");

    if (!select) return;

    if (currentLang === 'km') {
      // Switch to English
      select.value = 'en';
      currentLang = 'en';

      // Change to USA flag
      flag.src = "/ukt/assets/uploads/logo/usaFlag.png";
      this.title = "Switch to Khmer";

    } else {
      // Switch back to Khmer
      select.value = 'km';
      currentLang = 'km';

      // Change to Cambodia flag
      flag.src = "/ukt/assets/uploads/logo/flagCambodia.png";
      this.title = "Switch to English";
    }

    select.dispatchEvent(new Event("change"));

    // Clean Google UI
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
  });
</script>