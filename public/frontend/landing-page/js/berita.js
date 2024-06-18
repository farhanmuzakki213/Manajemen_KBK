document.addEventListener('DOMContentLoaded', function () {
    const loadMoreButton = document.getElementById('loadMore');
    const loadLessButton = document.getElementById('loadLess');
    let currentDisplayCount = 3;

    loadMoreButton.addEventListener('click', function () {
        const hiddenCards = document.querySelectorAll('.col-berita.hidden');
        let count = 0;
        for (let i = 0; i < 3; i++) {
            if (hiddenCards[i]) {
                setTimeout(function () {
                    hiddenCards[i].classList.remove('hidden');
                }, count * 100); // Delay sebelum setiap berita ditampilkan
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
                allCards[i].classList.add('hidden');
            }
        }
        currentDisplayCount = 3;
        loadMoreButton.style.display = 'inline-block';
        loadLessButton.style.display = 'none';
    });
});
