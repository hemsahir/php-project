  // Default size
  let currentFontSize = 100;

  // Function to apply font size to the body
  function applyFontSize(size) {
    const ids = ['fontSize', 'subpage-font-size', 'complaint-fontSize','press-fontSize','tender-fontSize','whats-new-fontSize'];
    ids.forEach(function(id) {
    const el = document.getElementById(id);
        if (el) {
        el.style.fontSize = size + '%';
        }
    });
  }

  // Decrease Font Size
  document.getElementById('decreaseFont').addEventListener('click', function () {
    if (currentFontSize > 80) {
      currentFontSize -= 10;
      applyFontSize(currentFontSize);
    }
  });

  // Reset Font Size
  document.getElementById('resetFont').addEventListener('click', function () {
    currentFontSize = 100;
    applyFontSize(currentFontSize);
  });

  // Increase Font Size
  document.getElementById('increaseFont').addEventListener('click', function () {
    if (currentFontSize < 150) {
      currentFontSize += 10;
      applyFontSize(currentFontSize);
    }
  });