window.addEventListener('scroll', function() {
    var block1 = document.getElementById('block1');
    var block2 = document.getElementById('block2');

    var scrollPosition = window.scrollY || window.pageYOffset;

    if (scrollPosition >= window.innerHeight) {
        block1.classList.add('hidden');
        block1.classList.remove('visible');
        block2.classList.add('visible');
        block2.classList.remove('hidden');
    } else {
        block1.classList.add('visible');
        block1.classList.remove('hidden');
        block2.classList.add('hidden');
        block2.classList.remove('visible');
    }
});
