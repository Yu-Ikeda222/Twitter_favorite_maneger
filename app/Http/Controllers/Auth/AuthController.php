<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Tweet;
use Socialite;

class AuthController extends Controller
{
    public function TwitterRedirect()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function TwitterCallback()
    {
        // OAuthユーザー情報を取得
        $social_user = Socialite::driver('twitter')->user();
        // dd($social_user);
        $user = $this->first_or_create_social_user('twitter', $social_user->id, $social_user->name, $social_user->avatar );

        // Laravel 標準の Auth でログイン
        \Auth::login($user);
        // dd(\Auth::user()->id);
        
        $favorite_list = \Twitter::get('favorites/list', ['user_id' => \Auth::user()->twitter_id, 'count' => 150]);
        // dd($favorite_list[0]->user->screen_name);
        // dd($favorite_list[0]);
       foreach ($favorite_list as $favorite) {
            $exists = Tweet::where('tweet_id', $favorite->id)->exists();
            if (!$exists) {
                Tweet::create(['user_id' => \Auth::user()->id, 'user_screen_name' => $favorite->user->screen_name,'tweet_id' => $favorite->id ]);
            }
                
        }
        // dd($tweet); 'num_favorite' => count($favorite_list->ids)
        return view('index', ['favorite_list' => $favorite_list]);
    }

    /**
     * ログインしたソーシャルアカウントがDBにあるかどうか調べる
     *
     * @param   string      $service_name       ( twitter , facebook ... )
     * @param   int         $social_id          ( 123456789 )
     * @param   string      $social_avatar      ( https://....... )
     *
     * @return  \App\User   $user
     *
     */
    protected function first_or_create_social_user( string $service_name,
                                                int $social_id, string $social_name, string $social_avatar )
    {
        // dd($social_id);
        $user = null;
        $user = \App\User::where( "{$service_name}_id", '=', $social_id )->first();

        $twitter_screen_name =  \Twitter::get('users/show', ['user_id' => $social_id])->screen_name;
        // dd($user);
        if ( $user === null ){
            $user = new \App\User();
            $user->fill( [
                "{$service_name}_id" => $social_id ,
                'name'               => $social_name ,
                'avatar'             => $social_avatar ,
                'twitter_screen_name' => $twitter_screen_name,
                'password'           => 'DUMMY_PASSWORD' ,
            ] );
            $user->save();
            return $user;
        }
        else{
            return $user;
        }
    }

}

