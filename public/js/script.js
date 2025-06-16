// Main DOMContentLoaded logic
document.addEventListener("DOMContentLoaded", function () {
  const menu = document.querySelector(".mobile-menu");
  const menuBtn = document.querySelector(".mobile-menu-btn");

  if (menuBtn) {
    menuBtn.addEventListener("click", function (event) {
      event.stopPropagation();
      menu.classList.add("mobile-menu-active");
    });
  }

  if (menu) {
    menu.addEventListener("click", function (event) {
      event.stopPropagation();
    });
  }

  document.addEventListener("click", function () {
    if (menu) menu.classList.remove("mobile-menu-active");
  });
});


const adminMenuBtn = document.querySelector("#adminMenuOpenBtn");
const adminMenu = document.querySelector(".admin-sidebar");
adminMenuBtn?.addEventListener("click", function (event) {
  event.stopPropagation();
  adminMenu.classList.add("admin-sidebar-active");
});
document.addEventListener("click", function () {
  if (adminMenu) adminMenu.classList.remove("admin-sidebar-active");
});
// Admin sidebar toggle
if (adminMenu) {
  adminMenu.addEventListener("click", function (event) {
    event.stopPropagation();
  });
}
// Admin sidebar close button