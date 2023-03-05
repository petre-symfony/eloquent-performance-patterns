<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function posts() {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function logins(){
        return $this->hasMany(Login::class);
    }

    public function lastLogin(){
        return $this->belongsTo(Login::class);
    }

    public function scopeWithLastLogin($query) {
        $query->addSelect(['last_login_id' =>
            Login::select('id')
                ->whereColumn('user_id', 'users.id')
                ->latest()
                ->take(1)
        ])->with('lastLogin');
    }

    public function scopeSearch($query, string $terms = null){
        if (config('database.default') === 'mysql' || config('database.default') === 'sqlite') {
            $query->join('companies', 'companies.id', '=', 'users.company_id');
            collect(str_getcsv($terms, ' ', '"'))->filter()->each(function ($term) use ($query) {
                $term = $term . '%';
                $query->where(function ($query) use ($term) {
                    $query->where('first_name', 'like', $term)
                        ->orWhere('last_name', 'like', $term)
                        ->orWhere('companies.name', 'like', $term);
                });
            });
        }

        if (config('database.default') === 'pgsql') {
            $query->join('companies', 'companies.id', '=', 'users.company_id');
            collect(str_getcsv($terms, ' ', '"'))->filter()->each(function ($term) use ($query) {
                $term = $term.'%';
                $query->where(function ($query) use ($term) {
                    $query->where('first_name', 'ilike', $term)
                        ->orWhere('last_name', 'ilike', $term)
                        ->orWhere('companies.name', 'ilike', $term);
                });
            });
        }
    }
}
