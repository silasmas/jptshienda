<?php

namespace App\Http\Controllers\API;

use App\Models\News;
use App\Models\Notification;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Status;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\News as ResourcesNews;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class NewsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesNews::collection($news), __('notifications.find_all_news_success'));
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
            'news_title' => $request->news_title,
            'news_content' => $request->news_content,
            'video_url' => $request->video_url,
            'type_id' => $request->type_id
        ];

        $validator = Validator::make($inputs, [
            'news_title' => ['required'],
            'type_id' => ['required']
        ]);

        if ($validator->fails()) {
            return $this->handleError($validator->errors());       
        }

        $news = News::create($inputs);

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        $status_unread = Status::where('status_name', 'Non lue')->first();
        $news_type = Type::find($inputs['type_id']);

        $supporting_member_role = Role::where('role_name', 'Membre Sympathisant')->first();
        $effecive_member_role = Role::where('role_name', 'Membre Effectif')->first();
        $honorary_member_role = Role::where('role_name', 'Membre d\'Honneur')->first();
        $founder_signatory_role = Role::where('role_name', 'Fondateur Signataire de Statuts')->first();
        $founder_initiator_role = Role::where('role_name', 'Fondateur Initiateur')->first();
        $role_users = RoleUser::where('role_id', $supporting_member_role->id)->orWhere('role_id', $effecive_member_role->id)->orWhere('role_id', $honorary_member_role->id)->orWhere('role_id', $founder_signatory_role->id)->orWhere('role_id', $founder_initiator_role->id)->get();

        foreach ($role_users as $member):
            Notification::create([
                'notification_url' => 'works/' . $news->id,
                'notification_content' => __('notifications.party_published') . ' ' . ($news_type->type_name == 'Actualité' ? __('miscellaneous.a_feminine') : __('miscellaneous.a_masculine')) . ' ' . strtolower($news_type->type_name),
                'status_id' => $status_unread->id,
                'user_id' => $member->user_id,
            ]);
        endforeach;

        return $this->handleResponse(new ResourcesNews($news), __('notifications.create_news_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::find($id);

        if (is_null($news)) {
            return $this->handleError(__('notifications.find_news_404'));
        }

        return $this->handleResponse(new ResourcesNews($news), __('notifications.find_news_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        // Get inputs
        $inputs = [
            'id' => $request->id,
            'news_title' => $request->news_title,
            'news_content' => $request->news_content,
            'video_url' => $request->video_url,
            'type_id' => $request->type_id,
            'updated_at' => now()
        ];

        $validator = Validator::make($inputs, [
            'news_title' => ['required'],
            'type_id' => ['required']
        ]);

        if ($validator->fails()) {
            return $this->handleError($validator->errors());       
        }

        if ($inputs['news_title'] != null) {
            $news->update([
                'news_title' => $request->news_title,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['news_content'] != null) {
            $news->update([
                'news_content' => $request->news_content,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['video_url'] != null) {
            $news->update([
                'video_url' => $request->video_url,
                'updated_at' => now(),
            ]);
        }

        if ($inputs['type_id'] != null) {
            $news->update([
                'type_id' => $request->type_id,
                'updated_at' => now(),
            ]);
        }

        /*
            HISTORY AND/OR NOTIFICATION MANAGEMENT
        */
        $status_unread = Status::where('status_name', 'Non lue')->first();
        $news_type = Type::find($inputs['type_id']);

        $supporting_member_role = Role::where('role_name', 'Membre Sympathisant')->first();
        $effecive_member_role = Role::where('role_name', 'Membre Effectif')->first();
        $honorary_member_role = Role::where('role_name', 'Membre d\'Honneur')->first();
        $founder_signatory_role = Role::where('role_name', 'Fondateur Signataire de Statuts')->first();
        $founder_initiator_role = Role::where('role_name', 'Fondateur Initiateur')->first();
        $role_users = RoleUser::where('role_id', $supporting_member_role->id)->orWhere('role_id', $effecive_member_role->id)->orWhere('role_id', $honorary_member_role->id)->orWhere('role_id', $founder_signatory_role->id)->orWhere('role_id', $founder_initiator_role->id)->get();

        foreach ($role_users as $member):
            Notification::create([
                'notification_url' => 'works/' . $news->id,
                'notification_content' => __('notifications.party_changed') . ' ' . ($news_type->type_name == 'Actualité' ? __('miscellaneous.a_feminine') : __('miscellaneous.a_masculine')) . ' ' . strtolower($news_type->type_name),
                'status_id' => $status_unread->id,
                'user_id' => $member->user_id,
            ]);
        endforeach;

        return $this->handleResponse(new ResourcesNews($news), __('notifications.update_news_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        $news->delete();

        $news = News::all();

        return $this->handleResponse(ResourcesNews::collection($news), __('notifications.delete_news_success'));
    }

    // ==================================== CUSTOM METHODS ====================================
    /**
     * Select all news of same type.
     *
     * @param  $type_id
     * @return \Illuminate\Http\Response
     */
    public function selectByType($type_id)
    {
        $news = News::where('type_id', $type_id)->orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesNews::collection($news), __('notifications.find_all_news_success'));
    }

    /**
     * Select all news that hasn't type.
     *
     * @param  $type_id
     * @return \Illuminate\Http\Response
     */
    public function selectByNotType($type_id)
    {
        $news = News::whereNot('type_id', $type_id)->orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesNews::collection($news), __('notifications.find_all_news_success'));
    }

    /**
     * Add news image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function addImage(Request $request, $id)
    {
        $inputs = [
            'news_id' => $request->news_id, 
            'image_64' => $request->image_64
        ];
        // $extension = explode('/', explode(':', substr($inputs['image_64'], 0, strpos($inputs['image_64'], ';')))[1])[1];
        $replace = substr($inputs['image_64'], 0, strpos($inputs['image_64'], ',') + 1);
        // Find substring from replace here eg: data:image/png;base64,
        $image = str_replace($replace, '', $inputs['image_64']);
        $image = str_replace(' ', '+', $image);

        // Clean "[news_id]" directory
        $file = new Filesystem;
        $file->cleanDirectory($_SERVER['DOCUMENT_ROOT'] . '/public/storage/images/news/' . $inputs['news_id']);
        // $file->cleanDirectory($_SERVER['DOCUMENT_ROOT'] . '/storage/images/news/' . $inputs['news_id']);
        // Create image URL
        $image_url = 'images/news/' . $inputs['news_id'] . '/' . Str::random(50) . '.png';

        // Upload image
        Storage::url(Storage::disk('public')->put($image_url, base64_decode($image)));

		$news = News::find($id);

        $news->update([
            'photo_url' => $image_url,
            'updated_at' => now()
        ]);

        return $this->handleResponse(new ResourcesNews($news), __('notifications.update_news_success'));
    }
}
