document.addEventListener('DOMContentLoaded', function () {
    const navbarNav = document.getElementById('navbarNav');
    const navbarLinks = navbarNav.querySelectorAll('.nav-link');

    navbarLinks.forEach(function (link) {
        link.addEventListener('click', function () {
            const bsCollapse = new bootstrap.Collapse(navbarNav, {
                toggle: false
            });
            bsCollapse.hide();
        });
    });
});