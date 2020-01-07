<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class LatestScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        //$builder->orderBy('created_at', 'desc'); // အခုလိုေရးမယ္ဆိုရင္ ကြ်န္ေတာ္တို့ Model တစ္ခုတည္းအတြက္ပဲ သံုးလို့ရမွာ
        //သူ့ကို တစ္ျခား Model ေတြကပါေခၚသံုးလို့ရေအာင္ ေအာက္ကလို ေရးနိုင္ပါတယ္။

        $builder->orderBy($model::CREATED_AT, 'desc');
    }
}
