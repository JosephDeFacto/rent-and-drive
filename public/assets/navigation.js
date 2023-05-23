const toggleResponsiveNavigation = () => {
    let homeHref = document.querySelector('.home');

    let hamburgerBtn = document.querySelector(".hamburger");
    let navId = document.getElementById('navigation');

    hamburgerBtn.addEventListener('click', function () {
        if (navId.className === "topNav") {
            navId.className += " responsive";
        } else {
            navId.className = "topNav";
        }
    });

    if (window.matchMedia('screen and (max-width: 768px)').matches) {
        hamburgerBtn.addEventListener('click', function() {
            if (homeHref.style.position !== 'relative') {
                homeHref.style.position = 'relative';
                homeHref.style.top = '100px';
            } else {
                homeHref.style.position = 'initial';
                homeHref.style.top = '0';
            }
        });
    }
}

toggleResponsiveNavigation();
