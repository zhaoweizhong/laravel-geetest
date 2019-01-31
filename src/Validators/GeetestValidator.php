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
        Log::info('Geetest Validate Start', ['geetest_challenge' => $geetest_challenge, 'geetest_validate' => $geetest_validate, 'geetest_seccode' => $geetest_seccode, 'user_id' => session()->get('user_id')]);
        if (session()->get('gtserver') == 1) {
            if (Geetest::successValidate($geetest_challenge, $geetest_validate, $geetest_seccode, ['user_id'=>session()->get('user_id')])) {
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
