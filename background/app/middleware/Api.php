<?php
declare (strict_types=1);

namespace app\middleware;

use DateTimeZone;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;


class Api
{
    /**
     * @param $request
     * @param \Closure $next
     * @return mixed|\think\response\Json
     */
    public function handle($request, \Closure $next)
    {

        $header = $request->header();

        if (!isset($header['token'])) {
            return json(['code' => 440, 'msg' => 'request must with token']);
        }

        $token = $header['token'];

        try {
            $config = Configuration::forSymmetricSigner(
                new Sha256(),
                InMemory::base64Encoded(base64_encode(config('shop.API_KEY')))
            );
            $c1 = new SignedWith(new Sha256(), InMemory::base64Encoded(base64_encode('yaochuang')));
//        $c2 = new StrictValidAt(new SystemClock(new DateTimeZone('Asia/Shanghai')));
            $c3 = new LooseValidAt(new SystemClock(new DateTimeZone('Asia/Shanghai')));
//        $config->setValidationConstraints($c1, $c2, $c3);
            $config->setValidationConstraints($c1, $c3);
            $token = $config->parser()->parse($token);
        } catch (\Exception $e) {
            return json(['code' => 440, 'msg' => 'invalid token']);
        }
        try {
            $constraints = $config->validationConstraints();
            $config->validator()->assert($token, ...$constraints);
        } catch (RequiredConstraintsViolated $e) {
            $token = getToken($token->claims()->get('mobile'));
            return json(['code' => 450, 'msg' => 'token expired', 'token' => $token]);
        }

        return $next($request);

    }
}
