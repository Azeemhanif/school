<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\LoginResource;
use App\Http\Resources\AttendeLoginResource;
use App\Http\Resources\SkillResource;
use App\Http\Resources\SpeakerResource;
use App\Http\Resources\SponsorResource;
use App\Http\Resources\VerticalResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Validations\SummitValidations;
use App\Traits\{ValidationTrait};
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;
use App\Models\Skill;
use App\Models\Speaker;
use App\Models\Sponsor_Logo;
use App\Models\SponsorLogo;
use App\Models\UserSkill;
use App\Models\UserVertical;
use App\Models\Vertical;
use File;

class UserController extends Controller
{

    public $successStatus = 200;
    use  ValidationTrait;

    public function signup(Request $request)
    {

        try {
            $validatorResult = $this->checkValidations(SummitValidations::validateRegister($request));
            if ($validatorResult) return $validatorResult;

            $user = $this->createOrUpdateUser($request->user(), $request->all());
            $user->token = $user->createToken('API token of ' . $user->name)->plainTextToken;

            return sendResponse(200, $request->has('id') ? 'Updated Successfully' : 'Registration Successfully', new UserResource($user));
        } catch (\Throwable $th) {
            $response = sendResponse(500, $th->getMessage(), (object)[]);
            return $response;
        }
    }


