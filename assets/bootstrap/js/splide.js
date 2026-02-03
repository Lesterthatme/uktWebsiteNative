document.addEventListener('DOMContentLoaded', function() {
    var logoCount = document.querySelectorAll('#logo-carousel .splide__slide').length;
    var perPage = Math.min(logoCount, 6);

    new Splide('#logo-carousel', {
      type: 'loop',
      perPage: perPage, 
      perMove: perPage, 
      autoplay: false,
      pauseOnHover: false,
      arrows: false,
      pagination: false,
      drag: true,
      speed: 1000,
      autoScroll: {
        speed: 2,
      },
      breakpoints: {
        768: {
          perPage: Math.min(logoCount, 3),
          perMove: Math.min(logoCount, 3)
        },
        480: {
          perPage: Math.min(logoCount, 2),
          perMove: Math.min(logoCount, 2)
        }
      }
    }).mount(window.splide.Extensions);
  });

  document.addEventListener('DOMContentLoaded', function() {
    new Splide('#poster-carousel', {
      type: 'fade', // Enables fade transition
      perPage: 1,
      perMove: 1,
      autoplay: true, 
      interval: 4000, 
      pauseOnHover: false,
      arrows: true, 
      pagination: true,
      drag: false, 
      speed: 1500, 
      rewind: true 
    }).mount();
  }); 

  AOS.init();