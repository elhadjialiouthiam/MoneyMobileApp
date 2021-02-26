<?php
namespace App\Services;

class UtilsHelper
{

    public function generateCode()
    {
        return substr(md5(time()), 0, 10);
    }

}