<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function createOrGetUser(ProviderUser $providerUser, $provider_name)
    {
        // dd($providerUser);
        $account = SocialAccount::whereProvider($provider_name)
            ->whereProviderUserId($providerUser->getId())
            ->first();
        // dd($account);
        if ($account) {
            return $account->user;
        } else {

            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $provider_name
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => bcrypt($providerUser->getName()),
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;

        }

    }
}