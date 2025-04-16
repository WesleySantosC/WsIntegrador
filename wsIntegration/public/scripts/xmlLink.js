    window.addEventListener('DOMContentLoaded', () => {
        const xmlLink = document.querySelector('.xml-link');
        if (xmlLink) {
            xmlLink.style.opacity = '0';
            xmlLink.style.transition = 'opacity 0.6s ease-in-out';
            setTimeout(() => {
                xmlLink.style.opacity = '1';
            }, 200);
        }
    });
