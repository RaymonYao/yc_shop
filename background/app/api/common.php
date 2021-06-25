<?php
// 这是系统自动生成的公共文件


use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

function getToken($mobile)
{
    $config = Configuration::forSymmetricSigner(
        new Sha256(),
        InMemory::base64Encoded(base64_encode(config('shop.API_KEY')))
    );

    $now = new DateTimeImmutable();
    $token = $config->builder()
        ->issuedBy('http://my.ycshop.local')
        ->identifiedBy('4f1g23a12aa')
        ->issuedAt($now)
        ->expiresAt($now->modify('+1 hour'))
        ->withClaim('mobile', $mobile)
        ->getToken($config->signer(), $config->signingKey());
    return $token->toString();
}


function getMobile($token)
{
    $config = Configuration::forSymmetricSigner(
        new Sha256(),
        InMemory::base64Encoded(base64_encode(config('shop.API_KEY')))
    );
    $token = $config->parser()->parse($token);
    return ['code' => 200, 'mobile' => $token->claims()->get('mobile')];
}

