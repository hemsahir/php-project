/*Show/hide What's New & Press Release content */
// $(document).ready(function () {
//   $('.resp-tabs-list li a').click(function (e) {
//     e.preventDefault(); // ✅ Prevent jump to top
//     var tabIndex = $(this).parent().index();

//     $('.resp-tabs-list li').removeClass('resp-tab-active');
//     $(this).parent().addClass('resp-tab-active');

//     $('.resp-tab-content').removeClass('resp-tab-content-active').hide();
//     $('.resp-tab-content').eq(tabIndex).addClass('resp-tab-content-active').show();
//   });
// });
document.querySelectorAll('.resp-tabs-list li a').forEach((link, index) => {
  link.addEventListener('click', function (e) {
    e.preventDefault(); // Stop the default jump scroll

    // Remove existing active classes
    document.querySelectorAll('.resp-tab-item').forEach(el => el.classList.remove('resp-tab-active'));
    document.querySelectorAll('.resp-tab-content').forEach(el => el.classList.remove('resp-tab-content-active'));

    // Add active to current
    this.parentElement.classList.add('resp-tab-active');
    document.getElementById('hor_1_tab_item-' + index).classList.add('resp-tab-content-active');

    // Update URL hash without scrolling
    const targetHash = this.getAttribute('href');
    if (history.replaceState) {
      history.replaceState(null, null, targetHash);
    } else {
      window.location.hash = targetHash;
    }
  });
});



function changeClass() {
    const icon = document.querySelector('.text-slide');
    const list = document.querySelector('.scroll-text .list');
    icon.classList.toggle('play');
    list.classList.toggle('scroll-paused');
}

function changeClass01() {
    const icon = document.querySelector('.text-slide01');
    const list = document.querySelector('.scroll-text01 .list');
    icon.classList.toggle('play');
    list.classList.toggle('scroll-paused');
}

function changeClass1() {
    const icon = document.querySelector('.text-slide1');
    const list = document.querySelector('.scroll-text-1 .list');
    icon.classList.toggle('play');
    list.classList.toggle('scroll-paused');
}
