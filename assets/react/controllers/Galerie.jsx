import React, {useEffect} from 'react';

export default function () {
    useEffect(() => {
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
    })

    const images = [];
    for (let i = 1; i <= 17; i++) {
        images.push(<img key={i} src={`/assets/images/photos/${i}.jpg`} alt="" className="photo" loading="lazy" />);
    }

    return (
        <div>
            <section id="media">
                <div className="container">
                    <div className="galerie">{images}</div>
                    <div className="modal" id="modal">
                        <div className="modal-nav">
                            <button id="prevBtn">&lt;</button>
                            <img src="" alt="Image Zoom"/>
                                <button id="nextBtn">&gt;</button>
                        </div>
                        <buton id="closeBtn">&times;</buton>
                    </div>

                </div>
            </section>
        </div>
    )
}