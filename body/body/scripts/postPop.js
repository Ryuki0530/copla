document.addEventListener('DOMContentLoaded', (event) => {
    const popupForm = document.getElementById('popupForm');
    const closeFormButton = document.getElementById('closeFormButton');

    window.addEventListener('message', (event) => {
        if (event.data === 'openForm') {
            popupForm.style.display = 'block';
        }
    });

    closeFormButton.addEventListener('click', () => {
        popupForm.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === popupForm) {
            popupForm.style.display = 'none';
        }
    });
});
