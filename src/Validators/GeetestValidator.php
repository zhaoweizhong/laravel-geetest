<?php

namespace Zhaoweizhong\Geetest\Validators;

use Illuminate\Support\Facades\Log;
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
        Log::info('Geetest Validate Start', ['geetest_challenge' => $geetest_challenge, 'geetest_validate' => $geetest_validate, 'geetest_seccode' => $geetest_seccode]);
        //if (session()->get('gtserver') == 1) {
        if (GeetestValidator::getHttpcode('https://api.geetest.com/register.php') == 403) {
            Log::info('Geetest Validate Start 1');
            if (Geetest::successValidate($geetest_challenge, $geetest_validate, $geetest_seccode, ['user_id'=>'mengtu'])) {
                Log::info('Geetest Validate Start 2');
                return true;
            }
            Log::info('Geetest Validate Start 3');
            return false;
        } else {
            Log::info('Geetest Validate Start 4');
            if (Geetest::failValidate($geetest_challenge, $geetest_validate, $geetest_seccode)) {
                Log::info('Geetest Validate Start 5');
                return true;
            }
            Log::info('Geetest Validate Start 6');
            return false;
        }
    }
}
