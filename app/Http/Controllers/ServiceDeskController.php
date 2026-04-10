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

            return '<a href="#" class="lihat-tiket"
                data-ticket="'.$row->ticket.'"
                data-nama="'.$row->nama.'"
                data-email="'.$row->email.'"
                data-wa="'.$row->whatsapp_number.'"
                data-subject="'.$row->subject.'"
                data-issuetype="'.$row->issuetype.'"
                data-department="'.$row->department.'"
                data-priority="'.$row->priority.'"
                data-description="'.$row->description.'"
                data-status="'.$row->status.'"
                data-attachments="'.$row->attachments.'"
            >'.$row->ticket.'</a>';

        })

        ->addColumn('pemohon', function ($row) {
            return $row->nama;
        })

        ->addColumn('whatsapp', function ($row) {

            if ($row->whatsapp_number) {

                // sensor 3 angka terakhir
                return substr($row->whatsapp_number, 0, -3) . '***';

            }

            return '-';

        })

        ->addColumn('name', function ($row) {
            return $row->department;
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
            'description' => 'required'
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
        $ticketNumber = 'TCK-' . $prefix . '-' .$prefix1 . '-' . rand(100000,999999);

        $fileName = null;

        if ($request->hasFile('attachments')) {

            $file = $request->file('attachments');

            $fileName = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('attachments'), $fileName);
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

}
