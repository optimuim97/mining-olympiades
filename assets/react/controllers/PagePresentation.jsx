import React, {useEffect, useState} from 'react';
import AOS from 'aos';

export default function () {
    const [presentation, setPresentation] = useState({});

    useEffect(() => {
        AOS.init({
            duration: 2000
        });

        async function fetchData(){
            try {
                const response = await fetch('/api/presentation/');
                if(!response.ok){
                    throw new Error("Response non valide depuis le serveur!");
                }

                const data = await response.json();

                setPresentation(data);
            } catch (e) {
                console.error("Erreur de la récupération de la présentation: ", e)
            }
        }

        fetchData();
    }, []);

    const mediaUrl = presentation.media2 ? `/assets/images/${presentation.media2}` : '';

    return (
        <div>
            <section id="page">
                <div className="page">
                    <div className="row d-flex justify-content-center align-items-center g-4">
                        <div className="col-lg-7 content" data-aos="fade-left" data-aos-duration="1500">
                            <h1>{presentation.titre} <span>8è édition</span></h1>
                            <div

                                dangerouslySetInnerHTML={{ __html: presentation.contenu}}
                            ></div>
                        </div>
                        <div className="col-lg-5 illustration" data-aos="zoom-in" data-aos-duration="1500">
                            {/*<img src="/assets/images/sportifs.png" alt="" className="img-fluid"/>*/}
                            {mediaUrl && <img src={mediaUrl} alt="Mining Olympiades 2024" className="img-fluid"/>}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    )
}