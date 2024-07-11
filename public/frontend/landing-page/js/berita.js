document.addEventListener('DOMContentLoaded', function () {
    const loadMoreButton = document.getElementById('loadMore');
    const loadLessButton = document.getElementById('loadLess');
    let currentDisplayCount = 3;

    // Menyembunyikan semua elemen kecuali 3 elemen pertama saat halaman dimuat
    function hideInitialCards() {
        const allCards = document.querySelectorAll('.col-berita');
        for (let i = currentDisplayCount; i < allCards.length; i++) {
            allCards[i].classList.add('hidden');
            allCards[i].style.maxHeight = '0';
            allCards[i].style.opacity = '0';
            allCards[i].style.display = 'none';
        }
    }

    hideInitialCards(); // Panggil fungsi saat halaman dimuat pertama kali

    function smoothShow(element) {
        element.style.display = 'block';
        setTimeout(() => {
            element.style.maxHeight = element.scrollHeight + 'px';
            element.style.opacity = '1';
        }, 20);
    }

    function smoothHide(element) {
        element.style.maxHeight = '0';
        element.style.opacity = '0';
        setTimeout(() => {
            element.style.display = 'none';
        }, 700);
    }

    loadMoreButton.addEventListener('click', function () {
        const hiddenCards = document.querySelectorAll('.col-berita.hidden');
        let count = 0;
        for (let i = 0; i < 3; i++) {
            if (hiddenCards[i]) {
                setTimeout(() => {
                    hiddenCards[i].classList.remove('hidden');
                    smoothShow(hiddenCards[i]);
                }, count * 100);
                count++;
            }
        }
        currentDisplayCount += 3;
        if (document.querySelectorAll('.col-berita.hidden').length === 0) {
            loadMoreButton.style.display = 'none';
        }
        loadLessButton.style.display = 'inline-block';
    });

    loadLessButton.addEventListener('click', function () {
        const allCards = document.querySelectorAll('.col-berita');
        for (let i = currentDisplayCount - 1; i >= 3; i--) {
            if (allCards[i]) {
                smoothHide(allCards[i]);
                setTimeout(() => {
                    allCards[i].classList.add('hidden');
                }, 600);
            }
        }
        currentDisplayCount = 3;
        loadMoreButton.style.display = 'inline-block';
        loadLessButton.style.display = 'none';
    });
});
