<?php

namespace App\Models;

use Carbon\Carbon;
use Filament\Models\Concerns\IsFilamentUser;
use Filament\Models\Concerns\SendsFilamentPasswordResetNotification;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property ?Carbon $email_verified_at
 * @property string $password
 * @property ?string $two_factor_secret
 * @property ?string $two_factor_recovery_codes
 * @property ?string $remember_token
 * @property ?int $current_team_id
 * @property ?string $profile_photo_path
 * @property bool $admin
 * @property ?array $filament_roles
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property ?string $preferred_locale
 */
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use IsFilamentUser;
    use SendsFilamentPasswordResetNotification;

    public static string $filamentUserColumn = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'admin',
        'preferred_locale',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'admin' => 'boolean',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function isFilamentAdmin(): bool
    {
        return $this->admin;
    }
}
