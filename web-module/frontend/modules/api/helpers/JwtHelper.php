<?php

namespace frontend\modules\api\helpers;

use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\UnencryptedToken;

class JwtHelper
{
    private static string $key = 'BW4uej9q03HPqnmulK+l[=.3.q><I49PgQ]XIxMy;!EOq*^A.bev+RFa)K~HW4}'; // Change to a strong secret key
    private static Sha256 $signer;

    public static function init()
    {
        self::$signer = new Sha256();
    }

    public static function generateToken($userId, $roles)
    {
        $config = Configuration::forSymmetricSigner(self::$signer, InMemory::plainText(self::$key));
        $now = new DateTimeImmutable();

        return $config->builder()
            ->issuedBy('reparatech') // Issuer
            ->issuedAt($now)           // Token issued at time
            ->expiresAt($now->modify('+1 minute')) // Expiry
            ->withClaim('uid', $userId)
            ->withClaim('roles', $roles)
            ->getToken(self::$signer, InMemory::plainText(self::$key))
            ->toString();
    }

    public static function validateToken($token)
    {
        $config = Configuration::forSymmetricSigner(self::$signer, InMemory::plainText(self::$key));
        $parsedToken = $config->parser()->parse($token);

        if ($parsedToken->isExpired(new DateTimeImmutable())) {
            return 406;
        }

        if ($config->validator()->validate(
                $config->parser()->parse($token),
                new \Lcobucci\JWT\Validation\Constraint\SignedWith(
                    $config->signer(),
                    $config->verificationKey()
                )
            )) {
            return $parsedToken->claims();
        }

        return 401;
    }
}

JwtHelper::init();
