<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\BlogPost' => 'App\Policies\BlogPostPolicy',
    ];

    // Poicies ေတြကို register လုပ္လိုက္တာက သူတို့ရဲ့ name ေတြကို အတိအက် သတ္မွတ္ေပးစရာမလိုေအာင္လို့။

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('contact.secret', function($user) {
            return $user->is_admin;
        });

        // Gate::define('update-post', function($user, $post) {
        //     return $user->id == $post->user_id;
        // });

        // Gate::define('delete-post', function($user, $post) {
        //     return $user->id == $post->user_id;
        // });

        // Gate::define('posts.update', 'App\Policies\BlogPostPolicy@update');
        // Gate::define('posts.delete', 'App\Policies\BlogPostPolicy@delete');

        // Gate::resource('posts', 'App\Policies\BlogPostPolicy'); Policy ကို အေပၚမွာ Register လုပ္လိုက္တာေၾကာင့္ သူ့ကို သံုးစရာမလိုေတာ့ဘူး။

        Gate::before(function($user, $ability) {
            // Before ကိုသံုးတာက က်န္တဲ့ေကာင္ေတြအလုပ္မလုပ္ခင္မွာ သူ့ကိုအရင္ဆံုးလုပ္ေစခ်င္လို့
            if($user->is_admin && in_array($ability, ['update', 'delete'])) {
                return true; 
                // in_array() ထဲမွာေရးထားတဲ့ေကာင္ေတြက admin ကိုလုပ္ခြင့္ေပးတာ။
                // တကယ္လို့သာမပါခဲ့ရင္ အကုန္လုံုးကို လုပ္ခြင့္ေပးတယ္ ပါလာခဲ့ရင္ေတာ့ ပါတဲ့ေကာင္ပဲ လုပ္ခြင့္ေပးတယ္။
                // ဥပမာ delete-post သာမပါခဲ့ရင္ေတာ့ Admin ကို delete ေပးမလုပ္ခိုင္းဘူး။
                // return true ကိုျပန္ခဲ့မယ္ဆိုရင္ အေပၚကေကာင္ေတြကို မလုပ္ေတာ့ပဲနဲ့ False ျပန္ခဲ့မယ္ဆိုရင္ ေတာ့ အေပၚက ေကာင္ေတြကို လုပ္မယ္။
            }
        });
    }
}
