import React, {useEffect, useState} from 'react';
import {CircleSpinnerOverlay} from "react-spinner-overlay";
import ReactLoading from "react-loading";
import AOS from "aos";
import Swal from 'sweetalert2';
import withReactContent from 'sweetalert2-react-content';

const MySwal = withReactContent(Swal);

export default function () {
    const [isLoading, setIsLoading] = useState(false);
    const [loading, setLoading] = useState(true);
    const [nom, setNom] = useState('');
    const [prenoms, setPrenoms] = useState('');
    const [email, setEmail] = useState('');
    const [contact, setContact] = useState('');
    const [niveau, setNiveau] = useState('');
    const [filiere, setFiliere] = useState('');
    const [isCheckedImage, setIsCheckedImage] = useState(false);

    // Verifions si toutes les cases sont cochées
    const isSubmitDisabled = !(isCheckedImage);


    useEffect(() => {
        AOS.init();

        window.onload = () =>{
            setLoading(false);
        }
    }, []);

    const handleContactChange = (e) => {
        const cleanedValue = e.target.value.replace(/\D/g, '');
        const formattedValue = cleanedValue.slice(0, 10);
        setContact(formattedValue);
    }

    const handleSubmit = async (e) => {
        e.preventDefault()
        setLoading(true)

        const formData = new FormData(e.target);

        try {
            const response = await fetch('/api/scientifique/', {
                method: "POST",
                body: formData,
            });

            if (!response.ok) {
                console.log(`Erreur HTTP! Status: ${response.status}`);
                setIsLoading(false);
                MySwal.fire({
                    icon: 'error',
                    // title: 'Adhésion',
                    text: `Erreur HTTP! Status: ${response.status}`,
                    timer: 6000
                });
                setLoading(false)
            }

            if (response.status === 400){
                setIsLoading(false);
                MySwal.fire({
                    icon: 'warning',
                    // title: 'Adhésion',
                    text: `Echec! vous avez déjà été enregistré(e)`,
                    timer: 6000
                });
                setLoading(false)
            }else{
                setIsLoading(false);

                console.log(response.status)

                const data = await response.json();
                MySwal.fire({
                    icon: 'success',
                    title: 'Inscription',
                    text: `Votre inscription a été enregistrée avec succès!`,
                    timer: 6000
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = window.location.origin;
                    }
                });

                setLoading(false)

                setTimeout(() => {
                    window.location.href = window.location.origin;
                }, 3000);

            }

        } catch (e) {
            console.log("Une erreur s'est produite lors de l'envoi du formulaire :", e);
            setIsLoading(false)
        }
    }

    return (
        <div>
            {loading
                ? <CircleSpinnerOverlay/>
                : (
                    <section id="inscription">
                        <div className="inscription">
                            <div className="row no-gutters align-items-center">
                                <div className="col-xl-4"  data-aos="fade-right" data-aos-duration="1500">
                                    <div className="instruction-bloc" data-black-overlay="4">
                                        <div className="instruction-contenu">
                                            <h3>Journée <span>scientifique</span></h3>
                                            <p>
                                                La journée scientifique de cette 8ème édition à pour thème : <strong><em>« L’importance des politiques de santé et sécurité dans les mines »</em></strong>.
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
                                                            value={prenoms}
                                                            onChange={(e)=> setPrenoms(e.target.value.toUpperCase())}
                                                        />
                                                        <label htmlFor="floatingInput">Prénoms <span>*</span></label>
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
                                                            type="email"
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
                                                    <div className="form-floating">
                                                        <input
                                                            type="text"
                                                            className="form-control"
                                                            id="_filiere"
                                                            name="filiere"
                                                            placeholder="Filière"
                                                            autoComplete="off"
                                                            required
                                                            value={filiere}
                                                            onChange={(e)=> setFiliere(e.target.value.toUpperCase())}
                                                        />
                                                        <label htmlFor="_filiere">Filière <span>*</span></label>
                                                    </div>
                                                </div>
                                                <div className="col">
                                                    <div className="form-floating">
                                                        <input
                                                            type="text"
                                                            className="form-control"
                                                            id="_niveau"
                                                            name="niveau"
                                                            placeholder="email"
                                                            autoComplete="off"
                                                            required
                                                            value={niveau}
                                                            onChange={(e)=> setNiveau(e.target.value.toUpperCase())}
                                                        />
                                                        <label htmlFor="_niveau">Niveau d'étude <span>*</span></label>
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
                                                        <i className="bi bi-floppy"></i> Je m'inscris
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                )
            }
            {isLoading ? (
                <div className="loading-animation">
                    <ReactLoading type="spin" color="#007BFF" />
                </div>
            ) : null}
        </div>
    )
}