document.addEventListener("DOMContentLoaded", function () {
    const boutonParticiper = document.querySelectorAll(".boutonParticiper");
    const urlRoot = window.location.origin;

    boutonParticiper.addEventListener("click", function () {
        Swal.fire({
            title: "Inscription",
            text: "Êtes-vous membre du GPMCI ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Oui, je suis membre",
            cancelButtonText: "Non, je ne suis pas membre",
            showThirdButton: true, // Activer le troisième bouton
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = urlRoot + '/membre/';
            } else if(
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ){
                // L'utilisateur n'est pas membre, redirigez-le vers le formulaire des non-membres
                window.location.href = urlRoot + "/participation/";
            }
        });
    });
});