    public function login(Request $request)
    {
        $validatorResult = $this->checkValidations(SummitValidations::validateLogin($request));
        if ($validatorResult) {
            return $validatorResult;
        }

        $input = $request->all();
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $collection = $this->getLoginResourceCollection($user, $input);

            return sendResponse(200, 'Login Successful!', $collection);
        } else {
            return sendResponse(202, 'Invalid email or password!', []);
        }
    }





    public function profileSetup(Request $request)
    {
        try {

            $validatorResult = $this->checkValidations(SummitValidations::validateProfileSetup($request));
            if ($validatorResult) {
                return $validatorResult;
            }
            $user = Auth::user();
            $input = $request->all();

            $user =  User::find($input['user_id']);
            if (isset($input['whatsapp_link']))  $user->whatsapp_link = $input['whatsapp_link'];
            if (isset($input['skype_link']))   $user->skype_link = $input['skype_link'];
            if (isset($input['telegram_link']))    $user->telegram_link = $input['telegram_link'];
            if (isset($input['twitter_link']))     $user->twitter_link = $input['twitter_link'];
            if (isset($input['facebook_link']))    $user->facebook_link = $input['facebook_link'];
            if (isset($input['website_link']))   $user->website_link = $input['website_link'];
            if (isset($input['linkedin_link']))  $user->linkedin_link = $input['linkedin_link'];
            if (isset($input['profile_image']))  $user->avatar = $input['profile_image'];
            $user->save();


            if (isset($input['verticals'])) {
                foreach ($input['verticals'] as $vertical) {

                    $userVertical =  new UserVertical();
                    $userVertical->user_id = $user->id;
                    $userVertical->name = $vertical;
                    $userVertical->save();
                }
            }

            if (isset($input['skills'])) {
                foreach ($input['skills'] as $skill) {
                    $userSkill =  new UserSkill();
                    $userSkill->user_id = $user->id;
                    $userSkill->name = $skill;
                    $userSkill->save();
                }
            }
            $response = new UserResource($user);

            return sendResponse(200, 'Profile setup successful!', $response);
        } catch (\Exception $ex) {
            $response = sendResponse(500, $ex->getMessage(), (object)[]);
            return $response;
        }
    }


    public function socialSignup(Request $request)
    {
        try {
            $validatorResult = $this->checkValidations(SummitValidations::SocialSignup($request));
            if ($validatorResult) {
                return $validatorResult;
            }
            $input = $request->all();

            $string = substr($request->token, 0, 1000);
            if ($input['provider_type'] == 'google') $user = User::where(['google_token' => $string])->first();
            if ($input['provider_type'] == 'facebook') $user = User::where(['fb_token' => $string])->first();
            if (isset($user)) return sendResponse(401, 'There is already an account associated with this email please contact support to resolve this issue.', (object)[]);

            if ($input['provider_type'] == 'google') $data = User::where(['google_token' => $string])->first();
            if ($input['provider_type'] == 'facebook') $data = User::where(['fb_token' => $string])->first();
            if (isset($data)) {
                return sendResponse(422, 'Record Exist In Our System', (object)[]);
            } else {
                if ($input['provider_type'] != 'facebook' && $input['provider_type'] != 'google') {
                    return sendResponse(422, 'Provider Type Does not Exist In Our System', (object)[]);
                }
                if (!empty($request->email)) $data = User::where(['email' => $request->email])->first();

                if (!$data) $data = User::create($input);
                if ($input['provider_type'] == 'google') $data->google_token = $string;
                if ($input['provider_type'] == 'facebook') $data->fb_token = $string;

                $data->save();
                $data->loginFrom = $input['provider_type'];
                $data->token = $data->createToken('API token of ' . $data->name)->plainTextToken;
                $colection = new UserResource($data);
                return sendResponse(200, 'Registration Successful!', $colection);
            }
        } catch (\Exception $ex) {
            $response = sendResponse(500, $ex->getMessage(), (object)[]);
            return $response;
        }
    }


    public function socialLogin(Request $request)
    {
        try {
            $validatorResult = $this->checkValidations(SummitValidations::SocialLogin($request));
            if ($validatorResult) {
                return $validatorResult;
            }
            $string = substr($request->token, 0, 1000);
            $user = User::where(['social_token' => $string])->first();

            if ($user) return sendResponse(401, 'There is already an account associated with this email please contact support to resolve this issue.', (object)[]);

            $input = $request->all();
            if ($input['provider_type'] != 'facebook' && $input['provider_type'] != 'google') {
                return sendResponse(422, 'Provider Type Does not Exist In Our System', (object)[]);
            }

            if ($input['provider_type'] == 'google') $user = User::where(['google_token' => $string])->first();
            if ($input['provider_type'] == 'facebook') $user = User::where(['fb_token' => $string])->first();
            if (isset($input['email']))  $user = User::where(['email' => $input['email']])->first();

            if (!$user) return $response = sendResponse(202, 'No user found', (object)[]);
            if ($input['provider_type'] == 'google') $user->google_token = $string;
            if ($input['provider_type'] == 'facebook') $user->fb_token = $string;

            $user->social_token = $string;
            $user->save();
            $user->loginFrom = $input['provider_type'];
            $user->token = $user->createToken($user->id)->accessToken;

            $collection = new UserResource($user);

            return sendResponse(200, 'Login Successful!', $collection);
        } catch (\Exception $ex) {
            $response = sendResponse(500, $ex->getMessage(), (object)[]);
            return $response;
        }
    }


    public function profileUpdate(Request $request)
    {
        try {
            $validatorResult = $this->checkValidations(SummitValidations::validateProfileSetup($request));
            if ($validatorResult) {
                return $validatorResult;
            }
            $user = Auth::user();
            $input = $request->all();
            $user =  User::find($input['user_id']);
            if (isset($input['whatsapp_link']))  $user->whatsapp_link = $input['whatsapp_link'];
            if (isset($input['skype_link']))   $user->skype_link = $input['skype_link'];
            if (isset($input['telegram_link']))    $user->telegram_link = $input['telegram_link'];
            if (isset($input['twitter_link']))     $user->twitter_link = $input['twitter_link'];
            if (isset($input['facebook_link']))    $user->facebook_link = $input['facebook_link'];
            if (isset($input['website_link']))   $user->website_link = $input['website_link'];
            if (isset($input['linkedin_link']))  $user->linkedin_link = $input['linkedin_link'];
            if (isset($input['profile_image']))  $user->avatar = $input['profile_image'];
            $user->save();


            $userVerticals = UserVertical::where('user_id', $user->id)->get();

            foreach ($userVerticals as $userVertical) {
                $userVertical->delete();
            }


            $userSkills = UserSkill::where('user_id', $user->id)->get();

            foreach ($userSkills as $userSkill) {
                $userSkill->delete();
            }

            if (isset($input['verticals'])) {
                foreach ($input['verticals'] as $vertical) {
                    $userVertical =  new UserVertical();
                    $userVertical->user_id = $user->id;
                    $userVertical->name = $vertical;
                    $userVertical->save();
                }
            }

            if (isset($input['skills'])) {
                foreach ($input['skills'] as $skill) {
                    $userSkill =  new UserSkill();
                    $userSkill->user_id = $user->id;
                    $userSkill->name = $skill;
                    $userSkill->save();
                }
            }

            $response = new UserResource($user);

            return sendResponse(200, 'Profile setup successful!', $response);
        } catch (\Exception $ex) {
            $response = sendResponse(500, $ex->getMessage(), (object)[]);
            return $response;
        }
    }




    public function uploadFile(Request $request)
    {
        try {
            $validatorResult = $this->checkValidations(SummitValidations::validateUploadImage($request));
            if ($validatorResult) {
                return $validatorResult;
            }
            if ($request->hasFile('file')) {
                $folderPath  = 'images/';
                $file = $request->file('file');
                $imageName = rand(1, 50) . '_' . $file->getClientOriginalName();
                $image_path = public_path($folderPath);
                if ($file) {
                    if (!file_exists($image_path))
                        File::makeDirectory($image_path);
                    $file->move($image_path, $imageName);
                    $image_url = $folderPath . $imageName;
                }
                return sendResponse(200, "Files saved successfully", $image_url);
            } else {
                return sendResponse(202, 'No files were uploaded.', (object) []);
            }
        } catch (\Exception $ex) {
            $response = sendResponse(500, $ex->getMessage(), (object) []);
            return $response;
        }
    }
    public function listing(Request $request)
    {
        try {
            $user = User::where('is_favourite', true)->get();
            // $speaker = Speaker::get();
            $res = UserResource::collection($user);
            // $speaker = SpeakerResource::collection($speaker);
            // $res = [
            //     "favourites" => $attendes,
            // ];
            return sendResponse(200, 'Listing fetched successfully!', $res);
        } catch (\Exception $ex) {
            $response = sendResponse(500, $ex->getMessage(), (object)[]);
            return $response;
        }
    }



    public function userFavourite(Request $request, $id)
    {
        try {
            $user = User::where('id', $id)->first();
            if (!$user)
                return sendResponse(202, 'User does not exists!', (object)[]);
            $is_fav = $user->is_favourite;
            if ($user->is_favourite == false) {
                $is_fav = true;
            } else {
                $is_fav = false;
            }
            $user->is_favourite =  $is_fav;
            $user->save();
            $res = new UserResource($user);
            return sendResponse(200, 'Updated successfully!', $res);
        } catch (\Exception $ex) {
            $response = sendResponse(500, $ex->getMessage(), (object)[]);
            return $response;
        }
    }


    public function userDetail(Request $request, $id)
    {
        try {
            $user = User::where('id', $id)->first();
            if (!$user)
                return sendResponse(202, 'User does not exists!', (object)[]);
            $res = new UserResource($user);
            return sendResponse(200, 'Detail fetched successfully!', $res);
        } catch (\Exception $ex) {
            $response = sendResponse(500, $ex->getMessage(), (object)[]);
            return $response;
        }
    }

    public function sponsorDetail(Request $request, $id)
    {
        try {
            $sponsor = SponsorLogo::where(['issponsornow' => true, 'id' => $id])->first();
            if (!$sponsor)
                return sendResponse(202, 'Sponsor does not exists!', (object)[]);
            $result = new SponsorResource($sponsor);
            return sendResponse(200, 'Detail fetched successfully!', $result);
        } catch (\Exception $ex) {
            $response = sendResponse(500, $ex->getMessage(), (object)[]);
            return $response;
        }
    }

    public function speakerDetail(Request $request, $id)
    {
        try {
            $speaker = Speaker::where(['id' => $id])->first();
            if (!$speaker)
                return sendResponse(202, 'Speaker does not exists!', (object)[]);
            $result = new SpeakerResource($speaker);
            return sendResponse(200, 'Detail fetched successfully!', $result);
        } catch (\Exception $ex) {
            $response = sendResponse(500, $ex->getMessage(), (object)[]);
            return $response;
        }
    }


    public function discoverListing(Request $request)
    {
        try {
            $result = [];
            $filterBy = $request->input('filterby', 'all');

            if ($filterBy == 'attendees') {
                $user = User::get();
                $result = UserResource::collection($user);
            }
            if ($filterBy == 'exhibitors_and_sponsors') {
                $sponsors = SponsorLogo::where('issponsornow', true)->get();
                $result = SponsorResource::collection($sponsors);
            }
            if ($filterBy == 'speakers') {
                $speaker = Speaker::get();
                $result = SpeakerResource::collection($speaker);
            }

            return sendResponse(200, 'Listing fetched successfully!', $result);
        } catch (\Exception $ex) {
            $response = sendResponse(500, $ex->getMessage(), (object)[]);
            return $response;
        }
    }



    public function skillsListing(Request $request)
    {
        try {
            $skill = Skill::get();
            $response = SkillResource::collection($skill);
            return sendResponse(200, 'Skills fetching successfully!', $response);
        } catch (\Exception $ex) {
            $response = sendResponse(500, $ex->getMessage(), (object)[]);
            return $response;
        }
    }

    public function verticalsListing(Request $request)
    {
        try {
            $vertical = Vertical::get();
            $response = VerticalResource::collection($vertical);
            return sendResponse(200, 'Verticals fetching successfully!', $response);
        } catch (\Exception $ex) {
            $response = sendResponse(500, $ex->getMessage(), (object)[]);
            return $response;
        }
    }
    public function forget(Request $request)
    {
        // working
        try {

            $validatorResult = $this->checkValidations(SummitValidations::validateForgetPassword($request));
            if ($validatorResult) {
                return $validatorResult;
            }

            $input = $request->all();
            $user = User::where('email', $input['email'])->first();
            $token = Str::random(60);
            $mailData = [
                'token' => $token,
            ];
            // $user['token'] = $token;
            $user['is_verified'] = 0;
            $user->save();
            sendEmailToUser($request->email, new ResetPasswordMail($mailData));

            // Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
            //     $message->to($request->email);
            //     $message->subject('Reset Password');
            // });
            return sendResponse(200, 'We have e-mailed your password reset link!', $input['email']);
        } catch (\Exception $ex) {
            $response = sendResponse(500, $ex->getMessage(), (object)[]);
            return $response;
        }
    }
    private function getLoginResourceCollection($user, array $input)
    {
        $collection = $user->type != 'attendee' ? new UserResource($user) : new AttendeLoginResource($user);
        $collection->token = $user->createToken('API token of ' . $user->name)->plainTextToken;
        return $collection;
    }

    public function updatePassword(Request $request)
    {
        //working
        // try {   
        $validate = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*\d).+$/',
            'confirm_password' => 'required|same:password'
        ], [
            'password.required' => "Password is required",
            'confirm_password.required' => "Confirm password is required",
            'confirm_password.same' => 'Passwords do not match.',
            'password.regex' => "Password must be contain at-least one alphabet or number."
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate->errors())->withInput();
        }
        $input = $request->all();
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user['is_verified'] = 0;
            $user['token'] = '';
            $user['password'] = Hash::make($request->password);
            $user->save();
            // return sendResponse(200, 'Your Password has been changed successfully', null);
            return back()->with('Success', 'Your password has been changed successfully.');
        }
        // return sendResponse(202, 'Failed! something went wrong', null);
        return back()->with('Error', 'User not exists.');

        // } catch (\Exception $ex) {
        //     $response = sendResponse(500, $ex->getMessage(), null);
        //     return $response;
        // }
    }

    public function forgotPasswordValidate($token)
    {
        //working
        try {
            $user = User::where('token', $token)->where('is_verified', 0)->first();
            if ($user) {
                $email = $user->email;
                return view('auth.change-password', compact('email', 'token'));
            }
            $tokenExpired = 'Your forgot password link has been expired. Please try again.';
            return view('auth.change-password', compact('tokenExpired'));
            // return sendResponse(202, 'Password reset link is expired', (object)[]);
        } catch (\Exception $ex) {
            $response = sendResponse(500, $ex->getMessage(), (object)[]);
            return $response;
        }
    }

    private function createOrUpdateUser($user, array $input)
    {
        $userData = [
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
        ];
        if ($user) {
            $user->update($userData);
        } else {
            $user = User::create($userData);
        }

        return $user;
    }
}
