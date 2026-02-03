document.addEventListener("DOMContentLoaded", function () {
  const carousel = document.querySelector("#partnerCarousel");
  const cardsContainer = carousel.querySelector(".carousel-item.active > div");
  const cards = Array.from(
    cardsContainer.querySelectorAll(".admissionReq-card")
  );
  if (window.innerWidth <= 992) {
    itemsPerSlide = 3; // Show 1 item per slide on smaller screens
} else {
    itemsPerSlide = 2; // Default 2 items per slide
}

  const prevBtn = carousel.querySelector(".carousel-control-prev");
  const nextBtn = carousel.querySelector(".carousel-control-next");

  if (cards.length > itemsPerSlide) {
    const carouselInner = carousel.querySelector(".carousel-inner");
    carouselInner.innerHTML = "";

    let currentSlide = document.createElement("div");
    currentSlide.classList.add("carousel-item", "active");

    let slideContent = document.createElement("div");
    slideContent.className = "d-flex flex-wrap justify-content-center gap-4";
    currentSlide.appendChild(slideContent);
    carouselInner.appendChild(currentSlide);

    cards.forEach((card, index) => {
      if (index !== 0 && index % itemsPerSlide === 0) {
        currentSlide = document.createElement("div");
        currentSlide.classList.add("carousel-item");

        slideContent = document.createElement("div");
        slideContent.className =
          "d-flex flex-wrap justify-content-center gap-4";
        currentSlide.appendChild(slideContent);
        carouselInner.appendChild(currentSlide);
      }
      slideContent.appendChild(card);
    });
  }

  if (cards.length <= itemsPerSlide) {
    prevBtn.style.display = "none";
    nextBtn.style.display = "none";
  } else {
    prevBtn.style.display = "";
    nextBtn.style.display = "";
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const carousel = document.querySelector("#partnerCarousel");
  const carouselInner = carousel.querySelector(".carousel-inner");
  const items = Array.from(
    carouselInner.querySelectorAll(".carousel-item")
  ).filter((item) => !item.classList.contains("d-none"));
  const indicatorsContainer = document.querySelector(".carousel-indicators");

  indicatorsContainer.innerHTML = "";

  items.forEach((item, index) => {
    const indicator = document.createElement("button");
    indicator.type = "button";
    indicator.dataset.bsTarget = "#partnerCarousel";
    indicator.dataset.bsSlideTo = index;
    indicator.classList.add("bg-success");

    if (index === 0) {
      indicator.classList.add("active");
      indicator.setAttribute("aria-current", "true");
    }

    indicator.setAttribute("aria-label", `Slide ${index + 1}`);
    indicatorsContainer.appendChild(indicator);
  });
});
