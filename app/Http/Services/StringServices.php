<?php

namespace App\Http\Services;

class StringServices
{
    public function twoCodeFormat(int $code)
    {
        if ($code < 10) {
            $code = '0'.$code;
        } 
        return $code;
    }

    public function threeCodeFormat(int $code)
    {
        if ($code < 10) {
            $code = '00'.$code;
        } 
        else if ($code < 100) {
            $code = '0'.$code;
        }

        return $code;
    }

    public function fourCodeFormat(int $code)
    {
        if ($code < 10) {
            $code = '000'.$code;
        } 
        else if ($code < 100) {
            $code = '00'.$code;
        }
        else if ($code < 1000) {
            $code = '0'.$code;
        }

        return $code;
    }

    public function fiveCodeFormat(int $code)
    {
        if ($code < 10) {
            $code = '0000'.$code;
        } 
        else if ($code < 100) {
            $code = '000'.$code;
        }
        else if ($code < 1000) {
            $code = '00'.$code;
        }
        else if ($code < 10000) {
            $code = '0'.$code;
        }

        return $code;
    }
}
