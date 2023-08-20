<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Laravel\Scout\Searchable;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class Message extends Model
{
    use HasFactory/*, Searchable*/;

    // const SEARCHABLE_FIELDS = ['message_content'];

    protected $fillable = ['message_subject', 'message_content', 'sent_to', 'answered_for', 'updated_at', 'user_id'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    // public function toSearchableArray()
    // {
    //     return $this->only(self::SEARCHABLE_FIELDS);
    // }

    /**
     * ONE-TO-MANY
     * One user for several messages
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
