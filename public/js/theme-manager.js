(function() {
    'use strict';

    var themeNames = {
        1: 'الأناقة الذهبية',
        2: 'الفخامة الخضراء',
        3: 'النقاء العصري',
        4: 'وادي سلامة',
        5: 'التقنية المتقدمة'
    };

    function getCurrentTheme() {
        var saved = localStorage.getItem('samah_theme');
        if (saved && parseInt(saved) >= 1 && parseInt(saved) <= 5) {
            return parseInt(saved);
        }
        var html = document.documentElement;
        var dataTheme = html.getAttribute('data-theme');
        if (dataTheme && parseInt(dataTheme) >= 1 && parseInt(dataTheme) <= 5) {
            return parseInt(dataTheme);
        }
        return 1;
    }

    function switchTheme(num) {
        if (num < 1 || num > 5) return;
        
        var current = getCurrentTheme();
        if (current === num) return;

        localStorage.setItem('samah_theme', num);
        document.cookie = 'samah_theme=' + num + ';path=/;max-age=31536000';

        var html = document.documentElement;
        html.setAttribute('data-theme', num);

        var link = document.getElementById('themeStylesheet');
        if (link) {
            link.href = window.basePath + '/css/themes/samah-' + num + '.css?v=' + Date.now();
        }

        showToast(themeNames[num] || 'التصميم ' + num);
    }

    function showToast(name) {
        var toast = document.getElementById('themeToast');
        var text = document.getElementById('themeToastText');
        if (!toast || !text) return;

        text.textContent = 'تم تفعيل: ' + name;
        toast.classList.add('show');

        clearTimeout(window._themeToastTimer);
        window._themeToastTimer = setTimeout(function() {
            toast.classList.remove('show');
        }, 2500);
    }

    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && !e.altKey && !e.shiftKey && !e.metaKey) {
            var key = parseInt(e.key);
            if (key >= 1 && key <= 5) {
                e.preventDefault();
                switchTheme(key);
            }
        }
    });

    window.SamahTheme = {
        switch: switchTheme,
        getCurrent: getCurrentTheme,
        names: themeNames
    };
})();
