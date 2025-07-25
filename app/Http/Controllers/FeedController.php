<?php

namespace App\Http\Controllers;

use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use App\CalendarEvent;
use App\Group;
use App\Discussion;

/**
 * This controller generates global public rss feeds for discussions and events.
 */
class FeedController extends Controller
{
    public function discussions()
    {
        $feed = new Feed();

        $channel = new Channel();
        $channel
            ->title(setting('name') . ' : ' . trans('messages.latest_discussions'))
            ->description(setting('name'))
            ->ttl(60)
            ->appendTo($feed);

        $discussions = Discussion::with('group')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->whereIn('group_id', Group::public()->pluck('id'))
            ->take(50)->get();

        foreach ($discussions as $discussion) {
            $item = new \Suin\RSSWriter\Item();
            $item
                ->title($discussion->name)
                ->description($discussion->body)
                ->contentEncoded($discussion->body)
                ->url(route('groups.discussions.show', [$discussion->group, $discussion]))
                ->author($discussion->user->name)
                ->pubDate($discussion->created_at->timestamp)
                ->guid(route('groups.discussions.show', [$discussion->group, $discussion]), true)
                ->preferCdata(true) // By this, title and description become CDATA wrapped HTML.
                ->appendTo($channel);
        }


        return response($feed, 200, ['Content-Type' => 'application/xml']);
    }

    public function calendarevents()
    {
        $feed = new Feed();

        $channel = new Channel();
        $channel
            ->title(setting('name') . ' : ' . trans('messages.agenda'))
            ->description(setting('name'))
            ->ttl(60)
            ->appendTo($feed);

        $events = CalendarEvent::with('group')
            ->with('user')
            ->whereIn('group_id', Group::public()->pluck('id'))
            ->orderBy('start', 'desc')->take(50)->get();

        foreach ($events as $event) {
            $item = new \Suin\RSSWriter\Item();
            $item
                ->title($event->name)
                ->description($event->body)
                ->contentEncoded($event->body)
                ->url(route('groups.calendarevents.show', [$event->group, $event]))
                ->author($event->user->name)
                ->pubDate($event->start->timestamp)
                ->guid(route('groups.calendarevents.show', [$event->group, $event]), true)
                ->preferCdata(true) // By this, title and description become CDATA wrapped HTML.
                ->appendTo($channel);
        }

        return response($feed, 200, ['Content-Type' => 'application/xml']);
    }
}
