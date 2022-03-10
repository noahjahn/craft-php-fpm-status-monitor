<?php

namespace noahjahn\phpfpmstatusmonitor\models;

use craft\base\Model;

class Settings extends Model
{
    public $path = 'fpm-status';

    public function rules()
    {
        return [
            [['path'], 'required'],
        ];
    }
}
