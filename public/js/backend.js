document.addEventListener("DOMContentLoaded", function() {
    const mobileNav = document.getElementById('mobileNav');
    const closeBtn = document.getElementById('closeBtn');

    // Function to apply the sidebar state
    function applySidebarState() {
        if (localStorage.getItem('sidebarToggle') === 'sidebarHidden') {
            document.body.classList.add('sidebarHidden');
        } else {
            document.body.classList.remove('sidebarHidden');
        }
    }

    // Apply the saved state when the page loads
    applySidebarState();

    mobileNav.addEventListener("click", function() {
        if (localStorage.getItem('sidebarToggle') === 'sidebarHidden') {
            localStorage.removeItem('sidebarToggle');
        } else {
            localStorage.setItem('sidebarToggle', 'sidebarHidden');
        }
        applySidebarState();
    });

    closeBtn.addEventListener('click', function() {
        if (localStorage.getItem('sidebarToggle') === 'sidebarHidden') {
            localStorage.removeItem('sidebarToggle');
        } else {
            localStorage.setItem('sidebarToggle', 'sidebarHidden');
        }
        applySidebarState();
    });
});

document.addEventListener("click", (event) => {
    const viewPortWidth = window.innerWidth;
    if (viewPortWidth < 1024) {
        if (!mobileNav.contains(event.target) && !closeBtn.contains(event.target)) {
            document.body.classList.remove('sidebarHidden');
            localStorage.removeItem('sidebarToggle');
            applySidebarState();
        }
    }
});
