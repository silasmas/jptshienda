<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class Image extends JsonResource
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
            'image_name' => $this->image_name,
            'url_recto' => $this->url_recto != null ? (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/public/storage/' . $this->url_recto : null,
            'url_verso' => $this->url_verso != null ? (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/public/storage/' . $this->url_verso : null,
            // 'url_recto' => $this->url_recto != null ? '/storage/' . $this->url_recto : null,
            // 'url_verso' => $this->url_verso != null ? '/storage/' . $this->url_verso : null,
            'description' => $this->description,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'user_id' => $this->user_id
        ];
    }
}
