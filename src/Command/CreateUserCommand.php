<?php
// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    private $passwordEncoder;
    private $requirePassword;
    private $em;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entity, bool $requirePassword = false)
    {
        $this->requirePassword = $requirePassword;
        $this->passwordEncoder = $passwordEncoder;
        $this->em = $entity;

        parent::__construct();

        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:create-user')

            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new user.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...');
    }

    protected function configure()
    {
             $this
                 ->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')
                 ->addArgument('password', $this->requirePassword ? InputArgument::OPTIONAL : InputArgument::REQUIRED, 'User password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        $username = $input->getArgument('username');
        $password = $input->getArgument('password');

        /** @var Client $client */
        $client = new Client();
        $client->setUsername($username);

        $password = $this->passwordEncoder->encodePassword($client, $password);
        $client->setPassword($password);
        $client->setEmail($username.'@test.fr');
        $client->setIsActive(true);

        $this->em->persist($client);
        $this->em->flush();

        $output->write('create a user succes.');
    }
}