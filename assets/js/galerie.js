const images = document.querySelectorAll('.photo');
const modal = document.getElementById('modal');
const modalImg = modal.querySelector('img');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const closeBtn = document.getElementById('closeBtn');
let currentIndex = 0;

function openModal(index) {
    modal.style.display = 'flex';
    modalImg.src = images[index].src;
    currentIndex = index;
}

images.forEach((image, index) => {
    image.addEventListener('click', () => {
        openModal(index);
        
    });
});

prevBtn.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    modalImg.src = images[currentIndex].src;
});

nextBtn.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % images.length;
    modalImg.src = images[currentIndex].src;
});

modal.addEventListener('click', (e) => {
    if (e.target.id === 'modal') {
        modal.style.display = 'none';
    }
})

closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});