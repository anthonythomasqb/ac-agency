<?php

namespace App\Command;

use App\Services\MovieService;
use App\Services\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'ac-agency:load:data',
    description: 'Add a short description for your command',
)]
class AcAgencyLoadDataCommand extends Command
{
    protected static $defaultName = 'ac-agency:load:datas';

    /** @var MovieService $movieService */
    private MovieService $movieService;

    /** @var UserService $userService */
    private UserService $userService;

    /**
     * @param MovieService $movieService
     * @param UserService $userService
     */
    public function __construct(MovieService $movieService,
                                UserService $userService)
    {
        $this->movieService = $movieService;
        $this->userService = $userService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command will load default user to test application')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->movieService->purgeMovies();
        $this->userService->purgeUsers();

        $this->movieService->createDefaultMovies();
        $this->userService->createDefaultUsers();

        return Command::SUCCESS;
    }
}
