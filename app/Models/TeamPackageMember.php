<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamPackageMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'leader_id',
        'team_package_id',
        'member_id',
    ];
}
