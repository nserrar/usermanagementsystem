<?php

namespace App\Command;

use App\Manager\AuthManager;
use App\Manager\UserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class DeleteUserCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'internations:user:delete';


    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var QuestionHelper
     */
    private $questionHelper;

    /**
     * @var AuthManager
     */
    private $authManager;


    public function __construct(UserManager $userManager, QuestionHelper $questionHelper, AuthManager $authManager)
    {
        $this->userManager = $userManager;
        $this->questionHelper = $questionHelper;
        $this->authManager = $authManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Delete user.')
            ->setHelp('This command allows you to remove user by username.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Verify your credentials, please connect before');
        $adminUsername = $this->requestAdminUsername($input, $output);
        $adminPassword = $this->requestAdminPassword($input, $output);
        $isAuth = $this->authManager->checkAuthorization($adminUsername, $adminPassword);

        $username = $this->requestUsername($input, $output);
        $result = $this->userManager->removeUser($username, $isAuth);

        if($result){
            $output->writeln('User have been deleted !');
        }else{
            $output->writeln('A problem occurred, try again');
        }

    }

    private function requestUsername(InputInterface $input, OutputInterface $output) : string
    {
        //TODO:implement validation with setValidator to Question

        return $this->questionHelper->ask($input, $output, new Question('Username : '));
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return string
     */
    private function requestAdminUsername(InputInterface $input, OutputInterface $output) : string
    {
        //TODO:implement validation with setValidator to Question

        return $this->questionHelper->ask($input, $output, new Question('Username : '));
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return string
     */
    private function requestAdminPassword(InputInterface $input, OutputInterface $output) : string
    {
        //TODO:implement validation with setValidator to Question

        return $this->questionHelper->ask($input, $output, new Question('Password : '));
    }
}