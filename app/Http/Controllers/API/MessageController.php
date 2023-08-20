<?php

namespace App\Http\Controllers\API;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Resources\Message as ResourcesMessage;

/**
 * @author Xanders
 * @see https://www.linkedin.com/in/xanders-samoth-b2770737/
 */
class MessageController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesMessage::collection($messages), __('notifications.find_all_messages_success'));
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
            'message_subject' => $request->message_subject,
            'message_content' => $request->message_content,
            'sent_to' => $request->sent_to,
            'answered_for' => $request->answered_for,
            'user_id' => $request->user_id
        ];

        $message = Message::create($inputs);

        return $this->handleResponse(new ResourcesMessage($message), __('notifications.create_message_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = Message::find($id);

        if (is_null($message)) {
            return $this->handleError(__('notifications.find_message_404'));
        }

        return $this->handleResponse(new ResourcesMessage($message), __('notifications.find_message_success'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        // Get inputs
        $inputs = [
            'id' => $request->id,
            'message_subject' => $request->message_subject,
            'message_content' => $request->message_content,
            'sent_to' => $request->sent_to,
            'answered_for' => $request->answered_for,
            'user_id' => $request->user_id,
            'updated_at' => now()
        ];

        $message->update($inputs);

        return $this->handleResponse(new ResourcesMessage($message), __('notifications.update_message_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->delete();

        $messages = Message::orderByDesc('created_at')->get();

        return $this->handleResponse(ResourcesMessage::collection($messages), __('notifications.delete_message_success'));
    }

    // ==================================== CUSTOM METHODS ====================================
    /**
     * Search a message by its content.
     *
     * @param  string $data
     * @return \Illuminate\Http\Response
     */
    public function search($data)
    {
        $messages = Message::where('message_content', $data)->get();

        return $this->handleResponse(ResourcesMessage::collection($messages), __('notifications.find_all_messages_success'));
    }

    /**
     * GET: Display all received messages.
     *
     * @param  $entity
     * @return \Illuminate\Http\Response
     */
    public function inbox($entity)
    {
        $messages = Message::where('sent_to', $entity)->get();

        return $this->handleResponse(ResourcesMessage::collection($messages), __('notifications.find_all_messages_success'));
    }

    /**
     * GET: Display all sent messages.
     *
     * @param  $user_id
     * @return \Illuminate\Http\Response
     */
    public function outbox($user_id)
    {
        $messages = Message::where('user_id', $user_id)->get();

        return $this->handleResponse(ResourcesMessage::collection($messages), __('notifications.find_all_messages_success'));
    }

    /**
     * GET: Display all messages answered for a specific message.
     *
     * @param  $message_id
     * @return \Illuminate\Http\Response
     */
    public function answers($message_id)
    {
        $messages = Message::where('answered_for', $message_id)->get();

        return $this->handleResponse(ResourcesMessage::collection($messages), __('notifications.find_all_messages_success'));
    }
}
