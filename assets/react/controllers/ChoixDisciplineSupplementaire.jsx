import React, {useEffect, useState} from 'react';
import Swal from 'sweetalert2';
import withReactContent from 'sweetalert2-react-content';
import AOS from 'aos';
import ReactLoading from 'react-loading';

const MySwal = withReactContent(Swal);

export default function () {
    const [isLoading, setIsLoading] = useState(false);
    const [loading, setLoading] = useState(true);
    const [disciplines, setDisciplines] = useState([]);
    const [selectedDisciplines, setSelectedDisciplines] = useState([]);
    const [totalJoueursChoisis, setTotalJoueursChoisis] = useState(0);
    const nombreMaxJoueurs = 5;


    useEffect(() => {
        AOS.init();

        async function fetchDiscipline(){
            try {
                const response = await fetch('/api/discipline-supplementaire/');
                if (!response.ok){
                    throw new Error("La réquête a échoué");
                }

                const disciplineData = await response.json();
                setDisciplines(disciplineData);
            } catch (e) {
                console.error("Erreur de la récupération des discipline: ", e)
            }
        }

        fetchDiscipline();
    }, []);

    console.log(disciplines)

    const handleDisciplineChange = (e) => {
        const selectedDisciplineId = parseInt(e.target.value, 10);
        // const selectedDiscipline = disciplines.find((d) => d.id === selectedDisciplineId);

        let newSelectedDisciplines = [...selectedDisciplines];

        if (e.target.checked) {
            // Ajouter la discipline sélectionnée
            newSelectedDisciplines.push(selectedDisciplineId);
        } else {
            // Retirer la discipline désélectionnée
            newSelectedDisciplines = newSelectedDisciplines.filter((id) => id !== selectedDisciplineId);
        }

        // Limiter la sélection à quatre disciplines
        if (newSelectedDisciplines.length > 2) {
            MySwal.fire({
                icon: 'warning',
                title: 'Limite atteinte',
                text: 'Vous ne pouvez sélectionner que quatre disciplines.',
            });
            return;
        }

        // Mettre à jour le total des joueurs choisis en fonction des disciplines
        const totalJoueurs = newSelectedDisciplines.reduce((total, disciplineId) => {
            const discipline = disciplines.find((d) => d.id === disciplineId);
            // const discipline = disciplines.find && disciplines.find((d) => d.id === selectedDisciplineId);
            console.log(discipline)

            return total + (discipline ? discipline.joueur : 1);
        }, 0);

        // Empêcher la sélection si le total des joueurs dépasse 30
        if (totalJoueurs > nombreMaxJoueurs) {
            MySwal.fire({
                icon: 'warning',
                title: 'Limite de joueurs atteinte',
                text: `Vous ne pouvez choisir que jusqu'à ${nombreMaxJoueurs} joueurs au total.`,
            });
            return;
        }

        setTotalJoueursChoisis(totalJoueurs);

        setSelectedDisciplines(newSelectedDisciplines);
    };

    const saveAbonnementData = async () => {
        try {
            const response = await fetch('/api/discipline-supplementaire/abonnement', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    disciplines: selectedDisciplines,
                    totalJoueurs: totalJoueursChoisis
                    // Autres données à envoyer si nécessaire
                }),
            });

            if (!response.ok) {
                throw new Error("La requête a échoué");
            }

            const responseData = await response.json();

            if (responseData.statut === 'nonDiscipline'){
                MySwal.fire({
                    icon: 'Echèc',
                    title: 'Disciplines supplémentaires',
                    text: `Veuillez choisir les disciplines supplémentaires!`,
                    timer: 6000
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/discipline-supplementaire';
                    }
                });
                setTimeout(() => {
                    window.location.href = '/discipline-supplementaire/';
                }, 10000);
                //window.location.href = '/membre/';
            }

            if (responseData.statut === 'nonAutorise'){
                MySwal.fire({
                    icon: 'Echèc',
                    title: 'Opération réfusée',
                    text: `Echèc, votre compte ne vous autorise pas à choisir des disciplines!`,
                    timer: 6000
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/discipline-supplementaire/';
                    }
                });
                setTimeout(() => {
                    window.location.href = '/discipline-supplementaire/';
                }, 10000);
                //window.location.href = '/membre/';
            }



            setLoading(false)


            MySwal.fire({
                icon: 'success',
                title: 'Disciplines supplémentaires',
                text: `Disciplines supplémentaires ajoutées avec succès! Veuillez enregistrer maintenant vos participants`,
                timer: 6000
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/discipline-supplementaire/participants';
                }
            });
            setTimeout(() => {
                window.location.href = '/discipline-supplementaire/participants';
            }, 10000);

            // MySwal.fire({
            //     icon: 'success',
            //     title: 'Participation',
            //     text: `Veuillez enregistrer vos participants`,
            //     timer: 9000
            // });
            //
            // setTimeout(() => {
            //     window.location.href = '/discipline-supplementaire/participants';
            // }, 6000);


        } catch (error) {
            console.error('Erreur lors de la sauvegarde des données :', error);
        }
    };


    const handleSubmit = (e) => {
        e.preventDefault();

        saveAbonnementData();
    }

    return (
        <div>
            <section id="inscription">
                <div className="inscription">
                    <div className="row no-gutters justify-content-center align-items-center">
                        <div className="col-xl-10">
                            <div className="formulaire-bloc"  data-aos="fade-up" data-aos-duration="1500">
                                <form onSubmit={handleSubmit}>
                                    <div className="row mb-5 justify-content-center align-content-center">
                                        <div className="col-12 mb-1 text-center">
                                            <h3 className="titre">Choix des disciplines</h3>
                                        </div>
                                        <div className="col-6 text-center">
                                            <h4>Joueurs participants: <span>{totalJoueursChoisis}</span></h4>
                                        </div>
                                        <div className="col-6 text-center">
                                            <h4>Joueurs restants: <span>{nombreMaxJoueurs - totalJoueursChoisis}</span></h4>
                                        </div>
                                    </div>
                                    <div className="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 no-gutters mt-5">
                                        {Object.values(disciplines).map((discipline) => (
                                            <div key={discipline.id} className="col">
                                                <div className="form-check">
                                                    <input
                                                        type="checkbox"
                                                        className="form-check-input"
                                                        id={`discipline-${discipline.id}`}
                                                        value={discipline.id}
                                                        onChange={(e) => handleDisciplineChange(e)}
                                                        checked={selectedDisciplines.includes(discipline.id)}
                                                    />
                                                    <label className="form-check-label" htmlFor={`discipline-${discipline.id}`}>
                                                        {discipline.titre}<span className="bloc">(<span className="valeur">{discipline.joueur ? discipline.joueur : 1}</span>)</span>
                                                    </label>
                                                </div>
                                            </div>
                                        ))}
                                    </div>


                                    <div className="row mt-5 d-flex justify-content-center align-content-center align-items-center">
                                        <div className="col-12 col-md-6 d-grid gap-2">
                                            <input
                                                type="hidden"
                                                name="nombreJoueurs"
                                                value={totalJoueursChoisis}
                                            />
                                            <button
                                                type="submit"
                                                className="btn btn-success btn-lg bouton"
                                            >
                                                Suivant <i className="bi bi-arrow-right-circle-fill"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            {isLoading ? (
                <div className="loading-animation">
                    <ReactLoading type="spin" color="#007BFF" />
                </div>
            ) : null}
        </div>
    );
}