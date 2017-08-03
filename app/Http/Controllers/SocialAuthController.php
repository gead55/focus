<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SocialAccountService;
use Socialite;
use Google_Client;
use Google_Service_People;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();   
    }   

    public function callback(SocialAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user(),'facebook');

        auth()->login($user);

        return redirect()->to('/home');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();   
    }

    public function callbackToGoogle(SocialAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('google')->user());
        dd($user);
        auth()->login($user);

        return redirect()->to('/home');
    }

    //GITHUB
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback(SocialAccountService $service)
    {

        $user = $service->createOrGetUser(Socialite::driver('github')->user(),'github');

        auth()->login($user);

        return redirect()->to('/home');
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $githubUser
     * @return User
     */
    private function findOrCreateUser($githubUser)
    {
        if ($authUser = User::where('github_id', $githubUser->id)->first()) {
            return $authUser;
        }

        return User::create([
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'github_id' => $githubUser->id,
            'avatar' => $githubUser->avatar
        ]);
    }     
}
