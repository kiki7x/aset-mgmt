<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketFront;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ServiceDeskController extends Controller
{

    public function index()
    {
        return view('frontsite.servicedesk');
    }


    public function data()
    {

        $tickets = TicketFront::latest();

        return DataTables::of($tickets)

            ->addColumn('ticket', function ($row) {

                return '<a href="javascript:void(0)" class="lihat-tiket"
                data-ticket="' . $row->ticket . '"
                data-nama="' . $row->nama . '"
                data-email="' . $row->email . '"
                data-wa="' . $row->whatsapp_number . '"
                data-subject="' . $row->subject . '"
                data-issuetype="' . $row->issuetype . '"
                data-department="' . $row->department . '"
                data-priority="' . $row->priority . '"
                data-description="' . $row->description . '"
                data-status="' . $row->status . '"
                data-reason="'.e($row->reason).'"
                data-attachments="' . $row->attachments . '"
            >' . $row->ticket . '</a>';
            })

            ->addColumn('nama', function ($row) {
                return $row->nama;
            })

            ->addColumn('department', function ($row) {
                return $row->issuetype . ' - ' . $row->department;
            })

            ->addColumn('subject', function ($row) {
                return $row->subject;
            })

            ->addColumn('description', function ($row) {
                return $row->description;
            })

            ->addColumn('priority', function ($row) {
                return $row->priority;
            })

            ->addColumn('status', function ($row) {
                return $row->status;
            })

            ->addColumn('duedate', function ($row) {
                return $row->created_at->format('d M Y');
            })

            ->filter(function ($query) {
                if (request()->has('search') && !empty(request('search')['value'])) {
                    $searchTerm = request('search')['value'];
                    $query->where('ticket', 'like', "%{$searchTerm}%")
                        ->orWhere('nama', 'like', "%{$searchTerm}%")
                        ->orWhere('subject', 'like', "%{$searchTerm}%")
                        ->orWhere('description', 'like', "%{$searchTerm}%")
                        ->orWhere('issuetype', 'like', "%{$searchTerm}%")
                        ->orWhere('department', 'like', "%{$searchTerm}%")
                        ->orWhere('priority', 'like', "%{$searchTerm}%")
                        ->orWhere('status', 'like', "%{$searchTerm}%")
                        ->orWhereRaw("DATE_FORMAT(created_at, '%d %b %Y') LIKE ?", ["%{$searchTerm}%"]);
                }
            })

            ->rawColumns(['ticket'])

            ->make(true);
    }


    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'issuetype' => 'required',
            'department' => 'required',
            'priority' => 'required',
            'description' => 'required',
            'attachments' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $prefix = '';

        if ($request->issuetype == 'Permintaan') {
            $prefix = 'PER';
        } elseif ($request->issuetype == 'Keluhan') {
            $prefix = 'KEL';
        }
        $prefix1 = '';

        if ($request->department == 'TIK') {
            $prefix1 = 'TIK';
        } elseif ($request->department == 'Rumah Tangga') {
            $prefix1 = 'RT';
        }
        $ticketNumber = 'TCK-' . $prefix . '-' . $prefix1 . '-' . rand(100000, 999999);

        $fileName = null;

        if ($request->hasFile('attachments')) {

            $file = $request->file('attachments');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->storeAs('attachments', $fileName, 'public');
        }

        TicketFront::create([

            'ticket' => $ticketNumber,

            'nama' => $request->nama,

            'email' => $request->email,

            'whatsapp_number' => $request->whatsapp_number,

            'subject' => $request->subject,

            'issuetype' => $request->issuetype,

            'department' => $request->department,

            'priority' => $request->priority,

            'description' => $request->description,

            'attachments' => $fileName,

            'status' => 'Open'

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tiket berhasil dibuat'
        ]);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'ticket' => 'required|exists:tickets_front,ticket',
            'status' => 'required|in:Open,Pending,Proses,Close',
            'reason' => 'required|string'
        ]);

        $ticket = TicketFront::where('ticket', $request->ticket)->first();

        $ticket->update([
            'status' => $request->status,
            'reason' => $request->reason
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status tiket berhasil diperbarui'
        ]);
    }
}
