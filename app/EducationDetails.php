<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationDetails extends Model
{
    protected $table = 'educations_details';

    protected $fillable = ['highest_qualification','college_attend','working_as','company','annual_income'];
}
