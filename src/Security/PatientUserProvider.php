<?php

namespace App\Security;

use App\Entity\Patient;
use App\Repository\PatientRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class PatientUserProvider implements UserProviderInterface
{
    private $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function loadUserByUsername(string $username): UserInterface
    {
        $user = $this->patientRepository->findOneBy(['emailp' => $username]);

        if (!$user) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof Patient) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        return $this->patientRepository->find($user->getId());
    }

    public function supportsClass(string $class): bool
    {
        return Patient::class === $class || is_subclass_of($class, Patient::class);
    }
}
