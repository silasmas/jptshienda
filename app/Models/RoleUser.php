<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class RoleUser extends Model
{
    use HasFactory;

    protected $fillable = ['role_id', 'user_id', 'updated_at'];

    /**
     * ONE-TO-MANY
     * One role for several role_users
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * ONE-TO-MANY
     * One user for several role_users
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
