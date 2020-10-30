<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\HelperHealthSignIn;
use common\models\User;
use yii\console\ExitCode;

use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Sms\V20190711\SmsClient;
use TencentCloud\Sms\V20190711\Models\SendSmsRequest;

/**
 * Web助手
 * 用以配合定时任务
 */
class HelperController extends Controller
{
    /**
     * 健康打卡
     */
    public function actionHealthSignIn($timeType)
    {
        $where = [
            'status' => HelperHealthSignIn::STATUS_NO,
            'is_open' => HelperHealthSignIn::IS_OPEN_YES,
        ];

        if ($timeType != HelperHealthSignIn::TIME_NINE_FORTY) {
            $where['remind_time'] = $timeType;
        }

        //邮件提醒
        $list = HelperHealthSignIn::find()->where($where)->asArray()->all(); //获取未打卡且开启服务的用户打卡信息列表

        if (empty($list)) {
            return ExitCode::OK;
        }
        $phoneNumberSet = [];//要发送的短信列表
        $tokenSet = [];
        $nameSet = [];

        foreach ($list as $healthSignInInfo) {
            $user = User::findOne($healthSignInInfo['user_id']);

            if ($healthSignInInfo['remind_type'] == HelperHealthSignIn::TYPE_EMAIL || $healthSignInInfo['remind_type'] == HelperHealthSignIn::TYPE_ALL || $timeType == HelperHealthSignIn::TIME_NINE_FORTY) {
                if (HelperHealthSignIn::sendEmail($user, $healthSignInInfo['callback_token'])) { //开始发送邮件
                    Yii::info($user->real_name . '(' . $user->username . ')' . '邮件健康打卡提醒成功！');
                } else {
                    Yii::error($user->real_name . '(' . $user->username . ')' . '邮件健康打卡提醒失败！');
                }
            }

            if ($healthSignInInfo['remind_type'] == HelperHealthSignIn::TYPE_MESSAGE || $healthSignInInfo['remind_type'] == HelperHealthSignIn::TYPE_ALL  || $timeType == HelperHealthSignIn::TIME_NINE_FORTY) {
                if (!empty($user->phone)) {
                    $phoneNumberSet[] = '+86' . $user->phone;
                    $tokenSet[] = $healthSignInInfo['callback_token'];
                    $nameSet[] = empty($user->real_name) ? $user->username : $user->real_name;
                }
            }
        }

        if (!empty($phoneNumberSet)) {
            //短信提醒
            try {
                $cred = new Credential(Yii::$app->params['tencentcloud']['SecretId'], Yii::$app->params['tencentcloud']['SecretKey']);
                $httpProfile = new HttpProfile();
                $httpProfile->setEndpoint("sms.tencentcloudapi.com");

                $clientProfile = new ClientProfile();
                $clientProfile->setHttpProfile($httpProfile);
                $client = new SmsClient($cred, "", $clientProfile);

                $req = new SendSmsRequest();

                foreach ($phoneNumberSet as $key => $phone) {
                    $phones = array();
                    $phones[] = $phone;
                    $TemplateParamSet = array();
                    $TemplateParamSet[] = $nameSet[$key];
                    $TemplateParamSet[] = $tokenSet[$key];

                    $params = array(
                        "PhoneNumberSet" => $phones,
                        "TemplateID" => Yii::$app->params['tencentcloud']['sms']['TemplateID'],
                        "SmsSdkAppid" => Yii::$app->params['tencentcloud']['sms']['SmsSdkAppid'],
                        "Sign" => Yii::$app->params['tencentcloud']['sms']['Sign'],
                        'TemplateParamSet' => $TemplateParamSet,
                    );

                    $req->fromJsonString(json_encode($params));

                    $resp = $client->SendSms($req);

                    $code = $resp->SendStatusSet[0]->Code;

                    if ($code != 'Ok') {
                        Yii::error("短信发送失败！" . $nameSet[$key]);
                    }
                }
            }
            catch(TencentCloudSDKException $e) {
                Yii::error("短信发送失败：" . $e);
            }

        }

        return ExitCode::OK;
    }

    /**
     * 进行一些打卡初始化的工作
     * 这应该在正式打卡提醒之前不久
     */
    public function actionHealthSignInInit()
    {
        $healthSignIns = HelperHealthSignIn::find()->where([
            'is_open' => HelperHealthSignIn::IS_OPEN_YES,
        ])->all();

        foreach ($healthSignIns as $healthSignIn) {
            $healthSignIn->status = HelperHealthSignIn::STATUS_NO;
            $healthSignIn->callback_token = Yii::$app->getSecurity()->generateRandomString(HelperHealthSignIn::CALLBACK_TOKEN_LENGTH);
            if (!$healthSignIn->save()) {
                Yii::error("打卡初始化失败！");
            }
        }

        return ExitCode::OK;
    }
}
