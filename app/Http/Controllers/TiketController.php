<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketFront;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TiketController extends Controller
{

    public function index()
    {
        return view('admin.tiket.index');
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
                data-reason="' . e($row->reason) . '"
                data-notes="' . e($row->notes) . '"
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

    public function print(Request $request)
    {
        $search = trim($request->query('search', ''));
        $tickets = TicketFront::latest();

        if ($search !== '') {
            $tickets->where(function ($query) use ($search) {
                $query->where('ticket', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('issuetype', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('priority', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereRaw("DATE_FORMAT(created_at, '%d %b %Y') LIKE ?", ["%{$search}%"]);
            });
        }

        return view('admin.tiket.print', [
            'tickets' => $tickets->get(),
            'search' => $search,
        ]);
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'issuetype' => 'required',
                'department' => 'required',
                'priority' => 'required',
                'description' => 'required',
                'whatsapp_number' => 'nullable',
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
            $ticketNumber = "TCK-{$prefix}-{$prefix1}-" . rand(100000, 999999) . "-" . now()->year;

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

                'status' => 'Open',

                'notes' => $request->description ?? 'Tiket baru dibuat',

                'reason' => null

            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tiket berhasil dibuat'
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        if ($request->has('notes') && is_array($request->notes)) {
            $request->merge(['notes' => implode("\n", $request->notes)]);
        }

        if ($request->has('reason') && is_array($request->reason)) {
            $request->merge(['reason' => implode("\n", $request->reason)]);
        }

        $request->validate([
            'ticket' => 'required|exists:tickets,ticket',
            'status' => 'required|in:Open,Pending,Proses,Close',
            'reason' => 'sometimes|required_if:status,Pending',
            'notes' => 'sometimes|required_if:status,Close',
            'confirm_close' => 'sometimes|required_if:status,Close|in:on,yes,1,true'
        ]);

        $ticket = TicketFront::where('ticket', $request->ticket)->firstOrFail();

        $updateData = [
            'status' => $request->status,
            'reason' => null,
            'notes' => $ticket->notes
        ];

        if ($request->status === 'Pending') {
            $updateData['reason'] = $request->reason;
        } elseif ($request->status === 'Close') {
            $updateData['notes'] = $request->notes;
        }

        $ticket->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Status tiket berhasil diperbarui'
        ]);
    }
}
