document.querySelectorAll(".caption").forEach((text) => {
  const btn = text.parentElement.querySelector(".see-more-btn");
  if (!btn) return;

  if (text.scrollHeight > text.clientHeight) {
    btn.style.display = "inline-block";
  }

  btn.addEventListener("click", () => {
    text.classList.toggle("expanded");
    btn.textContent = text.classList.contains("expanded")
      ? "See less"
      : "See more";
  });
});
