import React, {useEffect, useState} from 'react';
import Swal from 'sweetalert2';
import withReactContent from 'sweetalert2-react-content';
import AOS from 'aos';
import ReactLoading from 'react-loading';
import ListeParticipant from "./ListeParticipant";
import Facture from "./Facture";
import FactureInachevee from "./FactureInachevee";

const MySwal = withReactContent(Swal);

export default function () {
    const [isLoading, setIsLoading] = useState(false);
    const [disciplines, setDisciplines] = useState([]);
    const [selectedDiscipline, setSelectedDiscipline] = useState('');
    const [nom, setNom] = useState('');
    const [prenom, setPrenom] = useState('');
    const [abonnement, setAbonnement] = useState([]);
    const [contact, setContact] = useState('');
    const [matricule, setMatricule] = useState('');
    const [email, setEmail] = useState('');

    useEffect(() => {
        AOS.init();

        async function fetchAbonnement(){
            try {
                const response = await fetch('/api/abonnement/');
                if (!response.ok){
                    throw new Error("La réquête a échoué")
                }

                const data = await response.json();
                setAbonnement(data);
            } catch (e) {
                console.error("Erreur de la récupération de l'abonnement: ", e);
            }
        }

        const handleContactChange = (e) => {
            const cleanedValue = e.target.value.replace(/\D/g, '');
            const formattedValue = cleanedValue.slice(0, 10);
            setContact(formattedValue);
        }

        async function fetchDiscipline(){
            try {
                const response = await fetch('/api/discipline/participation');
                if (!response.ok){
                    throw new Error("La réquête a échoué");
                }

                const disciplineData = await response.json();
                setDisciplines(disciplineData);
                console.log(disciplineData)
            } catch (e) {
                console.error("Erreur de la récupération des discipline: ", e)
            }
        }
        fetchDiscipline();
        fetchAbonnement();
    }, []);


    const handleNomChange = (e) => {
        setNom(e.target.value.toUpperCase());
    }

    const handlePrenomChange = (e) => {
        setPrenom(e.target.value.toUpperCase());
    }

    const handleContactChange = (e) => {
        const cleanedValue = e.target.value.replace(/\D/g, '');
        const formattedValue = cleanedValue.slice(0, 10);
        setContact(formattedValue);
    }

    // Fonction pour gérer la soumission du formulaire
    const handleSubmit = async (e) => {
        e.preventDefault();

        try {
            setIsLoading(true);

            const formData = new FormData(e.target);
            const response = await fetch('/api/discipline/participation/membre', {
                method: 'POST',
                body: formData,
            });

            if (!response.ok) {
                throw new Error("La requête a échoué");
            }

            const responseData = await response.json();
            // Traiter la réponse du serveur, afficher un message, etc.
            setIsLoading(false);

            console.log(responseData.statut)

            if (responseData.statut === 'disciplineAtteinte'){
                MySwal.fire({
                    icon: 'error',
                    title: 'Participation',
                    text: `Echec! le nombre de joueurs pour la discipline '${responseData.discipline}' est déjà atteint. Veuillez l'affecter à une autre discipline.`,
                    timer: 10000
                });
            }else{
                // Attendez 3 secondes avant d'afficher l'alerte
                MySwal.fire({
                    icon: 'success',
                    title: 'Participation',
                    text: `Le participant a été enregistré avec succès!`,
                    timer: 10000
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/membre/participation';
                    }
                });
                setTimeout(() => {
                    window.location.href = '/membre/participation';
                }, 7000);

            }



        } catch (error) {
            console.error("Erreur lors de la soumission du formulaire :", error);
            Swal.fire('Erreur', 'Une erreur s\'est produite', 'error');
        } finally {
            setIsLoading(false);
        }
    };

    return (
        <div>
            <section id="inscription">
                <div className="inscription">
                    <div className="row no-gutters justify-content-center align-items-center">
                        <div className="col-xl-10">
                            {abonnement.restantJoueur > 0 ? (
                                <div className="formulaire-bloc">
                                    <form onSubmit={handleSubmit}>
                                        <div className="row mb-5 justify-content-center align-content-center">
                                            <div className="col-12 mb-1">
                                                <h3 className="titre text-center">Formulaire de participation</h3>
                                                <h5 className="abonnement text-left">
                                                    Il reste encore <span>{abonnement.restantJoueur}</span> {abonnement.restantJoueur > 1 ? 'participants' : 'participant'} à inscrire.
                                                </h5>
                                                <FactureInachevee abonnement={abonnement}/>
                                            </div>
                                        </div>
                                        <div className="row row-cols-1 row-cols-lg-2 g-4 no-gutters">
                                            <div className="col">
                                                <div className="form-floating">
                                                    <select
                                                        className="form-select"
                                                        id="_discipline"
                                                        name="discipline"
                                                        aria-label="Floating label select example"
                                                        value={selectedDiscipline}
                                                        onChange={(e) => setSelectedDiscipline(e.target.value)}
                                                    >
                                                        <option>-- Choisissez la discipline de compétition --</option>
                                                        <option value=""></option>
                                                        {disciplines.map((discipline) =>(
                                                            <option
                                                                key={discipline.id}
                                                                value={discipline.id}
                                                            >
                                                                {discipline.titre}
                                                            </option>
                                                        ))}
                                                    </select>
                                                    <label htmlFor="_discipline">Discipline <span>*</span></label>
                                                </div>
                                            </div>

                                            <div className="col">
                                                <div className="form-floating">
                                                    <input
                                                        type="text"
                                                        className="form-control"
                                                        id="_nom"
                                                        name="nom"
                                                        placeholder="nom"
                                                        autoComplete="off"
                                                        required
                                                        value={nom}
                                                        onChange={(e)=> setNom(e.target.value.toUpperCase())}
                                                    />
                                                    <label htmlFor="floatingInput">Nom <span>*</span> </label>
                                                </div>
                                            </div>
                                            <div className="col">
                                                <div className="form-floating">
                                                    <input
                                                        type="text"
                                                        className="form-control"
                                                        id="_prenoms"
                                                        name="prenoms"
                                                        placeholder="prenoms"
                                                        autoComplete="off"
                                                        required
                                                        value={prenom}
                                                        onChange={(e)=> setPrenom(e.target.value.toUpperCase())}
                                                    />
                                                    <label htmlFor="floatingInput">Prénoms <span>*</span></label>
                                                </div>
                                            </div>
                                            <div className="col">
                                                <div className="form-floating">
                                                    <input
                                                        type="text"
                                                        className="form-control"
                                                        id="_matricule"
                                                        name="matricule"
                                                        placeholder="matricule"
                                                        autoComplete="off"
                                                        required
                                                        value={matricule}
                                                        onChange={(e)=> setMatricule(e.target.value.toUpperCase())}
                                                    />
                                                    <label htmlFor="_matricule">Matricule <span>*</span></label>
                                                </div>
                                            </div>
                                            <div className="col">
                                                <div className="form-floating">
                                                    <input
                                                        type="text"
                                                        className="form-control"
                                                        id="_contact"
                                                        name="contact"
                                                        placeholder="contact"
                                                        autoComplete="off"
                                                        required
                                                        value={contact}
                                                        onChange={handleContactChange}
                                                    />
                                                    <label htmlFor="floatingInput">Contact <span>*</span></label>
                                                </div>
                                            </div>
                                            <div className="col">
                                                <div className="form-floating">
                                                    <input
                                                        type="text"
                                                        className="form-control"
                                                        id="_email"
                                                        name="email"
                                                        placeholder="email"
                                                        autoComplete="off"
                                                        required
                                                        value={email}
                                                        onChange={(e)=> setEmail(e.target.value.toLowerCase())}
                                                    />
                                                    <label htmlFor="floatingInput">Email <span>*</span></label>
                                                </div>
                                            </div>

                                            <div className="col">
                                                <div className="mb-3">
                                                    <label htmlFor="">Photo <span>*</span></label>
                                                    <input
                                                        className="form-control form-control-lg"
                                                        type="file"
                                                        data-preview=".preview"
                                                        placeholder="Photo"
                                                        required
                                                        id="_media"
                                                        name="media"
                                                    />
                                                </div>
                                            </div>

                                            <div className="col">
                                                <div className="mb-3">
                                                    <label htmlFor="">Carte professionnelle <span>*</span></label>
                                                    <input
                                                        className="form-control form-control-lg"
                                                        type="file"
                                                        data-preview=".preview"
                                                        placeholder="Photo"
                                                        required
                                                        id="_carte"
                                                        name="carte"
                                                    />
                                                </div>
                                            </div>
                                        </div>


                                        <div className="row mt-5 d-flex justify-content-center align-content-center align-items-center">
                                            <div className="col-12 col-md-6 d-grid gap-2">
                                                <button
                                                    type="submit"
                                                    className="btn btn-success btn-lg bouton"
                                                >
                                                    <i className="bi bi-floppy"></i> Enregistrer
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                ): (
                                    <Facture abonnement={abonnement}/>
                                )
                            }

                        </div>
                    </div>
                </div>
            </section>
            {isLoading ? (
                <div className="loading-animation">
                    <ReactLoading type="spin" color="#007BFF" />
                </div>
            ) : null}
            <ListeParticipant/>
        </div>
    );
}