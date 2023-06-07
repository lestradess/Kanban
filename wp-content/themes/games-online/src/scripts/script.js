function gamesOnline_toggleHamburger() {
  const hamburger = document.getElementById("hamburger-button");
  const hiddenMenu = document.getElementById("hidden-menu");

  const hiddenMenuUL = document.getElementById("hidden-main-menu");

  const hiddenMenu_Elements = hiddenMenuUL.children;

  if (hiddenMenu.classList.contains("hidden")) {
    hiddenMenu.classList.replace("hidden", "block");

    hamburger.setAttribute("aria-expanded", "false");
  } else {
    hiddenMenu.classList.replace("block", "hidden");
    hamburger.setAttribute("aria-expanded", "true");
  }
}
