<?php

namespace App\Validators;

class AddTagToProjectValidator
{
    public function rule()
    {
        return [
            'tags' => 'required'
        ];
    }

    public function message () {
        return [
            'tags.required' => 'Error, You have to choose tags !'
        ];
    }
}