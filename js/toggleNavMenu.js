const navToggle = document.getElementById('nav-toggle');
const mobileMenu = document.getElementById('mobile-menu');
const body = document.body; // Added this line

/* Close mobile menu when a link is clicked - 
wouldn't need this if the links directed somewhere, just added this so it will close after clicking */
const mobileMenuLinks = document.querySelectorAll('#mobile-menu a');
mobileMenuLinks.forEach(link => {
    link.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
        body.classList.remove('no-scroll'); // Added this line
    });
});

/* Toggle mobile menu */
navToggle.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');

    // If the mobile menu is visible, add the no-scroll class to the body
    if (!mobileMenu.classList.contains('hidden')) {
        body.classList.add('no-scroll');
    }
    // If the mobile menu is not visible, remove the no-scroll class from the body
    else {
        body.classList.remove('no-scroll');
    }
});
