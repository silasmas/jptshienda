<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Laravel\Scout\Searchable;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class News extends Model
{
    use HasFactory/*, Searchable*/;

    // const SEARCHABLE_FIELDS = ['news_title', 'news_content'];

    protected $fillable = ['news_title', 'news_content', 'photo_url', 'video_url', 'updated_at', 'type_id'];

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
     * One type for several news
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
