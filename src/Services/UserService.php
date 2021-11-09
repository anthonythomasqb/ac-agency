<?php

namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    /** @var EntityManagerInterface $em */
    private EntityManagerInterface $em;

    /** @var LoggerInterface $logger */
    private LoggerInterface $logger;

    /** @var UserPasswordHasherInterface $passwordHasher */
    private UserPasswordHasherInterface $passwordHasher;

    protected static $USERS = [
        [
            "email" => "anthomas63@gmail.com",
            "plainPassword" => "test",
            "role" => "ROLE_MOVIE_MANAGER",
        ],
        [
            "email" => "contact@acwebagency.fr",
            "plainPassword" => "test",
            "role" => "ROLE_MOVIE_MANAGER",
        ],
    ];

    /**
     * @param EntityManagerInterface $em
     * @param LoggerInterface $logger
     */
    public function __construct(EntityManagerInterface $em,
                                LoggerInterface $logger,
                                UserPasswordHasherInterface $passwordHasher)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->passwordHasher = $passwordHasher;
    }

    public function purgeUsers()
    {
        $users = $this->em->getRepository(User::class)->findAll();

        try{
            $nbUsers = count($users);
            if($nbUsers > 0){
                foreach ($users as $user) {
                    $this->em->remove($user);
                }

                $this->em->flush();
            }
            $this->logger->notice("Purging " . $nbUsers . " users successfully");
        }catch (\Exception $e){
            $this->logger->warning("Error when purging users : {$e->getMessage()}");
        }
    }

    /**
     *
     */
    public function createDefaultUsers()
    {
        try{
            foreach (self::$USERS as $userArray){
                $user = new User();
                $user->setEmail($userArray["email"]);
                $user->addRole($userArray["role"]);
                $hashedPwd = $this->passwordHasher->hashPassword($user, $userArray["plainPassword"]);
                $user->setPassword($hashedPwd);
                $this->em->persist($user);

                $this->logger->notice("User '{$userArray["email"]}' created successfully");
            }

            $this->em->flush();
        }catch (\Exception $e){
            $this->logger->warning("Error when creating default users : {$e->getMessage()}");
        }
    }
}