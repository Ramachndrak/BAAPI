<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReligionBackground extends Model
{
    protected $table = 'religions_background';

    protected $fillable = ['religion_id','community_id','sub_community_id','gotram','mother_tongue_id','city_of_birth','rashi'];
}
