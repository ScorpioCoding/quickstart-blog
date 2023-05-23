/*
 * NAVIGATION IN - OUT
 */
let navbarLinks = document.getElementsByClassName("navbar-links")[0];
document.getElementsByClassName("toggle-button")[0].onclick = function () {
  if (navbarLinks.style.display == "none" || navbarLinks.style.display == "") {
    navbarLinks.style.display = "flex";
  } else {
    navbarLinks.style.display = "none";
  }
};
