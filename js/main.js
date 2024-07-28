document.addEventListener('DOMContentLoaded', () => {
  // FAQ Accordion
  const faqContainer = document.querySelector('.faq-content');

  if (faqContainer) {
    faqContainer.addEventListener('click', (e) => {
      const groupHeader = e.target.closest('.faq-group-header');

      if (!groupHeader) return;

      const group = groupHeader.parentElement;
      const groupBody = group.querySelector('.faq-group-body');
      const icon = groupHeader.querySelector('i');

      if (icon) {
        // Toggle the clicked FAQ group
        groupBody.classList.toggle('open');
        icon.classList.toggle('fa-minus');
        icon.classList.toggle('fa-plus');
      }

      // Close other open FAQ bodies
      const otherGroups = faqContainer.querySelectorAll('.faq-group');

      otherGroups.forEach((otherGroup) => {
        if (otherGroup !== group) {
          const otherGroupBody = otherGroup.querySelector('.faq-group-body');
          const otherIcon = otherGroup.querySelector('.faq-group-header i');

          if (otherIcon) {
            otherGroupBody.classList.remove('open');
            otherIcon.classList.remove('fa-minus');
            otherIcon.classList.add('fa-plus');
          }
        }
      });
    });
  }

  // Mobile Menu
  const hamburgerButton = document.querySelector('.hamburger-button');
  const mobileMenu = document.querySelector('.mobile-menu');

  if (hamburgerButton && mobileMenu) {
    hamburgerButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('active');
    });
  }

  // Dark/Light Mode Toggle
  const darkModeToggle = document.querySelector('#dark-mode-toggle');

  if (darkModeToggle) {
    darkModeToggle.addEventListener('click', () => {
      document.body.classList.toggle('dark-mode');
    });
  }
});
