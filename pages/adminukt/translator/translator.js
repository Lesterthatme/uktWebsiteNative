// Load selected language from localStorage (if available)
window.addEventListener('load', function () {
    let savedLanguage = localStorage.getItem('selectedLanguage');
    if (!savedLanguage) {
        savedLanguage = 'en';  // Default to English
    }

    const languageSelector = document.getElementById('languageSelector');
    if (languageSelector) {
        languageSelector.value = savedLanguage;
        languageSelector.addEventListener('change', function () {
            const targetLang = this.value;
            localStorage.setItem('selectedLanguage', targetLang);
            translatePage(targetLang);
        });
    }

    translatePage(savedLanguage);  // Initial translation
});

function translatePage(targetLang) {
    const elements = document.querySelectorAll('.translate');
    const texts = [];

    elements.forEach(el => {
        // Store original value if not already stored
        if (!el.dataset.originalText) {
            if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                el.dataset.originalText = el.value.trim();
            } else {
                el.dataset.originalText = el.innerText.trim();
            }
        }

        texts.push(el.dataset.originalText);
    });

    // Restore English (original text)
    if (targetLang === 'en') {
        elements.forEach(el => {
            if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                el.value = el.dataset.originalText;
            } else {
                el.innerText = el.dataset.originalText;
            }
        });
    } else {
        // Send text for translation
        fetch('translate_batch.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ texts, targetLang })
        })
        .then(res => res.json())
        .then(data => {
            data.translations.forEach((translatedText, i) => {
                const el = elements[i];
                if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                    el.value = translatedText;
                } else {
                    el.innerText = translatedText;
                }
            });
        })
        .catch(err => console.error('Translation error:', err));
    }
}