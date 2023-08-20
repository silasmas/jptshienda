<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class News extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'news_title' => $this->news_title,
            'news_content' => $this->news_content,
            'photo_url' => $this->photo_url != null ? (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/public/storage/' . $this->photo_url : null,
            // 'photo_url' => $this->photo_url != null ? '/storage/' . $this->photo_url : null,
            'video_url' => $this->video_url,
            'type' => Type::make($this->type),
            'created_at' => timeAgo($this->created_at->format('Y-m-d H:i:s')),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
