<?php

namespace App\Service;

use App\Entity\Adhesion;
use App\Entity\Compagnie;
use App\Entity\Membre;
use App\Entity\User;
use App\Repository\CompagnieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class GestionAdherent
{
    private $motDePasse;
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MailerInterface $mailer,
        private CompagnieRepository $compagnieRepository,
        private UserPasswordHasherInterface $passwordHasher

    ) {}

    public function validation(Adhesion $adhesion): void
    {
        $compagnie = new Compagnie();
        $compagnie->setTitre($adhesion->getEntreprise());
        $compagnie->setRepresentant($adhesion->getCivilite() . ' ' . $adhesion->getNom() . ' ' . $adhesion->getPrenoms());
        $compagnie->setDg($adhesion->getCivilite() . ' ' . $adhesion->getNom() . ' ' . $adhesion->getPrenoms());
        $compagnie->setContact($adhesion->getTelephone());
        $compagnie->setSlug($adhesion->getSlug());
        $compagnie->setEmail($adhesion->getEmail());

        $this->entityManager->persist($compagnie);
        $adhesion->setStatut(true);
        $this->entityManager->flush();

        $this->form($adhesion);
        $this->notification($adhesion);
    }

    //     public function notification($adhesion): void
    //     {
    //         //dd($adhesion);
    //         $email = (new Email())
    //             ->from('noreply@miningolympiades.org')
    //             ->to('delrodieamoikon@gmail.com')
    //             ->subject("Validation de votre demande d'adhésion")
    //             ->text('Votre demande a été validée avec succès!')
    //             ->html('<p>See Twig integration for better HTML integration!</p>')
    //         ;

    //         try {
    // //            dd($email);
    //             $this->mailer->send(message: $email);
    //             // Si nous sommes ici, l'envoi a réussi
    //             //dd( 'L\'e-mail a été envoyé avec succès!');
    //         } catch (TransportExceptionInterface $e) {
    //             // Une exception est lancée si quelque chose ne va pas
    //             echo 'Erreur lors de l\'envoi de l\'e-mail: '.$e->getMessage();
    //         }
    //     }

    public function notification(Adhesion $adhesion): void
    {
        // Variables dynamiques
        $prenom = $adhesion->getPrenoms(); // Extrait le prénom de l'adhérent
        $emailUtilisateur = $adhesion->getEmail(); // Extrait l'adresse e-mail de l'adhérent
        // $this->motDePasse = $this->generateRandomPassword() ?? 'motDePasseGenere'; // Générer ou récupérer un mot de passe
        // Corps de l'e-mail en HTML
        $htmlContent = "
        <html>
        <body>
            <p>Bonjour $prenom,</p>
            <p>Félicitations ! Votre inscription à <strong>Mining Olympiades 2024</strong> a été validée avec succès.</p>
            <p>Nous sommes ravis de vous compter parmi les participants de cet événement.</p>
            <p>Pour accéder à votre espace personnel et choisir vos disciplines, voici vos identifiants de connexion :</p>
            <ul>
                <li><strong>Nom d’utilisateur :</strong> $emailUtilisateur</li>
                <li><strong>Mot de passe :</strong> $this->motDePasse </li>
            </ul>
            <p>Veuillez vous connecter dès maintenant sur <a href='https://miningolympiades.org/login'>votre espace personnel</a>.</p>
            <p>Cordialement !</p>
            <p><strong>Contacts :</strong> (+225) 27 22 403 966 / 07 87 755 337</p>
        </body>
        </html>
    ";

        // Création de l'email
        $email = (new Email())
            ->from('noreplay@olympia.com')
            ->to($emailUtilisateur)
            ->subject('Confirmation de votre inscription et informations de connexion')
            ->html($htmlContent); // Corps de l'email au format HTML

        // Envoi de l'email
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            // Gérer les erreurs d'envoi
            echo 'Erreur lors de l\'envoi de l\'e-mail: ' . $e->getMessage();
        }
    }


    public function form(Adhesion $adhesion, $user = null, $membre = null): bool
    {
        $requestCompagnie = $adhesion->getEntreprise();
        $requetEmail = $adhesion->getEmail();
        $this->motDePasse  =  $this->generateRandomPassword();
        $requestPassword = $this->motDePasse;

        $requestParticipation = "2500";

        // Recherche de la compagnie
        $compagnie = $this->compagnieRepository->findOneBy(['titre' => $requestCompagnie]);
        if (!$compagnie) {
            return false;
        }

        // Enregistrement de l'user
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $requetEmail]);

        if (!$user) {
            $user = new User();
        }

        $user->setEmail($requetEmail);
        $user->setPassword($this->passwordHasher->hashPassword($user, $requestPassword));
        $user->setRoles(['ROLE_USER']);
        $this->entityManager->persist($user);

        $membre = $this->entityManager
            ->getRepository(Membre::class)
            ->findOneBy(['user' => $user]);
        // Enregistrement du membre
        if (!$membre) {
            $membre = new Membre();
        }
        $membre->setCompagnie($compagnie);
        $membre->setUser($user);
        $membre->setParticipation((int) $requestParticipation);

        // dd($membre);

        $this->entityManager->persist($membre);
        $this->entityManager->flush();

        return true;
    }

    public function generateRandomPassword($length = 12)
    {
        return substr(bin2hex(random_bytes($length)), 0, $length);
    }
}
