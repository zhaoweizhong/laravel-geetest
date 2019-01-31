<?php

namespace Zhaoweizhong\Geetest\Validators;

use Zhaoweizhong\Geetest\Facades\Geetest;

class GeetestValidator
{

    private static function getHttpcode($url){
        $ch = curl_init();
        $timeout = 3;
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_exec($ch);
        return $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);
    }

    /**
     * 验证规则
     */
    public function validate()
    {
        list($geetest_challenge, $geetest_validate, $geetest_seccode) = array_values(request()->only('geetest_challenge', 'geetest_validate', 'geetest_seccode'));
        if (GeetestValidator::getHttpcode('https://api.geetest.com/register.php') == 403) {
            if (Geetest::successValidate($geetest_challenge, $geetest_validate, $geetest_seccode, ['user_id'=>'mengtu'])) {
                return true;
            }
            return false;
        } else {
            if (Geetest::failValidate($geetest_challenge, $geetest_validate, $geetest_seccode)) {
                return true;
            }
            return false;
        }
    }
}
