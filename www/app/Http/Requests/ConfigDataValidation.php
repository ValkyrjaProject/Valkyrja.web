<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigDataValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'CommandCharacter'                  => 'required|min:1|max:1',
            'ExecuteCommandsOnEditedMessages'   => 'boolean',
            'RemoveDiscordInvites'              => 'boolean',
            'RemoveMassMentions'                => 'required|integer',
            'SpambotBanLimit'                   => 'required|integer',
            'KarmaEnabled'                      => 'boolean',
            'KarmaLimitMentions'                => 'required|integer',
            'KarmaLimitMinutes'                 => 'required|integer',
            'KarmaLimitResponse'                => 'boolean',
            'KarmaCurrency'                     => 'required|max:32|alpha',
            'KarmaCurrencySingular'             => 'required|max:32|alpha',
            'KarmaConsumeCommand'               => 'required|max:32|alpha',
            'KarmaConsumeVerb'                  => 'required|max:32|alpha',
            'ModChannel'                        => 'required|integer',
            'ModChannelMention'                 => 'boolean',
            'ModChannelLogBans'                 => 'boolean',
            'ModChannelLogDeletedMessages'      => 'boolean',
            'ModChannelIgnore'                  => 'numeric',
            'UserActivityChannel'               => 'integer',
            'UserActivityMention'               => 'boolean',
            'UserActivityLogJoined'             => 'boolean',
            'UserActivityLogLeft'               => 'boolean',
            'UserActivityMessageJoined'         => 'required|max:128|alpha',
            'UserActivityMessageLeft'           => 'required|max:128|alpha',
            'WelcomeMessageEnabled'             => 'boolean',
            'WelcomeMessage'                    => 'required|max:128|alpha',
            'WelcomeRoleID'                     => 'required|integer',
            'RoleIDsAdmin'                      => 'numeric',
            'RoleIDsModerator'                  => 'numeric',
            'RoleIDsMember'                     => 'numeric',
            'PublicRoleIDs'                     => 'numeric'
        ];
    }
}
