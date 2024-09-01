<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

use Yajra\DataTables\DataTables;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy("created_at", "desc")->get();
        return view("dashboard.pages.event", compact("events"));
    }

    public function getEventsData()
    {
        $events = Event::select(['id', 'nama_event', 'deskripsi_event', 'tanggal_event'])->get();
        return response()->json($events);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_event' => 'required|max:255',
            'deskripsi_event' => 'required|max:255',
            'tanggal_event' => 'required|date',
        ]);

        Event::create($validatedData);

        return redirect()->route('event.index')->with('success', 'Event berhasil dibuat.');
    }

    public function findById($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event tidak ditemukan.'], 404);
        }

        return response()->json($event);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_event' => 'required|max:255',
            'deskripsi_event' => 'required|max:255',
            'tanggal_event' => 'required|date',
        ]);

        $event = Event::find($id);
        $event->update($validatedData);

        return response()->json(['message' => 'Golongan berhasil diubah.']);
    }

    public function destroy($id)
    {
        try {
            $event = Event::findOrFail($id);
            $event->delete();

            return response()->json([
                'success' => true,
                'message' => 'Event deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Event could not be deleted. Please try again.'
            ], 500);
        }
    }

    public function datatable()
    {
        $query = Event::select(['id', 'nama_event', 'deskripsi_event', 'tanggal_event'])->get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('nama_event', function ($row) {
                return $row->nama_event;
            })
            ->editColumn('deskripsi_event', function ($row) {
                return $row->deskripsi_event;
            })
            ->editColumn('tanggal_event', function ($row) {
                return $row->tanggal_event->format('d-m-Y');
            })
            ->addColumn('actions', function ($row) {
                return '
            <div class="d-flex justify-content-end">
                <a href="#"
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 event-edit"
                    data-id="' . $row->id . '" data-name="' . $row->nama_event . '">
                    <span class="svg-icon svg-icon-2">
                        <i class="fas fa-pen"></i>
                    </span>
                </a>
                <a href="#"
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 event-delete"
                    data-id="' . $row->id . '" data-name="' . $row->nama_event . '">
                    <span class="svg-icon svg-icon-2">
                        <i class="fas fa-trash"></i>
                    </span>
                </a>
            </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

}
