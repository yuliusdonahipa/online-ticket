<?php

namespace App\Http\Controllers\Admin;

use App\Models\Participant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Participant::with('event')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('search'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            if (Str::contains(Str::lower($row['email']), Str::lower($request->get('search')))) {
                                return true;
                            } else if (Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                                return true;
                            } else if (Str::contains(Str::lower($row['uuid']), Str::lower($request->get('search')))) {
                                return true;
                            }

                            return false;
                        });
                    }
                })
                ->addColumn('is_payment', function ($row) {
                    $status = '<div class="badge badge-danger">No</div>';

                    if ($row->is_payment) {
                        $status = '<span class="badge badge-success">Yes</span>';
                    }

                    return $status;
                })
                ->addColumn('is_present', function ($row) {
                    $status = '<div class="badge badge-danger">No</div>';

                    if ($row->is_present) {
                        $status = '<span class="badge badge-success">Yes</span>';
                    }

                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $btn = '
                    <a href="javascript:void(0)" onclick="editFunc(' . $row->id . ')" class="btn btn-primary btn-sm" data-id="' . $row->id . '">Edit</a>
                    <a href="javascript:void(0)"  onclick="delFunc(' . $row->id . ')" class="btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</a>
                    ';
                    return $btn;
                })
                ->rawColumns(['action', 'is_payment', 'is_present'])
                ->make(true);
        }

        return view('participant.index');
    }

    public function store(Request $request)
    {
        $uuid = 'EVENT' . date('y') . date('m') . str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);

        $data = Participant::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'uuid' => $uuid,
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'is_payment' => $request->is_payment,
                'is_present' => $request->is_present
            ]
        );

        return Response()->json($data);
    }


    public function edit(Request $request)
    {
        return Participant::find($request->id);
    }

    public function update(Request $request, $id)
    {
        Participant::whereUuid($id)->update([
            'uuid' => $request->uuid,
            'name' => $request->name,
            'email' => $request->email,
            'is_present' => isset($request->is_present) ?? 0
        ]);

        Alert::html('Success', 'Edit berhasil', 'success');

        return redirect()->route('participant.index');
    }

    public function delete($id)
    {
        return Participant::destroy($id);
    }

    public function checkin()
    {
        return view('participant.checkin');
    }

    public function checkinStatus(Request $request)
    {
        $data = Participant::whereUuid($request->uuid)->first();

        if (!$data) {
            Alert::html('Error', 'Maaf, no tiket tidak valid', 'error');
            return back();
        }

        if (!$data->is_payment) {
            Alert::html('Error', 'Maaf, Anda belum melakukan pembayaran', 'error');
            return back();
        }

        if ($data->is_present) {
            Alert::html('Error', 'Maaf, tiket sudah terpakai', 'error');
            return back();
        }

        $data->update([
            'is_present' => 1
        ]);

        Alert::html('Success', 'Checkin Berhasil', 'success');
        return back();
    }
}
