document.addEventListener('DOMContentLoaded', (event) => {
    const openFormButton = document.getElementById('openFormButton');

    openFormButton.addEventListener('click', () => {
        const centerFrame = parent.frames['centerFrame'];
        centerFrame.postMessage('openForm', '*');
    });
});

