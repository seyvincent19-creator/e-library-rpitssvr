// Toggle the visibility of a dropdown menu
const toggleDropdown = (dropdown, menu, isOpen) => {
    dropdown.classList.toggle("open", isOpen);
    menu.style.height = isOpen ? `${menu.scrollHeight}px` : 0;
  };

  // Remove 'active' from all dropdown-link elements
  const clearActiveDropdownLinks = () => {
    document.querySelectorAll(".drop-link.active").forEach(link => {
      link.classList.remove("active");
    });
  };

  // Close all open dropdowns
  const closeAllDropdowns = () => {
    document.querySelectorAll(".drop-container.open").forEach(openDropdown => {
      toggleDropdown(openDropdown, openDropdown.querySelector(".drop-menu"), false);
    });
  };

  // Attach click event to all dropdown toggles
  document.querySelectorAll(".drop-list").forEach(dropdownToggle => {
    dropdownToggle.addEventListener("click", e => {
    //   e.preventDefault();

      const dropdown = e.target.closest(".drop-container");
      const menu = dropdown.querySelector(".drop-menu");
      const isOpen = dropdown.classList.contains("open");

      closeAllDropdowns(); // Close other dropdowns
      clearActiveDropdownLinks(); //  Clear all active links

      toggleDropdown(dropdown, menu, !isOpen); // Toggle current dropdown
    });
  });


  //  Optional: Activate a dropdown-link on click
  document.querySelectorAll(".drop-link").forEach(link => {
    link.addEventListener("click", e => {
    //   e.preventDefault();

      // Remove 'active' from all links
      document.querySelectorAll(".drop-link.active").forEach(l => {
        l.classList.remove("active");
      });

      // Add 'active' to clicked link
      e.currentTarget.classList.add("active");
    });
  });




  function switchSection(sectionId, el) {
    // Show selected section
    document.querySelectorAll('.content-section').forEach(section => {
      section.classList.remove('active');
    });
    document.getElementById(sectionId).classList.add('active');

    // Highlight active menu
    document.querySelectorAll('.sidebar-link').forEach(link => {
      link.classList.remove('active');
    });
    el.classList.add('active');


}












// Attach Click event to sidebar to sidebar toggle buttons
document.querySelectorAll(".sidebar-toggler, .sidebar-menu-button").forEach(button => {
    button.addEventListener("click", () => {
        closeAllDropdowns();
        // Toggler Collapsed Class on sidebar
        document.querySelector(".sidebar").classList.toggle("collapsed");
    })
});


// ==================================================== Click Image Profile Show Dropdown

const profile = document.querySelector('.dashboard .profile');
const imgProfile = profile.querySelector('img');
const dropdownProfile = profile.querySelector('.profile-link');
imgProfile.addEventListener('click', function () {
    dropdownProfile.classList.toggle('show');
});

// ==================================================== Click Another Tag on Website Remove Class Show in Class profile-link
window.addEventListener('click', function (e) {
    if(e.target !== imgProfile) {
        if(e.target !== dropdownProfile){
            if(dropdownProfile.classList.contains('show')){
                dropdownProfile.classList.remove('show');
            }
        }
    }
});

window.addEventListener('scroll', function () {
  dropdownProfile.classList.remove('show');
});




// ==================================================== Click light & dark Mode

const body = document.querySelector("body"),
        modeToggle = body.querySelector(".mode-toggle"),
        savedTheme = localStorage.getItem('theme');



    if (savedTheme) {
    body.className = savedTheme;
    modeToggle.textContent = savedTheme === 'dark' ? 'dark_mode' : 'light_mode';

    } else {
    body.classList.add('light');
    modeToggle.textContent = 'light_mode';

    }

















// Toggle theme and icon
modeToggle.addEventListener('click', () => {
  if (body.classList.contains('light')) {
    body.classList.replace('light', 'dark');
    modeToggle.textContent = 'dark_mode';
    localStorage.setItem('theme', 'dark');




  } else {
    body.classList.replace('dark', 'light');
    modeToggle.textContent = 'light_mode';
    localStorage.setItem('theme', 'light');




  }
});








// ==================================================== Progress Data

const allProgress = document.querySelectorAll('main .card-dashboard .progress');
allProgress.forEach(item=> {
  item.style.setProperty('--value', item.dataset.value);
});








// Collapse sidebar by default on small screens
if(window.innerWidth <= 1024) document.querySelector(".sidebar").classList.toggle("collapsed");



