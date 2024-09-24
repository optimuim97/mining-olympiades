import React, {useEffect, useState} from "react";
import AOS from 'aos';
import WebTVReplay from "./WebTVReplay";


export default function (props) {
    const [isLoading, setIsLoading] = useState(true);
    const [video, setVideo] = useState({})

    useEffect(() => {
        AOS.init();

        async function fetchVideo(){
            try {
                let slug = 'lancement-2024';
                const response = await fetch(`/api/webtv/${props.slug}`);
                if (!response.ok){
                    throw new Error("La réquête a échouée");
                }

                const data = await response.json();
                setVideo(data);
                setIsLoading(false);
            } catch (e) {
                console.error("Erreur de la récupération de la vidéo: ", e);
                setIsLoading(false);
            }
        }

        fetchVideo();

    }, []);

    return(
        <div>
            { isLoading ? (
                <div className="loading-message">Chargement en cours  <span>.<span>.</span><span>.</span></span></div>
            ):(
                <div>
                    <header>
                        <div className="zoneHeadWebtv">
                            <section id="headWebtv">
                                <div className="row headWebtv">
                                    <div className="col-9">
                                        {props.slug ? (
                                            <h2>{video.titre }</h2>
                                        ): (
                                            <h2>Liste des vidéos</h2>
                                        )}

                                    </div>
                                    <div className="col-3 text-center">
                                        <a href="/" className="bouton"><i className="bi bi-reply"/> Retour</a>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </header>
                    <main>
                        <div className="zoneWebtv">
                            { props.slug ? (
                                <section id="webtv">
                                    <div className="webtv" data-aos="zoom-in" data-aos-duration="1500">
                                        <div className="video-container">
                                            <iframe
                                                src={video.url}
                                                title={video.titre}
                                                frameBorder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowFullScreen
                                            />
                                        </div>
                                    </div>
                                </section>
                            ):(
                                <div></div>
                            )}


                            <WebTVReplay/>
                        </div>
                    </main>
                </div>
            )}

        </div>
    )
}