<?php


namespace App\Services;


class TextAreaService
{
    public function stripTags ($string) {
        return strip_tags($string, '<br>');
    }
}