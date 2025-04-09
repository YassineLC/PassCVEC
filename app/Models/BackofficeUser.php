<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackofficeUser extends Model
{
    use HasFactory;

    protected $table = 'backoffice_users';

    protected $fillable = [
        'given_name',
        'surname',
        'email',
        'matricule',
        'function',
        'affiliation',
        'establishment',
        'postal_code',
        'eppn',
        'display_name',
        'cn',
        'unscoped_affiliation',
        'uid',
        'remote_user',
        'role',
        'is_active',
        'last_login_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}