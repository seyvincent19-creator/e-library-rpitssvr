/*=============== Search ===============*/
const searchButton = document.getElementById('search-button'),
      searchClose = document.getElementById('search-close'),
      searchContent = document.getElementById('search-content');
/*========== Search Show ==========*/
/* Validate if constant exists */
if(searchButton){
    searchButton.addEventListener('click',() =>{
        searchContent.classList.add('show-search');
    })
}

/*========== Search Hidden ==========*/
/* Validate if constant exists */
if(searchClose){
    searchClose.addEventListener('click',() =>{
        searchContent.classList.remove('show-search');
    })
}

/*=============== ADD SHADOW HEADER ===============*/
const shadowHeader = () =>{
    const header = document.getElementById('header');
    this.scrollY >= 50 ? header.classList.add('shadow-header')
                      : header.classList.remove('shadow-header')
}
window.addEventListener('scroll',shadowHeader)



/*=============== Home Swiper ===============*/
let swiperHome = new Swiper('.home__swiper', {
  loop: true,
  spaceBetween: 24,
  grabCursor: true,
  slidesPerView: 'auto',
  centeredSlides: true,

  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },

  breakpoints: {
      1220: {
          spaceBetween: 32,
      },
    //   1550: {
    //       spaceBetween: 32,
    //   }
  }

});




/*=============== Featured Swiper ===============*/
let swiperFeatured = new Swiper('.featured__swiper', {
//   loop: true,
  spaceBetween: 16,
  grabCursor: true,
  slidesPerView: 'auto',
  centeredSlides: true,


   navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },


  breakpoints: {

      1150: {
        slidesPerView: 4,
        centeredSlides: false,
      }
  }

});

/*=============== New Swiper ===============*/
let swiperNew = new Swiper('.new__swiper', {
    loop: false,
    spaceBetween: 16,
    slidesPerView: 'auto',

    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    breakpoints: {
        1150: {
            slidesPerView: 3,
        }
    }
  });


  /*=============== Testimonial ===============*/
let swiperTestimonial = new Swiper('.testimonial__swiper', {
    loop: false,
    spaceBetween: 16,
    grabCursor: true,
    slidesPerView: 'auto',
    centeredSlides: true,


    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    breakpoints: {
        1150: {
            slidesPerView: 3,
            centeredSlides: false,

        }
    }
  });


/*=============== Show Scroll Up =============*/
const scrollUp = () =>{
const scrollUp = document.getElementById('scroll-up')
this.scrollY >= 350 ? scrollUp.classList.add('show-scroll')
        : scrollUp.classList.remove('show-scroll')
}
window.addEventListener('scroll', scrollUp)

/*=============== Show Scroll Up =============*/

const sections = document.querySelectorAll('section[id]')
    const scrollActive = () => {
        const scrollDown = window.scrollY

        sections.forEach(current =>{
            const sectionHeight = current.offsetHeight,
            sectionTop = current.offsetTop - 58,
            sectionId = current.getAttribute('id'),
            sectionsClass = document.querySelector('.nav__menu a[href*=' + sectionId + ']')

            if(scrollDown > sectionTop && scrollDown <= sectionTop + sectionHeight) {
                sectionsClass.classList.add('active-link')
            }else{
                sectionsClass.classList.remove('active-link')
            }
        })
    }
window.addEventListener('scroll', scrollActive)


/***============= DARK LIGHT THEME =======*/
const themeButton = document.getElementById('theme-button')
const darkTheme  = 'dark-theme'
const iconTheme = 'ri-sun-line'
// Previously selected topic (if user selected)
const selectedTheme = localStorage.getItem('selected-theme')
const selectedIcon = localStorage.getItem('selected-icon')

// We obtain the current theme that the interface has by validating the dark-theme class
const getCurrentTheme = () => document.body.classList.contains(darkTheme) ? 'dark' : 'light'
const getCurrentIcon = () => themeButton.classList.contains(iconTheme) ? 'ri-moon-line' : 'ri-sun-line'

// We validate if the user previously chose a topic
if (selectedTheme) {
    // If the validation is fulfilled, we ask what the issue was to know if we activated or deactivated the dark
    document.body.classList[selectedTheme === 'dark' ? 'add': 'remove'] (darkTheme)
    themeButton.classList[selectedIcon === 'ri-moon-line' ? 'add' : 'remove'] (iconTheme)
}

// Activate / deactivate the theme manually with The button
themeButton.addEventListener('click', () => {
    // Add or remove the dark / icon theme
    document.body.classList.toggle(darkTheme)
    themeButton.classList.toggle(iconTheme)
    // We save the theme and the current icon that the user chose
    localStorage.setItem('selected-theme', getCurrentTheme())
    localStorage.setItem('selected-icon', getCurrentIcon())
})


/*=============== Scroll Reveal Animation =============*/

const sr = ScrollReveal({
    origin: 'top',
    distance: '60px',
    duration: '2500',
    delay: 400,
    //reset: true,
})

sr.reveal(`.home__data, .featured__container, .new__container, .join__data, .testimonial__container, .footer`)
sr.reveal(`.home__images`, {delay: 600})
sr.reveal(`.services__card`, {interval: 100})
sr.reveal(`.reading__data`, {origin: 'left'})
sr.reveal(`.reading__images`, {origin: 'right'})



/*===== USER POPUP =====*/
const loginButton = document.getElementById('login-button');
const userPopup   = document.getElementById('user-popup');

loginButton.addEventListener('click', (e) => {
    e.stopPropagation();
    userPopup.classList.toggle('show-popup');
});

// Close when clicking outside
document.addEventListener('click', () => {
    userPopup.classList.remove('show-popup');
});

// Prevent popup from closing when clicking inside it
userPopup.addEventListener('click', (e) => {
    e.stopPropagation();
});

// Close on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        userPopup.classList.remove('show-popup');
    }
});
