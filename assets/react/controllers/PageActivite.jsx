import React, {useEffect, useState} from "react";
import AOS from 'aos';

export default function () {
    const [activites, setActivites] = useState([]);
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {

        AOS.init({
            duration: 2000
        });

        async function fetchActivites() {
            try {
                const response = await fetch('/api/activite/');
                if (!response.ok){
                    throw new Error("La réquête a échoué");
                }
                const data = await response.json();
                setActivites(data);
                setIsLoading(false);
            }catch (e) {
                console.error("Erreur de la récupération des activités:", e);
                setIsLoading(false);
            }
        }

        fetchActivites();

    }, []);

    return (
        <div>
            {isLoading ?(
                <div className="loading-message">Chargement en cours  <span>.<span>.</span><span>.</span></span></div>
            ):(
                <section id="page">
                    <div className="page">
                        {activites.map((activite, index)  => (
                            <div
                                className={`row d-flex justify-content-center align-items-center activite g-5 ${
                                    index % 2 === 0 ? "even" : "odd"
                                }`}
                                key={index}
                                data-aos="fade-left"
                                data-aos-duration="1500"
                            >
                                {index % 2 === 0 ? (
                                    <>
                                        <div className="col-lg-6 content">
                                            <h1 dangerouslySetInnerHTML={{ __html: activite.titre}}></h1>
                                            <h3></h3>
                                            <p dangerouslySetInnerHTML={{ __html: activite.resume}}></p>
                                        </div>
                                        <div className="col-lg-6 image" data-aos="fade-left" data-aos-duration="1500">
                                            <div className="bg-img">
                                                <img src={`/assets/images/programme/${activite.media}`} alt={activite.titre} className="img-fluid" loading="lazy" />
                                            </div>
                                        </div>
                                    </>
                                ) : (
                                    <>
                                        <div className="col-lg-6 image" data-aos="fade-right" data-aos-duration="1500">
                                            <div className="bg-img">
                                                <img src={`/assets/images/programme/${activite.media}`} alt={activite.titre} className="img-fluid" loading="lazy" />
                                            </div>
                                        </div>
                                        <div className="col-lg-6 content">
                                            <h1 dangerouslySetInnerHTML={{ __html: activite.titre}}/>
                                            {/*<h3>Le {activite.date} à {activite.lieu} de {activite.hHÔTEL PRESIDENTeure}</h3>*/}
                                            <h3></h3>
                                            <p dangerouslySetInnerHTML={{ __html: activite.resume}}></p>
                                        </div>
                                    </>
                                )}
                            </div>
                        ))}

                    </div>
                </section>
            )}

        </div>
    )
}