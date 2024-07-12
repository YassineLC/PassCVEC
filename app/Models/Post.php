<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'pass_cvec_requests';
    protected $fillable = [
        'nom',
        'prenom',
        'ine',
        'email',
        'adresse',
        'is_in_residence',
        'residence',
        'code_postal',
        'ville',
        'numero_chambre',
        'is_sub_to_newsletter',
        'statut'
    ];

    public static function newsletterSubscribers()
    {
        return self::where('is_sub_to_newsletter', true)->pluck('email');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
