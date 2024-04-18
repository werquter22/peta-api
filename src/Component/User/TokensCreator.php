<?php

declare(strict_types=1);

namespace App\Component\User;

use App\Component\User\Dtos\TokensDto;
use App\Entity\User;
use DateInterval;
use DateTime;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Component\HttpKernel\KernelInterface;

class TokensCreator
{
    public function __construct(private JWTEncoderInterface $tokenEncoder, private KernelInterface $kernel)
    {
    }

    /**
     * @param User $user
     * @return TokensDto
     * @throws JWTEncodeFailureException
     */
    public function create(User $user): TokensDto
    {
        return new TokensDto($this->generateAccessToken($user), $this->generateRefreshToken($user->getId()));
    }

    /**
     * @param User $user
     * @return string
     * @throws JWTEncodeFailureException
     * @throws Exception
     */
    private function generateAccessToken(User $user): string
    {
        $expInterval = new DateInterval($this->getEnv('tokens_creator.access_expiration_period'));

        return $this->tokenEncoder->encode(
            [
                'iat' => (new DateTime())->getTimestamp(),
                'exp' => (new DateTime())->add($expInterval)->getTimestamp(),
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'roles' => $user->getRoles(),
            ]
        );
    }

    private function getEnv(string $envName): string
    {
        return $this->kernel->getContainer()->getParameter($envName);
    }

    /**
     * @param int $userId
     * @return string
     * @throws JWTEncodeFailureException
     * @throws Exception
     */
    private function generateRefreshToken(int $userId): string
    {
        $expInterval = new DateInterval($this->getEnv('tokens_creator.refresh_expiration_period'));

        return $this->tokenEncoder->encode(
            [
                'id' => $userId,
                'iat' => (new DateTime())->getTimestamp(),
                'exp' => (new DateTime())->add($expInterval)->getTimestamp(),
            ]
        );
    }
}
