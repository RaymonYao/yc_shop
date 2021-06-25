<?php
declare (strict_types=1);

namespace app\api\controller;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use think\Request;
use think\facade\Db;


class Login
{


    public function sendCode(Request $request)
    {
        return json(['code' => 200, 'msg' => '发送成功']);
        $mobile = $request->param('mobile');
        $code = rand(1000, 9999);

        //刷接口  ip限制发送次数  5次
        // 1分钟内 只能发一次
        $time = time();
        $ip = $request->ip();
        $data = ['mobile' => $mobile, 'code' => $code, 'ip' => $ip, 'create_time' => $time];

        $res = Db::name('code')->where('mobile', $mobile)->order('id desc')->find();

        if ($res) {

            if ((time() - $res['create_time']) < 60) {

                return json(['code' => 440, 'msg' => '发送失败等会再发']);
            }

        }

        $start_time = $time - 12 * 3600;


        $count = Db::name('code')->where('ip', $ip)
            ->where('create_time', '>', $start_time)
            ->where('create_time', '<', $time)
            ->count();

        if ($count > 3) {
            return json(['code' => 440, 'msg' => 'ip发送次数过多']);
        }


        if ($this->sendAliCode($mobile, $code)) {
            Db::name('code')->insert($data);
            return json(['code' => 200, 'msg' => '发送成功']);

        } else {
            return json(['code' => 440, 'msg' => '发送失败']);
        }

    }

    public function token()
    {
        $token = getToken('15588608866');

        dump($token);
        dump((string)$token);
    }

    /**
     * @param \think\Request $request
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function login(Request $request)
    {
        $mobile = $request->param('mobile');
        $code = $request->param('code');
        $time = time();
        $res = Db::name('code')->where('mobile', $mobile)
            ->where('code', $code)
            ->where('create_time', '>', $time - 3600)
            ->find();
        if (!$res) {
            return json(['code' => 440, 'msg' => '验证码不通过']);
        }
        $user = Db::name('user')->where('mobile', $mobile)->find();
        if ($user) {
            Db::name('user')->where('mobile', $mobile)->update(['login_time' => $time]);
        } else {
            Db::name('user')->insert(['mobile' => $mobile, 'is_frozen' => 1, 'login_time' => $time]);
        }
        $token = getToken($mobile);
        return json(['code' => '200', 'msg' => '登录成功', 'token' => $token]);
    }

    /**
     * @param \think\Request $request
     * @return \think\response\Json
     */
    public function refreshToken(Request $request)
    {
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded(base64_encode(config('shop.API_KEY')))
        );
        $token = $config->parser()->parse($request->header()['token']);
        $mobile = $token->claims()->get('mobile');
        return json(['code' => '200', 'msg' => 'token刷新成功', 'token' => getToken($mobile)]);
    }

    /**
     * @param $mobile
     * @param $code
     * @return bool
     * @throws \AlibabaCloud\Client\Exception\ClientException
     */
    public function sendAliCode($mobile, $code)
    {
        AlibabaCloud::accessKeyClient(config('shop.ALI_APPID'), config('shop.ALI_APPSECRET'))
            ->regionId('cn-hangzhou')
            ->asDefaultClient();
        $code = json_encode(['code' => $code]);
        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'PhoneNumbers' => $mobile,
                        'SignName' => config('shop.ALI_SNAME'),
                        'TemplateCode' => config('shop.ALI_TCODE'),
                        'TemplateParam' => $code,
                    ],
                ])
                ->request();
            $res = $result->toArray();
            if ($res['Message'] == 'OK') {

                return true;
            } else {
                return false;
            }
        } catch (ClientException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        }
    }
}
