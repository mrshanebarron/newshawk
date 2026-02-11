<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Topic;

class AlertController extends Controller
{
    public function index()
    {
        $query = Alert::with(['topic', 'article'])->orderByDesc('triggered_at');

        if (request('severity')) {
            $query->where('severity', request('severity'));
        }
        if (request('type')) {
            $query->where('type', request('type'));
        }
        if (request('unread')) {
            $query->where('is_read', false);
        }

        $alerts = $query->paginate(20);
        $unreadCount = Alert::where('is_read', false)->count();

        return view('alerts.index', compact('alerts', 'unreadCount'));
    }
}
