import React, { useEffect, useState} from "react";

export default function () {
    const [videos, setVideos] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const apiRoot = window.location.origin;

    useEffect(() => {
        async function fetchVideos() {
            try{
                const response = await fetch('/api/webtv/');
                if (!response.ok){
                    throw new Error("La réquête a échouée");
                }

                const data = await response.json();
                setVideos(data);
                setIsLoading(false);
            } catch (e) {
                console.error("Erreur de la récupération des vidéos: ", e)
            }
        }

        fetchVideos();
    }, []);

    console.log(videos)

    return (
        <div>
            <section id="replay">
                <div className="replay" data-aos="fade-up" data-aos-duration="1500">
                    <div className="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-2">
                        { videos.map((video, index) => (
                            <div className="col video-picture" key={index}>
                                <a href={`${apiRoot}/webtv/${video.slug}`}>
                                    <img
                                        src={`/assets/images/videos/${video.media}`}
                                        alt={video.titre}
                                        className="img-fluid video-affiche"
                                    />
                                </a>
                                <span className="play-icon"></span>
                            </div>
                        ))}

                    </div>
                </div>
            </section>
        </div>
    )
}