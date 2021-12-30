const $$cookieDisclaimer = document.querySelector(".js-cookie-disclaimer");

if (!localStorage.getItem("cookieDisclaimer")) {
  $$cookieDisclaimer.classList.add("is-active");
}

$$cookieDisclaimer.querySelector("button").addEventListener("click", () => {
  localStorage.setItem("cookieDisclaimer", true);
  $$cookieDisclaimer.classList.remove("is-active");
});
