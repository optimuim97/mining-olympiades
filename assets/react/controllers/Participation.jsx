import React, {useEffect, useState} from 'react';
import AOS from 'aos';
import ReactLoading from 'react-loading';

export default function () {
    const [isLoading, setIsLoading] = useState(false);
    const [disciplines, setDisciplines] = useState([]);
    const [selectedDiscipline, setSelectedDiscipline] = useState('');
    const [compagnies, setCompagnies] = useState([]);
    const [selectedCompagnie, setSelectedCompagnie] = useState('');
    const [isCheckedReglement, setIsCheckedReglement] = useState(false);
    const [isCheckedImage, setIsCheckedImage] = useState(false);
    const [nom, setNom] = useState('');
    const [prenom, setPrenom] = useState('');

    useEffect(() => {
        AOS.init();

        async function fetchDiscipline(){
            try {
                const response = await fetch('/api/discipline/');
                if (!response.ok){
                    throw new Error("La réquête a échoué");
                }

                const disciplineData = await response.json();
                setDisciplines(disciplineData);
            } catch (e) {
                console.error("Erreur de la récupération des discipline: ", e)
            }
        }

        async function fetchCompagnie(){
            try {
                const response = await fetch('/api/compagnie/');
                if (!response.ok){
                    throw new Error("La réquête a echouée");
                }
                const compagnieData = await response.json();
                setCompagnies(compagnieData);
            } catch (e) {
                console.error('Erreur lors de la récupération des compagnies: ', e)
            }
        }

        fetchDiscipline();
        fetchCompagnie();
    }, []);


    // Verifions si toutes les cases sont cochées
    const isSubmitDisabled = !(selectedCompagnie && selectedDiscipline && isCheckedReglement && isCheckedImage);

    const handleNomChange = (e) => {
      setNom(e.target.value.toUpperCase());
    }

    const handlePrenomChange = (e) => {
      setPrenom(e.target.value.toUpperCase());
    }

    const handleSubmit = async (e) => {
       e.preventDefault();

       setIsLoading(true);

        // Construisez les données du formulaire
        const formData = new FormData();
        formData.append('compagnie', selectedCompagnie);
        formData.append('discipline', selectedDiscipline);
        formData.append('nom', e.target.elements._nom.value);
        formData.append('prenoms', e.target.elements._prenoms.value);
        formData.append('matricule', e.target.elements._matricule.value);
        formData.append('contact', e.target.elements._contact.value);
        formData.append('email', e.target.elements._email.value);
        formData.append('media', e.target.elements._media.files[0]);
        formData.append('reglement', isCheckedReglement);
        formData.append('image', isCheckedImage);

        console.log(formData)

        // Envoyez les données à l'API
        try {
            const response = await fetch('/api/participation/', {
                method: 'POST',
                body: formData,
            });

            if (!response.ok) {
                throw new Error("La requête a échoué");
            }

            const participant = await response.json();
            console.log(participant.slug)
            window.location.href = '/participation/' + participant.slug;

            setIsLoading(false);

            // Gérez la réponse de l'API ici (par exemple, affichez un message de succès)
        } catch (error) {
            console.error("Erreur lors de l'envoi du formulaire à l'API : ", error);
            setIsLoading(false)
        }
    };

    return (
        <div>
            <section id="inscription">
                <div className="inscription">
                    <div className="row no-gutters align-items-center">
                        <div className="col-xl-4"  data-aos="fade-right" data-aos-duration="1500">
                            <div className="instruction-bloc" data-black-overlay="4">
                                <div className="instruction-contenu">
                                    <h3>Je <span>compétie</span></h3>
                                    <p>
                                        Je m'engage solennellement à respecter scrupuleusement les règles du tournoi établies,
                                        et je confirme ma capacité à concourir dans la discipline que j'ai choisie.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div className="col-xl-8">
                            <div className="formulaire-bloc"  data-aos="fade-up" data-aos-duration="1500">
                                <form onSubmit={handleSubmit}>
                                    <div className="row row-cols-1 row-cols-lg-2 g-4 no-gutters">
                                        <div className="col">
                                            <div className="form-floating">
                                                <select
                                                    className="form-select"
                                                    id="_compagnie"
                                                    aria-label="Floating label select example"
                                                    value={selectedCompagnie}
                                                    onChange={(e) => setSelectedCompagnie(e.target.value)}
                                                >
                                                    <option >-- Choisissez votre société --</option>
                                                    <option value=""></option>
                                                    {compagnies.map((compagnie) =>(
                                                        <option
                                                            key={compagnie.id}
                                                            value={compagnie.id}
                                                        >
                                                            {compagnie.titre}
                                                        </option>
                                                    ))}
                                                </select>
                                                <label htmlFor="_compagnie">Compagnie <span>*</span></label>
                                            </div>
                                        </div>
                                        <div className="col">
                                            <div className="form-floating">
                                                <select
                                                    className="form-select"
                                                    id="_discipline"
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
                                                    placeholder="nom"
                                                    autoComplete="off"
                                                    required
                                                    value={nom}
                                                    onChange={handleNomChange}
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
                                                    placeholder="prenoms"
                                                    autoComplete="off"
                                                    required
                                                    value={prenom}
                                                    onChange={handlePrenomChange}
                                                />
                                                    <label htmlFor="floatingInput">Prenoms <span>*</span></label>
                                            </div>
                                        </div>
                                        <div className="col">
                                            <div className="form-floating">
                                                <input
                                                    type="text"
                                                    className="form-control"
                                                    id="_matricule"
                                                    placeholder="matricule"
                                                    autoComplete="off"
                                                    required
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
                                                    placeholder="contact"
                                                    autoComplete="off"
                                                    required
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
                                                    placeholder="email"
                                                    autoComplete="off"
                                                />
                                                    <label htmlFor="floatingInput">Email</label>
                                            </div>
                                        </div>

                                        <div className="col">
                                            <div className="mb-3">
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


                                    </div>
                                    <div className="row">
                                        <div className="col-12 mt-3">
                                            <div className="form-check">
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    value=""
                                                    id="_reglement"
                                                    checked={isCheckedReglement}
                                                    onChange={() => setIsCheckedReglement(!isCheckedReglement)}
                                                />
                                                    <label className="form-check-label" htmlFor="_reglement">
                                                        <em>
                                                            En m'inscrivant je confirme avoir pris connaissance des <a href="#" target="_blank">règlements du tournoi</a> et l'accepte.
                                                        </em>
                                                    </label>
                                            </div>
                                        </div>
                                        <div className="col-12 mt-3">
                                            <div className="form-check">
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    value=""
                                                    id="_image"
                                                    checked={isCheckedImage}
                                                    onChange={() => setIsCheckedImage(!isCheckedImage)}
                                                />
                                                    <label className="form-check-label" htmlFor="_image">
                                                        <em>
                                                            En remplissant ce formulaire, j'accorde au comité d'organisation l'autorisation d'utiliser mon image à des fins de promotion
                                                            de cet événement, que ce soit sur des supports physiques ou numériques, y compris pour les éditions à venir.
                                                        </em>
                                                    </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="row mt-5 d-flex justify-content-center align-content-center align-items-center">
                                        <div className="col-12 col-md-6 d-grid gap-2">
                                            <button
                                                type="submit"
                                                className="btn btn-success btn-lg bouton"
                                                disabled={isSubmitDisabled}
                                            >
                                                <i className="bi bi-floppy"></i> Enregistrer
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
    )
}