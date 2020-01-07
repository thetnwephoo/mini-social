<?php

namespace App;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Comment extends Model
{
    use SoftDeletes;
    // function name က သူ့ရဲ့ foreign key နဲ့သြားပီးေတာ့ညီမွရမယ္ အဲ့ဒါမွ laravelက သူ့ရဲ့ id ကိုသြားပီးေတာ့ရွာေပးမွာ
    public function blog_post()
    {
        return $this->belongsTo('App\BlogPost', 'blog_post_id');
        // အဲ့လိုမွမဟုတ္ရင္ belongsTo ရဲ့ေနာက္မွာငါ တို့ migration ထဲမွာ သူ့ကို သြးပီးေတာ့ေပးမွရမယ္။ ဥပမာ ေအာက္ကိုတစ္ခ်က္ၾကည့္ပါ
        // return $this->belongsTo('App\BlogPost', 'blog_post_id');
    }

    // LocalScope ကိုေၾကညာမယ္ဆိုရင္ေအာက္ကလို ပံုစံမ်ိဳးနဲ့ ေၾကညာနိုင္ပါတယ္။
    // LocalScope ကိုေရးမယ္ဆိုရင္ ကြ်န္ေတာ္တို့ အစဆံုးအေနနဲ့ function name ကို scope နဲ့ စမယ္ အဲ့ရဲ့ေနာက္မွာမ Function name ကိုစမယ္။

    public function scopeLatest(Builder $query) {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    // Tables ႏွစ္ခုလံုးထဲမွာရွိတဲ့ datas ေတြကိုျဖတ္ခ်င္တယ္ဆိုရင္ေတာ့ forecDelete ကိုသံုးပီးေတာ့ျဖတ္လို့ရတယ္။

    public static function boot()
    {
        parent::boot();

        // static::addGlobalScope(new LatestScope);
    }
}
