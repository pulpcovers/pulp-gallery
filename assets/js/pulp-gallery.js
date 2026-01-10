document.addEventListener('DOMContentLoaded', function () {
    var galleries = document.querySelectorAll('[data-pulp-gallery]');
    if (!galleries.length) return;

    var activeGallery = null;
    var visibilityMap = new Map();

    // Helper: enable long-press caption + disable OS long-press menu
    function enableLongPressCaption(mainLink, caption) {
        if (!('ontouchstart' in window) || !mainLink) return;

        mainLink.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });

        var pressTimer = null;
        var startX = 0;
        var startY = 0;
        var SLACK = 12;

        mainLink.addEventListener('touchstart', function (e) {
            var t = e.touches[0];
            startX = t.clientX;
            startY = t.clientY;

            pressTimer = setTimeout(function () {
                caption.classList.add('show');
            }, 500);
        });

        mainLink.addEventListener('touchmove', function (e) {
            var t = e.touches[0];
            var dx = Math.abs(t.clientX - startX);
            var dy = Math.abs(t.clientY - startY);

            if (dx > SLACK || dy > SLACK) {
                clearTimeout(pressTimer);
            }
        });

        mainLink.addEventListener('touchend', function () {
            clearTimeout(pressTimer);
        });
    }

    // IntersectionObserver to detect which gallery is most visible
    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            visibilityMap.set(entry.target, entry.intersectionRatio);
        });

        // Pick the gallery with the highest visibility
        var best = null;
        var bestRatio = 0;

        visibilityMap.forEach(function (ratio, galleryEl) {
            if (ratio > bestRatio) {
                bestRatio = ratio;
                best = galleryEl;
            }
        });

        if (best) {
            activeGallery = best;
        }
    }, {
        root: null,
        threshold: buildThresholdList()
    });

    // Build a smooth threshold list for accurate visibility tracking
    function buildThresholdList() {
        var thresholds = [];
        for (var i = 0; i <= 1.0; i += 0.01) {
            thresholds.push(i);
        }
        return thresholds;
    }

    // Setup each gallery
    galleries.forEach(function (gallery) {
        observer.observe(gallery);

        var main = gallery.querySelector('[data-pulp-main]');
        var mainLink = gallery.querySelector('[data-pulp-main-link]');
        var spinner = gallery.querySelector('.pulp-gallery-spinner');
        var thumbs = gallery.querySelectorAll('.pulp-thumb');
        var caption = gallery.querySelector('[data-pulp-caption]');

        // Enable long-press caption for both single and multi-image galleries
        enableLongPressCaption(mainLink || main, caption);

        var currentIndex = 0;

        // Initialize caption text
        caption.textContent = main.alt || '';

        // Fade-in reset on load
        main.addEventListener('load', function () {
            main.classList.add('pulp-fade-in');
            spinner.hidden = true;
        });

        // Switch image helper
        function switchTo(index) {
            if (index < 0 || index >= thumbs.length) return;

            var thumb = thumbs[index];
            var src = thumb.getAttribute('data-pulp-src');
            var alt = thumb.getAttribute('data-pulp-alt');
            var full = thumb.getAttribute('data-pulp-full');

            spinner.hidden = false;
            main.classList.remove('pulp-fade-in');

            main.src = src;
            if (alt) main.alt = alt;
            if (full && mainLink) mainLink.href = full;

            // Update caption text
            caption.textContent = alt || '';
            caption.classList.remove('show');

            thumbs.forEach(function (t) { t.classList.remove('is-active'); });
            thumb.classList.add('is-active');

            currentIndex = index;
        }

        // Thumbnail click handler
        thumbs.forEach(function (thumb, index) {
            thumb.addEventListener('click', function () {
                switchTo(index);
                activeGallery = gallery; // clicking still sets focus
            });
        });

        // Swipe navigation
        let touchStartX = 0;
        let touchStartY = 0;
        let currentX = 0;
        let dragging = false;

        main.style.transition = 'transform 0.25s ease'; // smooth snap-back

        main.addEventListener('touchstart', function (e) {
            caption.classList.remove('show');
            const t = e.changedTouches[0];
            touchStartX = t.screenX;
            touchStartY = t.screenY;
            dragging = true;

            // Cancel any previous transform
            main.style.transition = 'none';
            main.style.transform = 'translateX(0)';
        }, { passive: true });

        main.addEventListener('touchmove', function (e) {
            if (!dragging) return;

            const t = e.changedTouches[0];
            const dx = t.screenX - touchStartX;
            const dy = t.screenY - touchStartY;

            // Ignore vertical scroll
            if (Math.abs(dy) > Math.abs(dx)) return;

            // Bounce resistance at edges
            let resistance = 0.25;
            if ((currentIndex === 0 && dx > 0) ||
                (currentIndex === thumbs.length - 1 && dx < 0)) {
                resistance = 0.15;
            }

            currentX = dx * resistance;
            main.style.transform = `translateX(${currentX}px)`;
        }, { passive: true });

        main.addEventListener('touchend', function (e) {
            dragging = false;

            const t = e.changedTouches[0];
            const dx = t.screenX - touchStartX;
            const dy = t.screenY - touchStartY;

            // Snap back
            main.style.transition = 'transform 0.25s ease';
            main.style.transform = 'translateX(0)';

            // Ignore vertical swipes
            if (Math.abs(dy) > Math.abs(dx)) return;

            // Threshold for navigation
            if (Math.abs(dx) < 40) return;

            // Bounce at edges
            if (currentIndex === 0 && dx > 0) {
                main.style.transform = 'translateX(20px)';
                setTimeout(() => main.style.transform = 'translateX(0)', 150);
                return;
            }

            if (currentIndex === thumbs.length - 1 && dx < 0) {
                main.style.transform = 'translateX(-20px)';
                setTimeout(() => main.style.transform = 'translateX(0)', 150);
                return;
            }

            // Normal swipe navigation
            if (dx < 0) {
                switchTo(currentIndex + 1);
            } else {
                switchTo(currentIndex - 1);
            }
        }, { passive: true });

        main.addEventListener('touchcancel', function () {
            dragging = false;

            // Snap back
            main.style.transition = 'transform 0.25s ease';
            main.style.transform = 'translateX(0)';
        }, { passive: true });

        // Keyboard navigation
        document.addEventListener('keydown', function (e) {
            if (activeGallery !== gallery) return;

            switch (e.key) {
                case 'ArrowLeft':
                    switchTo(currentIndex - 1);
                    break;

                case 'ArrowRight':
                    switchTo(currentIndex + 1);
                    break;
            }
        });
    });

    // Force initial visibility evaluation so the correct gallery is active on load
    observer.takeRecords();
});
