<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketFront;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class TiketController extends Controller
{

    public function index()
    {
        return view('admin.tiket.index');
    }

    public function show($id)
    {
        $ticketToOpen = TicketFront::findOrFail($id);
        return view('admin.tiket.index', compact('ticketToOpen'));
    }


    public function data()
    {

        $tickets = TicketFront::latest();

        if (request()->filled('issuetype')) {
            $tickets->where('issuetype', request('issuetype'));
        }

        if (request()->filled('department')) {
            $tickets->where('department', request('department'));
        }

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
        $issuetype = trim($request->query('issuetype', ''));
        $department = trim($request->query('department', ''));
        $tickets = TicketFront::latest();

        if ($issuetype !== '') {
            $tickets->where('issuetype', $issuetype);
        }

        if ($department !== '') {
            $tickets->where('department', $department);
        }

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
            'issuetype' => $issuetype,
            'department' => $department,
        ]);
    }


    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => ['required', 'string', 'min:3', 'max:100'],
                'email' => ['required', 'email:rfc,dns', 'max:255'],
                'whatsapp_number' => ['required', 'string', 'regex:/^[0-9]{11,12}$|^\+?[0-9]{11,12}$/'],
                'subject' => ['required', 'string', 'min:3', 'max:150'],
                'issuetype' => ['required', Rule::in(['Keluhan', 'Permintaan'])],
                'department' => ['required', Rule::in(['TIK', 'Rumah Tangga'])],
                'priority' => ['required', Rule::in(['Low', 'Medium', 'High'])],
                'description' => ['required', 'string', 'min:10', 'max:2000'],
                'attachments' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
                'captcha' => ['required', 'string', 'size:6'],
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'nama.string' => 'Nama harus berupa teks.',
                'nama.min' => 'Nama minimal 3 karakter.',
                'nama.max' => 'Nama maksimal 100 karakter.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.max' => 'Email maksimal 255 karakter.',
                'whatsapp_number.required' => 'Nomor WhatsApp wajib diisi.',
                'whatsapp_number.string' => 'Nomor WhatsApp harus berupa teks.',
                'whatsapp_number.regex' => 'Nomor WhatsApp harus terdiri dari 11-12 digit angka (dengan atau tanpa tanda +).',
                'subject.required' => 'Judul wajib diisi.',
                'subject.string' => 'Judul harus berupa teks.',
                'subject.min' => 'Judul minimal 3 karakter.',
                'subject.max' => 'Judul maksimal 150 karakter.',
                'issuetype.required' => 'Jenis wajib dipilih.',
                'issuetype.in' => 'Jenis tiket tidak valid.',
                'department.required' => 'Bidang wajib dipilih.',
                'department.in' => 'Bidang tiket tidak valid.',
                'priority.required' => 'Prioritas wajib dipilih.',
                'priority.in' => 'Prioritas tiket tidak valid.',
                'description.required' => 'Deskripsi wajib diisi.',
                'description.string' => 'Deskripsi harus berupa teks.',
                'description.min' => 'Deskripsi minimal 10 karakter.',
                'description.max' => 'Deskripsi maksimal 2000 karakter.',
                'attachments.image' => 'Lampiran harus berupa gambar.',
                'attachments.mimes' => 'Lampiran harus berformat JPG, JPEG, atau PNG.',
                'attachments.max' => 'Ukuran lampiran maksimal 2 MB.',
                'captcha.required' => 'Captcha wajib diisi.',
                'captcha.string' => 'Captcha tidak valid.',
                'captcha.size' => 'Captcha harus terdiri dari 6 karakter.',
            ]);

            $validator->after(function ($validator) use ($request) {
                $captchaInput = strtoupper(trim((string) $request->input('captcha')));
                $captchaCode = strtoupper(trim((string) session('captcha_code')));

                if ($captchaCode === '' || $captchaInput === '') {
                    $validator->errors()->add('captcha', 'Captcha wajib diisi.');
                } elseif (!hash_equals($captchaCode, $captchaInput)) {
                    $validator->errors()->add('captcha', 'Captcha tidak valid, silakan coba lagi.');
                }
            });

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();

            $prefix = '';

            if ($validated['issuetype'] == 'Permintaan') {
                $prefix = 'PER';
            } elseif ($validated['issuetype'] == 'Keluhan') {
                $prefix = 'KEL';
            }
            $prefix1 = '';

            if ($validated['department'] == 'TIK') {
                $prefix1 = 'TIK';
            } elseif ($validated['department'] == 'Rumah Tangga') {
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

                'nama' => $validated['nama'],

                'email' => $validated['email'],

                'whatsapp_number' => $validated['whatsapp_number'] ?? null,

                'subject' => $validated['subject'],

                'issuetype' => $validated['issuetype'],

                'department' => $validated['department'],

                'priority' => $validated['priority'],

                'description' => $validated['description'],

                'attachments' => $fileName,

                'status' => 'Open',

                'notes' => $request->description ?? 'Tiket baru dibuat',

                'reason' => null

            ]);

            session()->forget('captcha_code');

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
