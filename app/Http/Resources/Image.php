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
            'url_recto' => !empty($this->url_recto) ? 'https://api.jptshienda.cd/public/storage/' . $this->url_recto : null,
            'url_verso' => !empty($this->url_verso) ? 'https://api.jptshienda.cd/public/storage/' . $this->url_verso : null,
            // 'url_recto' => !empty($this->url_recto) ? 'https://jptshienda.dev:1443/storage/' . $this->url_recto : null,
            // 'url_verso' => !empty($this->url_verso) ? 'https://jptshienda.dev:1443/storage/' . $this->url_verso : null,
            'description' => $this->description,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'user_id' => $this->user_id
        ];
    }
}
