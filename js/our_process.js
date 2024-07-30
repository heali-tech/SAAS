// JavaScript for "Our Process" Page

// Example of a simple toggle effect for FAQ sections or other interactive elements
document.addEventListener('DOMContentLoaded', () => {
    const faqHeaders = document.querySelectorAll('.faq-group-header');

    faqHeaders.forEach(header => {
        header.addEventListener('click', () => {
            const body = header.nextElementSibling;
            body.classList.toggle('open');
        });
    });
});
