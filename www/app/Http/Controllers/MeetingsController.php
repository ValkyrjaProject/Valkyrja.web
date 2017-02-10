<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MeetingsController extends Controller
{
    private $relative_meetings_folder = '../../meetings/';
    public function index($channelID, $meetingName) {
        $folder_dir = $this->meetingDirectory($channelID, $meetingName).'*.md';
        $files = array_map('basename', glob($folder_dir), [".md"]);
        return view('meetings.index', ['meetings' => $files]);
    }

    public function getMeeting($channelID, $meetingName, Request $request) {
        $date = $this->whitelistCharacters($request->get('date'));
        $file_dir = $this->meetingDirectory($channelID, $meetingName).$date.".md";
        if (!file_exists($file_dir)) {
            return redirect()->action("MeetingsController@index", [$channelID, $meetingName])->with("messages", ["Meeting doesn't exist!"]);
        }
        $file = strip_tags(file_get_contents($file_dir));
        $markdown = markdown($file);
        return view('meetings.meeting', ['filename' => $date, 'markdown' => $markdown]);
    }

    private function whitelistCharacters($string) {
        $string = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $string);
        $string = mb_ereg_replace("([\.]{2,})", '', $string);
        return $string;
    }

    private function meetingDirectory($channelID, $meetingName) {
        $meetingName = $this->whitelistCharacters($meetingName);
        $channelID = (int)$channelID;
        return $this->relative_meetings_folder.$channelID.'/'.$meetingName.'/';
    }
}
