<?php

namespace App\Command;

use App\Manager\AuthManager;
use App\Manager\GroupManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateGroupCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'internations:group:create';

    /**
     * @var GroupManager
     */
    private $groupManager;

    /**
     * @var QuestionHelper
     */
    private $questionHelper;

    /**
     * @var AuthManager
     */
    private $authManager;


    public function __construct(GroupManager $groupManager, QuestionHelper $questionHelper, AuthManager $authManager)
    {
        $this->groupManager = $groupManager;
        $this->questionHelper = $questionHelper;
        $this->authManager = $authManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a group.')
            ->setHelp('This command allows you to create group.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Verify your credentials, please connect before');
        $adminUsername = $this->requestAdminUsername($input, $output);
        $adminPassword = $this->requestAdminPassword($input, $output);
        $isAuth = $this->authManager->checkAuthorization($adminUsername, $adminPassword);

        $groupName = $this->requestName($input, $output);
        $result = $this->groupManager->createGroup($groupName, $isAuth);

        if($result){
            $output->writeln('Group have been created !');
        }else{
            $output->writeln('A problem occurred, try again');
        }

    }

    private function requestName(InputInterface $input, OutputInterface $output) : string
    {
        //TODO:implement validation with setValidator to Question

        return $this->questionHelper->ask($input, $output, new Question('Group Name : '));
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