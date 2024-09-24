import React, {useEffect, useRef, useState} from 'react';
import AOS from 'aos';
import "jquery/dist/jquery.min.js";
import "datatables.net-dt/js/dataTables.dataTables";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import "datatables.net-buttons/js/dataTables.buttons.js";
import "datatables.net-buttons/js/buttons.colVis.js";
import "datatables.net-buttons/js/buttons.flash.js";
import "datatables.net-buttons/js/buttons.html5.js";
import "datatables.net-buttons/js/buttons.print.js";
import $ from "jquery";
import 'bootstrap/dist/css/bootstrap.min.css';
import Francais from '../../js/French.json';
import { IoTrashOutline } from "react-icons/io5";
import Swal from 'sweetalert2';
import withReactContent from "sweetalert2-react-content";
const MySwal = withReactContent(Swal);


export default function () {
    const [participants, setParticipants] = useState([]);
    const tableRef = useRef();

    function deleteParticipant(participantId) {
        if (window.confirm('Êtes-vous sûr de vouloir supprimer ce participant ?')) {
            // alert(participantId)
            // Envoyer une requête de suppression au backend (utilisez fetch ou une bibliothèque comme axios)
            fetch(`/api/discipline/membre/delete/${participantId}`, {
                method: 'DELETE',
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('La suppression a échoué');
                    }
                    // Mettre à jour l'état local (participants) en supprimant le participant
                    const updatedParticipants = participants.filter((p) => p.id !== participantId);
                    setParticipants(updatedParticipants);

                    MySwal.fire({
                        icon: 'success',
                        title: 'Suppression',
                        text: `Le participant a été supprimé avec succès!`,
                        timer: 10000
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/membre/participation';
                        }
                    });
                    setTimeout(() => {
                        window.location.href = '/membre/participation';
                    }, 7000);

                    fetchParticipants();

                })
                .catch(error => console.error('Erreur lors de la suppression :', error));
        }
    }

    useEffect(() => {
        AOS.init();

        async function fetchParticipants() {
            console.log('entrée')
            try {
                const response = await fetch('/api/discipline/membre/liste/');
                if (!response.ok){
                    throw new Error('La réquête a échouée');
                }

                const participantData = await response.json();
                setParticipants(participantData);
                console.log('la liste')
                console.log(participantData);
                // Initialize DataTables after fetching data

                $(tableRef.current).DataTable({
                    data: participantData,
                    columns: [
                        { title: 'ID', data: 'id' }, // Adjust the column names accordingly
                        { title: 'Licence', data: 'licence' },
                        { title: 'Nom', data: 'nom' },
                        { title: 'Prénoms', data: 'prenoms' },
                        { title: 'Matricule', data: 'matricule' },
                        { title: 'Contact', data: 'contact' },
                        { title: 'Email', data: 'email' },
                        {
                            title: 'Discipline',
                            data: null,
                            render: function (data, type, row) {
                                // Utiliser row.discipline pour accéder aux détails de la discipline
                                return row.discipline.map((discipline) => discipline.titre).join(', ');
                            },
                        },
                        {
                            title: 'Actions',
                            render: function (data, type, row) {
                                return `<button class="btn btn-danger btn-sm delete-btn" data-participant-id="${row.id}"><i class="bi bi-trash"></i></button>`;
                            },
                        },
                    ],
                    language: Francais,
                    dom: 'Bfrtip', // Add buttons container in the DOM
                    buttons: [
                        {
                            extend: 'copy',
                            className: 'btn btn-outline-success', // Utilisez la classe de boutons Bootstrap
                        },
                        {
                            extend: 'csv',
                            className: 'btn btn-outline-success',
                        },
                        {
                            extend: 'excel',
                            className: 'btn btn-outline-success',
                        },
                        {
                            extend: 'pdf',
                            text: 'PDF',
                            title: 'Liste des participants',
                            filename: 'liste_participants',
                            className: 'btn btn-outline-success',
                        },
                        {
                            extend: 'print',
                            className: 'btn btn-outline-success',
                        },
                    ],
                });

            } catch (e) {
                console.log('Erreur de la récupération des participants: ', e)
            }
        }

        fetchParticipants();

        $(tableRef.current).on('click', '.delete-btn', function () {
            const participantId = $(this).data('participant-id');
            deleteParticipant(participantId);
        });

    }, []);

    return (
        <div>
            <section id="inscription">
                <div className="inscription">
                    <h3 className="titre">Liste des participants</h3>
                    <div className="liste mt-3">
                        <table ref={tableRef} className="display" style={{ width: '100%' }} />
                    </div>
                </div>
            </section>
        </div>
    )
}