<?php

namespace App\Validations;

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Validator;

class SummitValidations
{
    public static function validateRegister($request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:30',
                'email' => 'required|unique:users,email,' . $request->id,
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
            ],
            [
                'password.required' => "Password is required",
                'confirm_password.required' => "Confirm password is required",
                'confirm_password.same' => 'Passwords do not match',
            ]
        )->stopOnFirstFailure(true);

        if ($validator->fails()) {
            return $validator;
        }
    }


    public static function validateForgetPassword($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|exists:users,email',
            ],
            [
                'email.exists' => 'The email address is incorrect.',
            ],
        );
        if ($validator->fails()) {
            return $validator;
        }
    }
    public static function validateLogin($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|exists:users,email',
                'password' => 'required',
            ],

            [
                'email.exists' => 'The email does not exists',
            ]
        )->stopOnFirstFailure(true);
        if ($validator->fails()) {
            return $validator;
        }
    }

    public static function SocialSignup($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'provider_type' => 'required',
                'token' => 'required'
            ],
            [
                'provider_type.required' => 'Provider Type is required!',
                'token.required' => 'Token is required!',
            ]
        );
        if ($validator->fails()) {
            return $validator;
        }
    }

    public static function SocialLogin($request)
    {
        $validator = Validator::make($request->all(), [
            'provider_type' => 'required',
            'token' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator;
        }
    }
    public static function validateUploadImage($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'file' => 'required',
            ]
        )->stopOnFirstFailure(true);
        if ($validator->fails()) {
            return $validator;
        }
    }

    public static function validateProfileSetup($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'description' => 'required',
                'whatsapp_link' => 'required',
                'skype_link' => 'required',
                'linkedin_link' => 'required',
                'instagram_link' => 'required',
                'telegram_link' => 'required',
                'twitter_link' => 'required',
                'website_link' => 'required',
            ]
        )->stopOnFirstFailure(true);
        if ($validator->fails()) {
            return $validator;
        }
    }
}
