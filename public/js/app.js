var scrollBtn = document.querySelector("#scroll-btn");

if (scrollBtn) {
    scrollBtn.addEventListener("click", () => {
        var parentElement = scrollBtn.parentElement;

        var parentHeight = parentElement.offsetHeight;

        window.scrollTo({
            top: parentHeight,
            behavior: "smooth",
        });
    });
}

var brandSlider = new Swiper(".brandSlider", {
    loop: true,
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
    },
    slidesPerView: 4,
    spaceBetween: 70,
    breakpoints: {
        300: {
            slidesPerView: 2,
            spaceBetweenSlides: 30,
        },
        768: {
            slidesPerView: 4,
            spaceBetweenSlides: 40,
        },
        1024: {
            slidesPerView: 7,
            spaceBetweenSlides: 30,
        },
    },
});

//dropdown while screen is small
const dropdownSelectro = document.getElementById("dropdownService");
if (dropdownSelectro) {
    dropdownSelectro.addEventListener("click", () => {
        document.getElementById("dropdownMenu").classList.toggle("showDrpDown");
        document.getElementById("chevron").classList.toggle("chevronUpDown");
    });
}
