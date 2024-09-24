<?php

namespace App\Command;

use App\Entity\Discipline;
use App\Repository\DisciplineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:insert-discipline',
    description: 'Insertion des disciplines dans la base de données',
)]
class InsertDisciplineCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private DisciplineRepository $disciplineRepository
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $i=0;
        foreach ($this->dataInsert() as $data){
            $discipline = $this->disciplineRepository->findOneBy(['titre' => $data[0]]);
            if (!$discipline) $discipline = new Discipline();

            $discipline->setTitre($data[0]);
            $discipline->setSlug($data[1]);
            $discipline->setJoueur($data[2]);
            $discipline->setComplementaire($data[3]);

            $this->entityManager->persist($discipline);
            $i++;
        }

        $this->entityManager->flush();

        $io->success("{$i} disciplines sauvegardées avec succès!");

        return Command::SUCCESS;
    }

    private function dataInsert()
    {
        return [
            ['FOOTBALL', 'football', 14, false],
            ['SCRABBLE', 'scrabble', 1, true],
            ['BASKET BALL', 'basket-ball', 10, false],
            ['TENNIS DE TABLE', 'tennis-de-table', 1, true],
            ['MARACANA ZONE', 'maracana-zone', 12, false],
            ['GOLF', 'golf', 1, true],
            ['BABY FOOT', 'baby-foot', 2, true],
            ['4x100 relai', '4x100-relai', 6, false],
            ['PETANQUE', 'petanque', 2, true],
            ['NATATION', 'natation', 1, true],
            ['CYCLISME', 'cyclisme', 1, true],
            ['JEU VIDEO FOOTBALL (PS4)', 'jeu-video-football-ps4', 1, true],
            ['DAMES', 'dames', 1, true],
            ['1500M', '1500m', 1, true],
            ['AWALE', 'awale', 1, true],
            ['LUDO', 'ludo', 1, true],
            ['PETITS POTEAUX', 'petits-poteaux', 10, false],
            ['VOLLEY-BALL', 'volley-ball', 10, false],
            ['MARATHON 5000M', 'marathon-5000m', 1, true],
            ['COURSE EN SAC', 'course-en-sac', 1, true],
            ['100M', '100m', 1, true],
            ['200M', '200m', 1, true],
            ['DANSE AVEC DIFFICULTES', 'danse-avec-difficultes', 1, true],
            ['ECHEC', 'echec', 1, true],
            ['TRIPLE SAUT', 'triple-saut', 1, true],
            ['CARREAU CHINOIS', 'carreau-chinois', 1, true],
            ["TIR A L'ARC", 'tir-a-l-arc', 1, true],
            ['TENNIS', 'tennis', 1, true],
            ['MARCHE DES SENIORS', 'marche-des-seniors', 1, true],
            ['KAYAK', 'kayak', 2, true],
            ["COURSE A L'AVEUGLE", 'course-a-l-aveugle', 2, true],
            ['GENIE EN HERBE', 'genie-en-herbe', 4, true],
            ['TIR A CORDE', 'tir-a-corde', 5, true],
        ];
    }
}
