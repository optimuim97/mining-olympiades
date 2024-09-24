<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\AsciiSlugger;

class GestionMedia
{
    private $mediaProfile;
    private mixed $mediAdhesion;
    private mixed $mediaSponsoring;

    public function __construct(
        $participantDirectory, $adhesionDirectory, $sponsorDirectory
    )
    {
        $this->mediaProfile = $participantDirectory;
        $this->mediAdhesion = $adhesionDirectory;
        $this->mediaSponsoring = $sponsorDirectory;
    }

    /**
     * @param $form
     * @param object $entity
     * @param string $entityName
     * @return void
     */
    public function media($form, object $entity, string $entityName): void
    {
        // Gestion des médias
        $mediaFile = $form->get('media')->getData();
        if ($mediaFile){
            $media = $this->upload($mediaFile, $entityName);

            if ($entity->getMedia()){
                $this->removeUpload($entity->getMedia(), $entityName);
            }

            $entity->setMedia($media);
        }
    }


    /**
     * @param UploadedFile $file
     * @param $media
     * @return string
     */
    public function upload(UploadedFile $file, $media = null): string
    {
        // Initialisation du slug
        $slugify = new AsciiSlugger();

        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugify->slug($originalFileName);
        $newFilename = $safeFilename.'-'.Time().'.'.$file->guessExtension();

        // Deplacement du fichier dans le repertoire dedié
        try {
            if ($media === 'participant') $file->move($this->mediaProfile, $newFilename);
            elseif ($media === 'adhesion') $file->move($this->mediAdhesion, $newFilename);
            elseif ($media === 'sponsor') $file->move($this->mediaSponsoring, $newFilename);
            else $file->move($this->mediaProfile, $newFilename);
        }catch (FileException $e){

        }

        return $newFilename;
    }

    /**
     * Suppression de l'ancien media sur le server
     *
     * @param $ancienMedia
     * @param null $media
     * @return bool
     */
    public function removeUpload($ancienMedia, $media = null): bool
    {
        if ($media === 'participant') unlink($this->mediaProfile.'/'.$ancienMedia);
        elseif ($media === 'adhesion') unlink($this->mediAdhesion.'/'.$ancienMedia);
        elseif ($media === 'sponsor') unlink($this->mediaSponsoring.'/'.$ancienMedia);
        else return false;

        return true;
    }

}