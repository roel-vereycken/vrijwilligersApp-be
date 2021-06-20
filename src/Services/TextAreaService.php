<?php


namespace App\Services;


class TextAreaService
{
    public function stripTags ($string) {
        return strip_tags($string, '<h1><em><strong><blockquote><ul><li><del><a><ol><br>');
        //return strtoupper($string);
    }
}