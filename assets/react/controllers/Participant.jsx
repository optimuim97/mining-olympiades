import React, {useEffect} from 'react';
import AOS from 'aos'

export default function (props) {
    const participant = JSON.parse(props.participant);

    useEffect(() => {
        AOS.init();
    }, []);

    console.log(participant.nom)
    return (
        <div>
            <section id="inscription">
                <div className="inscription">
                    <div className="row no-gutters align-items-center">
                        <div className="col-xl-4"  data-aos="fade-right" data-aos-duration="1500">
                            <div className="instruction-bloc" data-black-overlay="4">
                                <div className="instruction-image">
                                    <img src={`/upload/participants/${participant.media}`} alt="" className="img-fluid" />
                                </div>
                            </div>
                        </div>
                        <div className="col-xl-8">
                            <div className="formulaire-bloc"  data-aos="fade-up" data-aos-duration="1500">

                                <div className="row row-cols-1 row-cols-lg-2 g-4 no-gutters">

                                    <div className="col">
                                        <div className="form-floating">
                                            <input
                                                type="text"
                                                className="form-control licence"
                                                id="licence"
                                                placeholder="email"
                                                value={ participant.licence}
                                                   readOnly
                                            />
                                            <label htmlFor="licence">Licence</label>
                                        </div>
                                    </div>

                                    <div className="col">
                                        <div className="form-floating">
                                            <input
                                                type="text"
                                                className="form-control"
                                                id="compagnie"
                                                placeholder="compagnie"
                                                value="MINE SARL"
                                                readOnly
                                            />
                                            <label htmlFor="floatingInput">Compagnie  </label>
                                        </div>
                                    </div>
                                    <div className="col">
                                        <div className="form-floating">
                                            <input
                                                type="text"
                                                className="form-control"
                                                id="floatingInput"
                                                placeholder="discipline"
                                                value="MARACANA ZONE"
                                                readOnly
                                            />
                                            <label htmlFor="floatingInput">Discipline  </label>
                                        </div>
                                    </div>
                                    <div className="col">
                                        <div className="form-floating">
                                            <input
                                                type="text"
                                                className="form-control"
                                                id="nom"
                                                placeholder="nom"
                                                value={participant.nom}
                                                readOnly
                                            />
                                            <label htmlFor="nom">Nom  </label>
                                        </div>
                                    </div>
                                    <div className="col">
                                        <div className="form-floating">
                                            <input
                                                type="text"
                                                className="form-control"
                                                id="prenoms"
                                                placeholder="prenoms"
                                                value={participant.prenoms}
                                                readOnly
                                            />
                                            <label htmlFor="prenoms">Prenoms </label>
                                        </div>
                                    </div>
                                    <div className="col">
                                        <div className="form-floating">
                                            <input
                                                type="text"
                                                className="form-control"
                                                id="matricule"
                                                placeholder="Matricule"
                                                value={participant.matricule}
                                                readOnly
                                            />
                                            <label htmlFor="matricule">Matricule </label>
                                        </div>
                                    </div>
                                    <div className="col">
                                        <div className="form-floating">
                                            <input
                                                type="text"
                                                className="form-control"
                                                id="_contact"
                                                placeholder="contact"
                                                value={participant.contact}
                                                readOnly
                                            />
                                            <label htmlFor="_contact">Contact </label>
                                        </div>
                                    </div>
                                    <div className="col">
                                        <div className="form-floating">
                                            <input
                                                type="text"
                                                className="form-control"
                                                id="email"
                                                placeholder="email"
                                                value={participant.email ? participant.email : 'RAS'}
                                                readOnly
                                            />
                                            <label htmlFor="email">Email</label>
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
                                                id="flexCheckChecked"
                                                checked disabled
                                            />
                                            <label className="form-check-label" htmlFor="flexCheckChecked">
                                                Je confirme avoir pris connaissance des <a href="#" target="_blank">règlements du tournoi</a> et je les accepte.
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div className="row mt-5 d-flex justify-content-center align-content-center align-items-center">
                                    {/*<div className="col-6 d-grid gap-2">*/}
                                    {/*    <a href="#" className="btn btn-success btn-lg btn-lien"><i className="bi bi-pencil-square"></i> Modifier</a>*/}
                                    {/*</div>*/}
                                    <div className="col-6 d-grid gap-2">
                                        <a href="#" className="btn btn-outline-success btn-lg"><i className="bi bi-printer"></i> Imprimer</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    )
}