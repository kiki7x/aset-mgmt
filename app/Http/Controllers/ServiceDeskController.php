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

        ->addColumn('pemohon', function ($row) {
            return $row->nama;
        })

        ->addColumn('name', function ($row) {
            return $row->department;
        })

        ->addColumn('description', function ($row) {
            return $row->description;
        })

        ->addColumn('pic', function ($row) {

            return [
                'avatar' => null
            ];

        })

        ->addColumn('asset', function ($row) {

            return [
                'tag' => '-',
                'name' => '-'
            ];

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


        ->addColumn('action', function ($row) {

            return '<button class="btn btn-sm btn-info">Detail</button>';

        })

        ->rawColumns(['action'])

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

        $ticketNumber = 'TCK-' . rand(100000,999999);

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

            'status' => 'Segera Kerjakan'

        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tiket berhasil dibuat'
        ]);

    }

}
