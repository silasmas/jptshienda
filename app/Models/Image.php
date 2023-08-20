<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class Image extends Model
{
    use HasFactory;

    protected $fillable = ['image_name', 'url_recto', 'url_verso', 'description', 'updated_at', 'user_id'];

    /**
     * ONE-TO-MANY
     * One user for several images
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
