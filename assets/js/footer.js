$(window).on('load', function () {
  $('#flexCarousel').flexslider({
    animation: "slide",
    animationLoop: true,
    itemWidth: 200,
    itemMargin: 5,
    slideshow: true,
    pausePlay: true,
    controlsContainer: ".carousel-container",
    directionNav: true,
    controlNav: false,
    pauseText: "", // no text
    playText: "",  // no text
    start: function (slider) {
      // Remove duplicate pause/play buttons
      $(".flex-pauseplay:gt(0)").remove();

      // Add icons
      $('.flex-pauseplay a.flex-play').html('<i class="fas fa-play"></i>');
      $('.flex-pauseplay a.flex-pause').html('<i class="fas fa-pause"></i>');
    },
    after: function () {
      $('.flex-pauseplay a.flex-play').html('<i class="fas fa-play"></i>');
      $('.flex-pauseplay a.flex-pause').html('<i class="fas fa-pause"></i>');
    }
  });

  // Show/hide arrows on hover
  $('#flexCarousel').hover(
    function () {
      $(this).find('.flex-direction-nav a').fadeIn();
    },
    function () {
      $(this).find('.flex-direction-nav a').fadeOut();
    }
  );

  // Initially hide arrows
  $('.flex-direction-nav a').hide();
});


document.addEventListener("DOMContentLoaded", function () {
    const scrollButton = document.getElementById("scroll");

    window.addEventListener("scroll", function () {
        if (window.scrollY > 100) {
            scrollButton.style.display = "block";
        } else {
            scrollButton.style.display = "none";
        }
    });

    scrollButton.addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });

        setTimeout(() => {
            scrollButton.style.display = "none";
        }, 600); // matches scroll time
    });
});
