<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function create($lapangan)
    {
        return view('booking', ['lapangan' => $lapangan]);
    }

    public function store(\Illuminate\Http\Request $request, $lapangan)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nomer_hp' => 'required|string|min:11',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|string|in:00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23',
            'jam_akhir' => 'required|string|in:00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23'
        ]);
        $validator->after(function ($validator) use ($request) {
            $jam_mulai = (int)$request->jam_mulai;
            $jam_akhir = (int)$request->jam_akhir;

            if ($jam_akhir <= $jam_mulai) {
                $validator->errors()->add('jam_akhir', 'Jam akhir harus setelah jam mulai.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $jam_mulai_int = (int)$request->jam_mulai;
        $jam_akhir_int = (int)$request->jam_akhir;

        $existingBookings = Booking::where('tanggal_booking', $request->tanggal_booking)->where('lapangan', $lapangan)->get();

        foreach ($existingBookings as $booking) {
            $existing_mulai = (int)$booking->jam_mulai;
            $existing_akhir = (int)$booking->jam_akhir;

            if (($jam_mulai_int < $existing_akhir) && ($jam_akhir_int > $existing_mulai)) {
                return redirect()->back()
                    ->withErrors(['jam_mulai' => 'Rentang jam ini bertabrakan dengan booking yang sudah ada (' . $booking->jam_mulai . ':00 - ' . $booking->jam_akhir . ':00). Silakan pilih jam lain.'])
                    ->withInput();
            }
        }

        Booking::create([
            'nama' => $request->nama,
            'nomer_hp' => $request->nomer_hp,
            'tanggal_booking' => $request->tanggal_booking,
            'jam_mulai' => $request->jam_mulai,
            'jam_akhir' => $request->jam_akhir,
            'lapangan' => $lapangan
        ]);

        return redirect('/payment')->with('success', 'Booking Sukses');
    }

    public function getBookedRanges($date, $lapangan)
    {
        $bookings = Booking::where('tanggal_booking', $date)->get();

        $query = Booking::where('tanggal_booking', $date);

        if ($lapangan) {
            $query->where('lapangan', $lapangan);
        }

        $bookings = $query->get();

        $bookedRanges = [];
        foreach ($bookings as $booking) {
            $bookedRanges[] = [
                'start' => $booking->jam_mulai,
                'end' => $booking->jam_akhir,
                'lapangan' => $booking->lapangan
            ];
        }

        return response()->json($bookedRanges);
    }


    public function index()
    {
        $bookings = Booking::orderBy('tanggal_booking', 'desc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('list', compact('bookings'));
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);

        $bookingTime = \Carbon\Carbon::parse($booking->tanggal_booking . ' ' . $booking->jam_mulai . ':00');
        $now = \Carbon\Carbon::now();

        if ($now->diffInHours($bookingTime) < 2) {
            return redirect()->route('booking.index')
                ->with('error', 'Booking hanya bisa di-reschedule minimal 2 jam sebelum waktu mulai.');
        }

        return view('action', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|string|in:00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23',
            'jam_akhir' => 'required|string|in:00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23'
        ]);

        $validator->after(function ($validator) use ($request) {
            $jam_mulai = (int)$request->jam_mulai;
            $jam_akhir = (int)$request->jam_akhir;

            if ($jam_akhir <= $jam_mulai) {
                $validator->errors()->add('jam_akhir', 'Jam akhir harus setelah jam mulai.');
            }

            $durasi = $jam_akhir - $jam_mulai;
            if ($durasi < 1 || $durasi > 6) {
                $validator->errors()->add('jam_akhir', 'Durasi booking harus 1-6 jam.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $jam_mulai_int = (int)$request->jam_mulai;
        $jam_akhir_int = (int)$request->jam_akhir;

        $existingBookings = Booking::where('tanggal_booking', $request->tanggal_booking)
            ->where('lapangan', $booking->lapangan)
            ->where('id', '!=', $id)
            ->get();

        foreach ($existingBookings as $existing) {
            $existing_mulai = (int)$existing->jam_mulai;
            $existing_akhir = (int)$existing->jam_akhir;

            if (($jam_mulai_int < $existing_akhir) && ($jam_akhir_int > $existing_mulai)) {
                return redirect()->back()
                    ->withErrors(['jam_mulai' => 'Waktu bertabrakan dengan booking lain (' . $existing->jam_mulai . ':00 - ' . $existing->jam_akhir . ':00)'])
                    ->withInput();
            }
        }
        try {

            $booking->update([
                'tanggal_booking' => $request->tanggal_booking,
                'jam_mulai' => $request->jam_mulai,
                'jam_akhir' => $request->jam_akhir
            ]);


            return redirect()->route('booking.index')
                ->with('success', 'Booking berhasil di-reschedule!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupdate booking: ' . $e->getMessage())
                ->withInput();
        }
    } 

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $bookingTime = \Carbon\Carbon::parse($booking->tanggal_booking . ' ' . $booking->jam_mulai . ':00');
        $now = \Carbon\Carbon::now();

        if ($now->diffInHours($bookingTime) < 3) {
            return redirect()->route('booking.index')
                ->with('error', 'Booking hanya bisa dibatalkan minimal 3 jam sebelum waktu mulai.');
        }

        $booking->delete();

        return redirect()->route('booking.index')
            ->with('success', 'Booking berhasil dibatalkan!');
    }

    public function delete($id)
    {
        return $this->destroy($id);
    }
}
