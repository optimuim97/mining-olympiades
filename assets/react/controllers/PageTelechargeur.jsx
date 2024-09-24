import React, {useEffect, useState} from 'react';
import ReactLoading from "react-loading";
import {CircleSpinnerOverlay} from "react-spinner-overlay";
import AOS from 'aos';
import $ from 'jquery';
import Swal from 'sweetalert2';
import withReactContent from 'sweetalert2-react-content';
import {Modal, Button} from "react-bootstrap";

const MySwal = withReactContent(Swal);
const docUrl = '/doc/plaquette-commerciale.pdf'


export default function (props) {
    const [isLoading, setIsLoading] = useState(false);
    const [loading, setLoading] = useState(true);
    const [nom, setNom] = useState('');
    const [prenoms, setPrenoms] = useState('');
    const [email, setEmail] = useState('');
    const [contact, setContact] = useState('');
    const [compagnie, setCompagnie] = useState('')
    const [fonction, setFonction] = useState('')
    const [secteur, setSecteur] = useState('')
    const [description, setDescription] = useState('')
    const [selectedOffer, setSelectedOffer] = useState('');
    const [offerAmount, setOfferAmount] = useState('');
    const [isModalVisible, setModalVisible] = useState(false);


    useEffect(() => {
        AOS.init();

        window.onload = () =>{
            setLoading(false);
        }

    }, []);

    const handleSubmit = async(e) => {
      e.preventDefault();

        setLoading(true)

      const formData = new FormData(e.target);

      try {
          const response = await fetch('/api/telechargeur/',{
              method: "POST",
              body: formData,
          });

          if (!response.ok){
              console.log(`Erreur HTTP! Status: ${response.status}`);
              setIsLoading(false);
              MySwal.fire({
                  icon: 'error',
                  // title: 'Adhésion',
                  text: `Erreur HTTP! Status: ${response.status}`,
                  timer: 6000
              });
          }

          setIsLoading(false);

          console.log(response.status)

          const data = await response.json();
          MySwal.fire({
              icon: 'success',
              title: 'Sponsoring',
              text: `Merci pour les informations. Le téléchargement va commencer sous peu`,
              timer: 6000
          });

          setTimeout(() => {
              window.open(docUrl, '_blank');
              // window.location.href = window.location.origin;
              window.location.href = '/sponsoring/telechargement/plaquette';
          }, 3000);
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
                            <div className="row no-gutters justify-content-center align-items-center">
                                <h3 className="text-center">{props.titre}</h3>
                                <div className="col-xl-10">
                                    <div className="formulaire-bloc" data-aos="fade-up" data-aos-duration="1500">
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
                                                            placeholder="nom"
                                                            autoComplete="off"
                                                            required
                                                            value={prenoms}
                                                            onChange={(e)=> setPrenoms(e.target.value.toUpperCase())}
                                                        />
                                                        <label htmlFor="floatingInput">Prénoms <span>*</span> </label>
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
                                                        <label htmlFor="floatingInput">Email <span>*</span> </label>
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
                                                            // value={contact}
                                                            // onChange={(e)=> setPrenoms(e.target.value.to())}
                                                        />
                                                        <label htmlFor="floatingInput">Contact <span>*</span> </label>
                                                    </div>
                                                </div>
                                                <div className="col">
                                                    <div className="form-floating">
                                                        <input
                                                            type="text"
                                                            className="form-control"
                                                            id="_compagnie"
                                                            name="compagnie"
                                                            placeholder="compagnie"
                                                            autoComplete="off"
                                                            required
                                                            value={compagnie}
                                                            onChange={(e)=> setCompagnie(e.target.value.toUpperCase())}
                                                        />
                                                        <label htmlFor="floatingInput">Entreprise <span>*</span> </label>
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
                                                        <label htmlFor="floatingInput">Fonction <span>*</span> </label>
                                                    </div>
                                                </div>
                                                <div className="col">
                                                    <div className="form-floating">
                                                        <input
                                                            type="text"
                                                            className="form-control"
                                                            id="_secteur"
                                                            name="secteur"
                                                            placeholder="secteur"
                                                            autoComplete="off"
                                                            required
                                                            value={secteur}
                                                            onChange={(e)=> setSecteur(e.target.value.toUpperCase())}
                                                        />
                                                        <label htmlFor="floatingInput">Secteur d'activité <span>*</span> </label>
                                                    </div>
                                                </div>
                                                <div className="col">
                                                    <div className="form-floating">
                                                        <textarea
                                                            className="form-control"
                                                            placeholder="Description de votre entreprise"
                                                            id="_description"
                                                            name="description"
                                                        />
                                                        <label htmlFor="_description">Description</label>
                                                    </div>
                                                </div>

                                            </div>

                                            <div className="row mt-5 d-flex justify-content-center align-content-center align-items-center">
                                                <div className="col-12 col-lg-10 col-xl-6 d-grid gap-2">
                                                    <input
                                                        type="hidden"
                                                        name="objet"
                                                        value={props.titre}
                                                    />
                                                    <button
                                                        type="submit"
                                                        className="btn btn-success btn-lg bouton"
                                                    >
                                                        <i className="bi bi-send"></i> Soumettre
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <Modal show={isModalVisible} onHide={() => setModalVisible(false)} size="xl">
                            <Modal.Header closeButton>
                                <Modal.Title>Offre de sponsoring</Modal.Title>
                            </Modal.Header>
                            <Modal.Body>
                                <img src="/assets/images/offre-sponsor.png" alt="" className="img-fluid" loading="lazy"/>
                            </Modal.Body>
                            <Modal.Footer>
                                <Button variant="secondary" onClick={() => setModalVisible(false)}>
                                    Fermer
                                </Button>
                            </Modal.Footer>
                        </Modal>;

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