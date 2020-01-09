<?php

namespace App;

use App\Scopes\LatestScope;
use App\Scopes\SoftDeleteScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'user_id'];

    protected $table = "blog_posts";

    protected $dat = ['created_at', 'updated_at'];

    public function comments()
    {
        return $this->hasMany('App\Comment')->latest();
        // ကြ်န္ေတာ္တို့ Post တစ္ခုမွာရွိတဲ့ comment ေတြကိုအခုလို default အေနနဲ့ထုပ္ထားလို့ရပါတယ္။ သူ့ရဲ့ Comment Model ထဲမွာရွိတဲ့ lates method ကိုေခၚပီးေတာ့ Query Local Scope အေနနဲ့ထုပ္ပါတယ္။
    }

    public function user()
    {
        return $this->belongsTo('App\User'); // User ID က table ထဲမွာပါေနတာမို့ belongsTo ကိူသံုးတာ။
    }

    /* Local Scope Query
        * LocalScope ကိုေၾကညာမယ္ဆိုရင္ေအာက္ကလို ပံုစံမ်ိဳးနဲ့ ေၾကညာနိုင္ပါတယ္။
        * LocalScope ကိုေရးမယ္ဆိုရင္ ကြ်န္ေတာ္တို့ အစဆံုးအေနနဲ့ function name ကို scope နဲ့ စမယ္ အဲ့ရဲ့ေနာက္မွာမ Function name ကိုစမယ္။
   */

    public function scopeLatest(Builder $query) {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }


    public function scopeMostCommented(Builder $query) {
        // withCount ကိုသံုးရင္ ရလာမဲ့ column အသစ္က comments_count
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    /* End Local Scope Query*/



    // Relationship ထဲက foreign key ကိုဖ်တ္ခ်င္တာမို့ boot ဆိုတဲ့ buildIn function ကိုေခၚသံုးတာ။
    public static function boot()
    {
         // ဒါက GlobalScope Example ပဲျဖစ္ပါတယ္။
        static::addGlobalScope(new SoftDeleteScope); // သူကေတာ့ Global Scope ကိုေခၚသံုးထားတာပဲျဖစ္ပါတယ္။ Query ေတြအတြက္ေပါ့။
       
        parent::boot();

        static::updating(function (BlogPost $blogPost) {
            Cache::forget("blog-post-{$blogPost->id}");
        });

        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete(); // comment table ထဲမွာရွိတဲ့ blogPost နဲ့ဆိုင္တဲ့ေကာင္ေတြအားလံုးကိုသြားဖ်တ္တာ။
        });



        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore(); // comment table ထဲမွာရွိတဲ့ေကာင္ေတြေရာျပန္ပီးေတာ့ restore လုပ္ခ်င္လို့ သူ့ကိုသံုးတာ။
        });
    }
}
