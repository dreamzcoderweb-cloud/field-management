<?php

namespace App\Classes;

use App\Models\Notificaion as Notification;
use App\Models\User;
use App\Models\UserDevice;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class PushHelper
{
    protected $notification;

    public function __construct()
    {
        $this->notification = Firebase::messaging();
    }

    function sendNotificationToUser($userId, $title, $message)
    {
        Notification::create([
            'from_user_id' => $userId,
            'title' => $title,
            'description' => $message,
            'type' => 'user',
            'created_by_id' => $userId
        ]);

        $userToken = UserDevice::where('user_id', $userId)->first();
        if ($userToken) {
            $message = CloudMessage::fromArray([
                'token' => $userToken->token,
                'notification' => [
                    'title' => $title,
                    'body' => $message
                ],
            ]);

            $this->notification->send($message);
        }
    }

    function sendLeadFollowUpReminder($userId, $title, $message, $leadId, $reminderType): bool
    {
        Notification::create([
            'to_user_id' => $userId,
            'title' => $title,
            'description' => $message,
            'type' => 'user',
            'created_by_id' => $userId
        ]);

        $userToken = UserDevice::where('user_id', $userId)
            ->whereNotNull('token')
            ->where('token', '!=', '')
            ->first();

        if (!$userToken) {
            return false;
        }

        $pushMessage = CloudMessage::fromArray([
            'token' => $userToken->token,
            'notification' => [
                'title' => $title,
                'body' => $message
            ],
            'data' => [
                'type' => 'lead_follow_up',
                'lead_id' => (string) $leadId,
                'reminder_type' => (string) $reminderType
            ],
        ]);

        $this->notification->send($pushMessage);

        return true;
    }

    function sendNotificationToAdmin($title, $message)
    {
        Notification::create([
            'title' => $title,
            'description' => $message,
            'type' => 'admin',
            'created_by_id' => 1
        ]);

        $adminUsers = User::where('shift_id', '==', null)->get();

        foreach ($adminUsers as $adminUser) {
            $userToken = UserDevice::where('user_id', $adminUser->id)->first();
            if ($userToken) {
                $message = CloudMessage::fromArray([
                    'token' => $userToken->token,
                    'notification' => [
                        'title' => $title,
                        'body' => $message
                    ],
                ]);

                $this->notification->send($message);
            }
        }
    }

    function sendNotificationForChat($fromUserId, $toUserId, $message)
    {
        $fromUser = User::where('id', $fromUserId)->with('userDevice')->first();
        $toUser = User::where('id', $toUserId)->with('userDevice')->first();

        $title = 'New Message from ' . $fromUser->first_name . ' ' . $fromUser->last_name;

        Notification::create([
            'from_user_id' => $fromUserId,
            'to_user_id' => $toUserId,
            'title' => $title,
            'description' => $message,
            'type' => 'chat',
            'created_by_id' => $fromUserId
        ]);

        if ($toUser) {
            $message = CloudMessage::fromArray([
                'token' => $toUser->userDevice->token,
                'notification' => [
                    'title' => $title,
                    'body' => $message
                ],
            ]);

            $this->notification->send($message);
        }
    }

    function sendNotificationForTeamChat($teamId, $fromUserId, $message, $isExceptUserId = false): void
    {
        $fromUser = User::where('id', $fromUserId)->with('userDevice')->first();
        $title = 'New Message from ' . $fromUser->first_name . ' ' . $fromUser->last_name;

        Notification::create([
            'from_user_id' => $fromUserId,
            'title' => $title,
            'description' => $message,
            'type' => 'chat',
            'created_by_id' => $fromUserId
        ]);

        if ($isExceptUserId) {
            $this->sendNotificationToTeamExceptUserId($teamId, $fromUserId, $title, $message);

        } else {
            $this->sendNotificationToTeam($teamId, $title, $message);
        }

    }

    function sendNotificationToTeam($teamId, $title, $message)
    {
        $tokens = UserDevice::whereHas('user', function ($query) use ($teamId) {
            $query->where('team_id', $teamId);
        })->pluck('token')->toArray();

        $message = CloudMessage::fromArray([
            'tokens' => $tokens,
            'notification' => [
                'title' => $title,
                'body' => $message
            ],
        ]);

        $this->notification->sendMulticast($message, $tokens);
    }

    function sendNotificationToTeamExceptUserId($teamId, $userId, $title, $message)
    {
        $tokens = UserDevice::whereHas('user', function ($query) use ($teamId, $userId) {
            $query->where('team_id', $teamId)->where('id', '!=', $userId);
        })->pluck('token')->toArray();

        $message = CloudMessage::fromArray([
            'tokens' => $tokens,
            'notification' => [
                'title' => $title,
                'body' => $message
            ],
        ]);

        $this->notification->sendMulticast($message, $tokens);
    }

    function sendNotificationToAll($title, $message)
    {
        $tokens = UserDevice::all()->pluck('token')->toArray();
        $message = CloudMessage::fromArray([
            'tokens' => $tokens,
            'notification' => [
                'title' => $title,
                'body' => $message
            ],
        ]);

        $this->notification->sendMulticast($message);
    }

}
