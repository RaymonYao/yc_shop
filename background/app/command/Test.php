<?php
declare (strict_types=1);

namespace app\command;

use DateTimeImmutable;
use DateTimeZone;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;
use RuntimeException;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class Test extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('test')
            ->setDescription('this is my test');
    }

    /**
     * @param \think\console\Input $input
     * @param \think\console\Output $output
     * @return int|void|null
     */
    protected function execute(Input $input, Output $output)
    {
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded(base64_encode('yaochuang'))
        );
        $c1 = new SignedWith(new Sha256(), InMemory::base64Encoded(base64_encode('yaochuang')));
//        $c2 = new StrictValidAt(new SystemClock(new DateTimeZone('Asia/Shanghai')));
        $c3 = new LooseValidAt(new SystemClock(new DateTimeZone('Asia/Shanghai')));
//        $config->setValidationConstraints($c1, $c2, $c3);
        $config->setValidationConstraints($c1,$c3);

//        $mobile = '13162691809';
//        $now = new DateTimeImmutable();
//        $token = $config->builder()
//            ->issuedBy('http://my.ycshop.local')
//            ->identifiedBy('4f1g23a12aa')
//            ->issuedAt($now)
//            ->expiresAt($now->modify('+1 minutes'))
//            ->withClaim('mobile', $mobile)
//            ->getToken($config->signer(), $config->signingKey());
//        echo $token->toString();die;


        $token = $config->parser()->parse('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbXkueWNzaG9wLmxvY2FsIiwianRpIjoiNGYxZzIzYTEyYWEiLCJpYXQiOjE2MjA3OTYxNDAuNTY2MTQ4LCJleHAiOjE2MjA3OTk3NDAuNTY2MTQ4LCJtb2JpbGUiOiIxMzE2MjY5MTgwOSJ9.EFUJoCjk0YubSudunWlS7sKtl9dDfDOxqsSrZzV91FE');
        assert($token instanceof UnencryptedToken);
        $constraints = $config->validationConstraints();

        try {
            $config->validator()->assert($token, ...$constraints);
        } catch (RequiredConstraintsViolated $e) {
            dd($e->violations());
        }
    }
}
