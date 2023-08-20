<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['offer_name', 'amount', 'currency', 'updated_at', 'type_id', 'user_id'];

    /**
     * ONE-TO-MANY
     * One type for several offers
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * ONE-TO-MANY
     * One user for several offers
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
