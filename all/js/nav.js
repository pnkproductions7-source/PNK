document.addEventListener("DOMContentLoaded", () => {
  const toggle = document.querySelector(".menu-toggle");
  const menu = document.querySelector(".dropdown-menu");

  if (!toggle || !menu) return;

  toggle.addEventListener("click", () => {
    const isOpen = menu.classList.toggle("active");
    toggle.classList.toggle("open", isOpen);
    toggle.setAttribute("aria-expanded", isOpen);
  });

  document.addEventListener("click", (e) => {
    if (
      !menu.contains(e.target) &&
      !toggle.contains(e.target) &&
      menu.classList.contains("active")
    ) {
      menu.classList.remove("active");
      toggle.classList.remove("open");
      toggle.setAttribute("aria-expanded", "false");
    }
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && menu.classList.contains("active")) {
      menu.classList.remove("active");
      toggle.classList.remove("open");
      toggle.setAttribute("aria-expanded", "false");
    }
  });
});
