<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CovidDaily extends Model
{
    use HasFactory;

    protected $table = 'covid_dailies';

    protected $fillable = [
        'country',
        'province',
        'date',
        'confirmed',
        'deaths',
        'recovered',
        'active',
        'iso',
        'lat',
        'long',
    ];
}
