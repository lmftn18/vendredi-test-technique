<?php

namespace App\Helpers;

/**
 * Class AppStatic: custom static helpers for the app.
 *
 * @package App\Helpers
 */
class AppStatic
{
    /**
     * Applies ucfirst, but encoding aware.
     *
     * @param $string
     * @param $encoding - example: 'utf-8'
     *
     * @return string
     */
    static public function mb_ucfirst($string, $encoding='utf-8')
    {
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }
}