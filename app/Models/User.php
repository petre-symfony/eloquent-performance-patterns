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
            collect(str_getcsv($terms, ' ', '"'))->filter()->each(function ($term) use ($query) {
                $term = preg_replace('/[^A-Za-z0-9]/', '', $term).'%';;
                $query->whereIn('id', function ($query) use ($term) {
                    // derived table
                    $query->select('id')
                        ->from(function($query) use ($term) {
                            // find users by first and last name
                            $query->select('id')
                                ->from('users')
                                ->where('first_name_normalized', 'like', $term)
                                ->orWhere('last_name_normalized', 'like', $term)
                                //union
                                ->union(
                                    $query->newQuery()
                                        // find users by company name
                                        ->select('users.id')
                                        ->from('users')
                                        ->join('companies', 'companies.id', '=', 'users.company_id')
                                        ->where('companies.name_normalized', 'like', $term)
                                );
                        }, 'matches');
                });
            });
        }

        if (config('database.default') === 'pgsql') {
            collect(str_getcsv($terms, ' ', '"'))->filter()->each(function ($term) use ($query) {
                $term = preg_replace('/[^A-Za-z0-9]/', '', $term).'%';
                $query->whereIn('id', function ($query) use ($term) {
                    // derived table
                    $query->select('id')
                        ->from(function($query) use ($term) {
                            // find users by first and last name
                            $query->select('id')
                                ->from('users')
                                ->where('first_name_normalized', 'ilike', $term)
                                ->orWhere('last_name_normalized', 'ilike', $term)
                                //union
                                ->union(
                                    $query->newQuery()
                                        // find users by company name
                                        ->select('users.id')
                                        ->from('users')
                                        ->join('companies', 'companies.id', '=', 'users.company_id')
                                        ->where('companies.name_normalized', 'ilike', $term)
                                );
                        }, 'matches');
                });
            });
        }
    }
}
