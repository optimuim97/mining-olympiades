import React, {useEffect, useRef, useState} from "react";
import {CircleSpinnerOverlay} from "react-spinner-overlay";
import AOS from 'aos';
import $ from 'jquery';
import 'dropify/dist/css/dropify.min.css';
import 'dropify/dist/js/dropify.min';
import ReactLoading from 'react-loading';
import Swal from 'sweetalert2';
import withReactContent from 'sweetalert2-react-content';

const MySwal = withReactContent(Swal);

export default function () {
    const [isLoading, setIsLoading] = useState(false);
    const [loading, setLoading] = useState(true);
    const dropifyRef = useRef(null);
    const [nom, setNom] = useState("");
    const [prenoms, setPrenoms] = useState("");
    const [entreprise, setEntreprise] = useState("");
    const [fonction, setFonction] = useState("");

    useEffect(() => {
        AOS.init();

        $('dropifyRef.current').dropify();
        $('.dropify').dropify();

        window.onload = () =>{
            setLoading(false);
        }

        return () =>{
            window.onload = null;
        }

    }, []);

    const handleSubmit = async (e) => {
        e.preventDefault();

        setIsLoading(true);

        const formData = new FormData();

        // Ajoutez les autres champs au FormData
        formData.append("civilite", document.getElementById("_civilite").value);
        formData.append("nom", nom);
        formData.append("prenoms", prenoms);
        formData.append("fonction", document.getElementById("_fonction").value);
        formData.append("entreprise", entreprise);
        formData.append("email", document.getElementById("_email").value);
        formData.append("telephone", document.getElementById("_telephone").value);
        formData.append("adresse", document.getElementById("_adresse").value);

        // Ajoutez le fichier
        formData.append("media", dropifyRef.current.files[0]);

        console.log(formData);

        try {
            // Effectuez la requête POST à l'API
            const response = await fetch("/api/adhesion/", {
                method: "POST",
                body: formData
            });

            if (!response.ok) {
                console.error("Erreur lors de la soumission du formulaire.");
            }
            const data = await response.json();

            setIsLoading(false);

            // Attendez 3 secondes avant d'afficher l'alerte
            MySwal.fire({
                icon: 'success',
                title: 'Adhésion',
                text: `Votre demande a été envoyée avec succès! Vous serez contacté par les administrateurs.`,
                timer: 10000
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = window.location.origin;
                }
            });
            setTimeout(() => {
                window.location.href = window.location.origin;
            }, 10000);

        } catch (error) {
            console.error("Une erreur s'est prPageScientifiqueoduite lors de la soumission du formulaire :", error);

            setIsLoading(false);
        }
    };

    return (
        <div>
            {loading
                ? <CircleSpinnerOverlay />
                : (
                    <section id="inscription">
                        <div className="inscription">
                            <div className="row">
                                <div className="col-12 text-center">
                                    <h3>Formulaire de participation</h3>
                                </div>
                            </div>
                            <div className="row no-gutters justify-content-center align-items-center">
                                <div className="col-xl-10">
                                    <div className="formulaire-bloc"  data-aos="fade-up" data-aos-duration="1500">
                                        <form onSubmit={handleSubmit} encType="multipart/form-data">
                                            <div className="row row-cols-1 row-cols-lg-2 g-4 no-gutters">
                                                <div className="col">
                                                    <div className="form-floating">
                                                        <select
                                                            className="form-select"
                                                            id="_civilite"
                                                            aria-label="Floating label select civilite"
                                                            name="civilite"
                                                            autoComplete="off"
                                                            required
                                                        >
                                                            <option value=""></option>
                                                            <option value="Hon">Hon</option>
                                                            <option value="Dr">Dr</option>
                                                            <option value="M.">M.</option>
                                                            <option value="Mlle">Mlle</option>
                                                            <option value="Mme">Mme</option>
                                                        </select>
                                                        <label htmlFor="_civilite">Civilité <span>*</span></label>
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
                                                            id="_fonction"
                                                            name="fonction"
                                                            placeholder="fonction"
                                                            autoComplete="off"
                                                            required
                                                            value={fonction}
                                                            onChange={(e)=> setFonction(e.target.value.toUpperCase())}
                                                        />
                                                        <label htmlFor="_fonction">Fonction <span>*</span></label>
                                                    </div>
                                                </div>
                                                <div className="col">
                                                    <div className="form-floating">
                                                        <input
                                                            type="text"
                                                            className="form-control"
                                                            id="_entreprise"
                                                            name="entreprise"
                                                            placeholder="contact"
                                                            autoComplete="off"
                                                            required
                                                            value={entreprise}
                                                            onChange={(e)=> setEntreprise(e.target.value.toUpperCase())}
                                                        />
                                                        <label htmlFor="_entreprise">Entreprise <span>*</span></label>
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
                                                        />
                                                        <label htmlFor="_email">Email <span>*</span></label>
                                                    </div>
                                                </div>
                                                <div className="col">
                                                    <div className="form-floating">
                                                        <input
                                                            type="tel"
                                                            className="form-control"
                                                            id="_telephone"
                                                            name="telephone"
                                                            placeholder="email"
                                                            autoComplete="off"
                                                            required
                                                        />
                                                        <label htmlFor="_telephone">Contact <span>*</span></label>
                                                    </div>
                                                </div>
                                                <div className="col">
                                                    <div className="form-floating">
                                                        <textarea
                                                            className="form-control"
                                                            placeholder="Leave a comment here"
                                                            id="_adresse"
                                                            required
                                                            name="adresse"
                                                        ></textarea>
                                                        <label htmlFor="_adresse">Adresse <span>*</span></label>
                                                    </div>
                                                </div>

                                                <div className="col">
                                                    <div className="mb-3">
                                                        <label htmlFor="media">Logo</label>
                                                        <input
                                                            className="form-control form-control-lg dropify"
                                                            ref={dropifyRef}
                                                            type="file"
                                                            data-preview=".preview"
                                                            placeholder="Photo"
                                                            id="_media"
                                                            name="media"
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
                                                        <i className="bi bi-send"></i> Envoyer
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
    );
}