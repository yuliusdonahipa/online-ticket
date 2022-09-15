<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FrontController extends Controller
{
    public function index()
    {
        $events = Event::get();

        return view('index', compact('events'));
    }

    public function event($slug)
    {
        $event = Event::whereSlug($slug)->first();

        return view('event', compact('event'));
    }

    public function create($slug)
    {
        $event = Event::whereSlug($slug)->first();

        return view('register', compact('event'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'event_id' => ['required'],
                'name' => ['required'],
                'email' => ['required', 'email', 'unique:participants,email'],
                'address' => ['required'],
            ]);

            $uuid = 'EVENT' . date('y') . date('m') . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);

            $data['uuid'] = $uuid;

            Participant::create($data);

            $alert = [
                'title' => 'Success',
                'message' => "
            <p>
            Hay <b>" . $data['name'] . "</b>, terima kasih telah mendaftar
            <br>
            Silahkan screenshot nomor tiket anda untuk digunakan saat menghadiri acara
            </p>
            <h3>" . $data['uuid'] . "</h3>
            <p>
            Terima kasih dan sampai bertemu.
            </p>",
                "type" => 'success'
            ];

            Alert::html($alert['title'], $alert['message'], $alert['type'])->persistent(true, false);

            return redirect()->route('index');
        } catch (\Exception $e) {

            $alert = [
                'title' => 'Gagal',
                'message' => 'Maaf, terjadi kesalahan.',
                'type' => 'error'
            ];

            Alert::html($alert['title'], $alert['message'], $alert['type'])->persistent(true, false);
            return back();
        }
    }
}
