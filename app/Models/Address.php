<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class Address extends Model
{
    use HasFactory;

    protected $fillable = ['address_content', 'address_content_2', 'neighborhood', 'area', 'city', 'updated_at', 'type_id', 'country_id', 'user_id'];

    /**
     * ONE-TO-MANY
     * One type for several addresses
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * ONE-TO-MANY
     * One country for several addresses
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * ONE-TO-MANY
     * One user for several addresses
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
