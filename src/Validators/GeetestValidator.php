<?php

namespace Zhaoweizhong\Geetest\Validators;

use Illuminate\Support\Facades\Log;
use Zhaoweizhong\Geetest\Facades\Geetest;

class GeetestValidator
{

    /**
     * 验证规则
     */
    public function validate()
    {
        list($geetest_challenge, $geetest_validate, $geetest_seccode) = array_values(request()->only('geetest_challenge', 'geetest_validate', 'geetest_seccode'));
        Log::info('Geetest Validate Start', ['geetest_challenge' => $geetest_challenge, 'geetest_validate' => $geetest_validate, 'geetest_seccode' => $geetest_seccode]);
        if (session()->get('gtserver') == 1) {
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
