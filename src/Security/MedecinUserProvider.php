<?php
// src/Security/MedecinUserProvider.php
namespace App\Security;

use App\Entity\Medecin;
use App\Repository\MedecinRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class MedecinUserProvider implements UserProviderInterface
{
    private $medecinRepository;

    public function __construct(MedecinRepository $medecinRepository)
    {
        $this->medecinRepository = $medecinRepository;
    }

    public function loadUserByUsername(string $username): UserInterface
    {
        $user = $this->medecinRepository->findOneBy(['email' => $username]);

        if (!$user) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof Medecin) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        return $this->medecinRepository->find($user->getId());
    }

    public function supportsClass(string $class): bool
    {
        return Medecin::class === $class || is_subclass_of($class, Medecin::class);
    }
}
