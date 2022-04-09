<?php

namespace App\Command;

use App\Repository\ReclamationRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ReclamationCleanupCommand extends Command
{
    private $reclamationRepository;

    protected static $defaultName = 'app:reclamation:cleanup';

    public function __construct(ReclamationRepository $reclamationRepository)
    {
        $this->reclamationRepository = $reclamationRepository;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Deletes old reclamations from the database')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if ($input->getOption('dry-run')) {
            $io->note('Dry mode enabled');

            $count = $this->reclamationRepository->countOld();
        } else {
            $count = $this->reclamationRepository->deleteOld();
        }

        $io->success(sprintf('Deleted "%d" old reclamations .', $count));

        return 0;
    }
}
