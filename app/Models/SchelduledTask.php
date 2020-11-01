<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchelduledTask extends Model
{
    
    use HasFactory;
    protected $table="scheldules";

    protected $guarded=['id'];
}
