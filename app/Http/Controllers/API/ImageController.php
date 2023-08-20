<?php

namespace App\Http\Controllers\API;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Resources\Image as ResourcesImage;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class ImageController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Image::all();

        return $this->handleResponse(ResourcesImage::collection($images), __('notifications.find_all_images_success'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Get inputs
        $inputs = [
            'image_name' => $request->image_name,
            'url_recto' => $request->url_recto,
            'url_verso' => $request->url_verso,
            'description' => $request->description,
            'user_id' => $request->user_id
        ];
		// Select euser image and specific image to check unique constraint
		$another_image = Image::where('user_id', $inputs['user_id'])->first();

        // Validate required fields
        if ($inputs['url_recto'] == null OR $inputs['url_recto'] == ' ') {
            return $this->handleError($inputs['url_recto'], __('validation.required'), 400);
        }

        if ($inputs['user_id'] == null OR $inputs['user_id'] == ' ') {
            return $this->handleError($inputs['user_id'], __('validation.required'), 400);
        }

        if ($another_image != null) {
            $another_image->update($inputs);

            return $this->handleResponse(new ResourcesImage($another_image), __('notifications.update_image_success'));

        } else {
            $image = Image::create($inputs);

            return $this->handleResponse(new ResourcesImage($image), __('notifications.create_image_success'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = Image::find($id);

        if (is_null($image)) {
            return $this->handleError(__('notifications.find_image_404'));
        }

        return $this->handleResponse(new ResourcesImage($image), __('notifications.find_image_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        // Get inputs
        $inputs = [
            'id' => $request->id,
            'image_name' => $request->image_name,
            'url_recto' => $request->url_recto,
            'url_verso' => $request->url_verso,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'updated_at' => now()
        ];

        if ($inputs['url_recto'] == null OR $inputs['url_recto'] == ' ') {
            return $this->handleError($inputs['url_recto'], __('validation.required'), 400);
        }

        if ($inputs['user_id'] == null OR $inputs['user_id'] == ' ') {
            return $this->handleError($inputs['user_id'], __('validation.required'), 400);
        }

        $image->update($inputs);

        return $this->handleResponse(new ResourcesImage($image), __('notifications.update_image_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        $image->delete();

        $images = Image::all();

        return $this->handleResponse(ResourcesImage::collection($images), __('notifications.delete_image_success'));
    }
}
