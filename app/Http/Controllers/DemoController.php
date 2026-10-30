<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    private function page(string $view, string $role = 'public', array $extra = [])
    {
        return view($view, array_merge(config('demo'), $extra, [
            'role' => $role,
            'today' => now()->locale('id')->translatedFormat('l, d F Y'),
            'today_short' => now()->locale('id')->translatedFormat('d M Y'),
        ]));
    }

    public function home()
    {
        return $this->page('pages.home');
    }

    public function servicesIndex()
    {
        return $this->page('pages.services.index');
    }

    public function serviceShow(string $slug)
    {
        $service = collect(config('demo.services'))->firstWhere('slug', $slug);
        abort_unless($service, 404);

        $related = collect(config('demo.services'))
            ->where('slug', '!=', $slug)
            ->take(3)
            ->values()
            ->all();

        return $this->page('pages.services.show', 'public', [
            'service' => $service,
            'related' => $related,
        ]);
    }

    public function loginPlaceholder()
    {
        return $this->page('pages.auth.placeholder', 'public', ['mode' => 'login']);
    }

    public function registerPlaceholder()
    {
        return $this->page('pages.auth.placeholder', 'public', ['mode' => 'register']);
    }

    public function adminDashboard()
    {
        return $this->page('pages.admin.dashboard', 'admin');
    }

    public function adminCustomers()
    {
        return $this->page('pages.admin.customers', 'admin');
    }

    public function adminEmployees()
    {
        return $this->page('pages.admin.employees', 'admin');
    }

    public function adminPets()
    {
        return $this->page('pages.admin.pets', 'admin');
    }

    public function adminServices()
    {
        return $this->page('pages.admin.services', 'admin');
    }

    public function adminBookings()
    {
        return $this->page('pages.admin.bookings', 'admin');
    }

    public function adminBookingShow(string $code)
    {
        $booking = collect(config('demo.bookings'))->firstWhere('code', $code);
        abort_unless($booking, 404);

        return $this->page('pages.admin.booking-show', 'admin', ['booking' => $booking]);
    }

    public function adminPayments()
    {
        return $this->page('pages.admin.payments', 'admin');
    }

    public function adminReports()
    {
        return $this->page('pages.admin.reports', 'admin');
    }

    public function adminSettings()
    {
        return $this->page('pages.admin.settings', 'admin');
    }

    public function staffDashboard()
    {
        $assigned = collect(config('demo.bookings'))
            ->where('employee', 'Nadia Groomer')
            ->values();

        $today = now()->locale('id')->translatedFormat('d M Y');

        return $this->page('pages.staff.dashboard', 'staff', [
            'assigned' => $assigned->all(),
            'todayBookings' => $assigned->where('date', $today)->all(),
        ]);
    }

    public function staffSchedule()
    {
        $assigned = collect(config('demo.bookings'))
            ->where('employee', 'Nadia Groomer')
            ->values()
            ->all();

        $week = collect(range(0, 6))->map(function ($offset) {
            $date = now()->startOfDay()->addDays($offset);

            return [
                'label' => $date->locale('id')->translatedFormat('D'),
                'date' => $date->locale('id')->translatedFormat('d M'),
                'full' => $date->locale('id')->translatedFormat('d F Y'),
                'today' => $date->isToday(),
            ];
        })->all();

        return $this->page('pages.staff.schedule', 'staff', [
            'assigned' => $assigned,
            'week' => $week,
        ]);
    }

    public function staffBookings()
    {
        $assigned = collect(config('demo.bookings'))
            ->where('employee', 'Nadia Groomer')
            ->values()
            ->all();

        return $this->page('pages.staff.bookings', 'staff', ['assigned' => $assigned]);
    }

    public function staffBookingShow(string $code)
    {
        $booking = collect(config('demo.bookings'))
            ->where('employee', 'Nadia Groomer')
            ->firstWhere('code', $code);

        abort_unless($booking, 404);

        return $this->page('pages.staff.booking-show', 'staff', ['booking' => $booking]);
    }

    public function staffHistory()
    {
        $history = collect(config('demo.bookings'))
            ->where('employee', 'Nadia Groomer')
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->values()
            ->all();

        return $this->page('pages.staff.history', 'staff', ['history' => $history]);
    }

    public function staffProfile()
    {
        $employee = collect(config('demo.employees'))->firstWhere('name', 'Nadia Groomer');

        return $this->page('pages.staff.profile', 'staff', ['employee' => $employee]);
    }

    public function customerDashboard()
    {
        $myBookings = collect(config('demo.bookings'))->where('customer', 'Rina Pratama')->values();
        $myPets = collect(config('demo.pets'))->where('owner', 'Rina Pratama')->values();

        return $this->page('pages.customer.dashboard', 'customer', [
            'myBookings' => $myBookings->all(),
            'myPets' => $myPets->all(),
            'nextBooking' => $myBookings->first(),
        ]);
    }

    public function customerPets()
    {
        $myPets = collect(config('demo.pets'))->where('owner', 'Rina Pratama')->values()->all();

        return $this->page('pages.customer.pets', 'customer', ['myPets' => $myPets]);
    }

    public function customerServices()
    {
        return $this->page('pages.customer.services', 'customer');
    }

    public function customerServiceShow(string $slug)
    {
        $service = collect(config('demo.services'))->firstWhere('slug', $slug);
        abort_unless($service, 404);

        $related = collect(config('demo.services'))
            ->where('slug', '!=', $slug)
            ->take(2)
            ->values()
            ->all();

        return $this->page('pages.customer.service-show', 'customer', [
            'service' => $service,
            'related' => $related,
        ]);
    }

    public function customerBooking(Request $request)
    {
        $days = collect(range(0, 6))->map(function ($offset) {
            $date = now()->startOfDay()->addDays($offset);

            return [
                'value' => $date->format('Y-m-d'),
                'label' => $date->locale('id')->translatedFormat('D'),
                'date' => $date->locale('id')->translatedFormat('d M'),
                'full' => $date->locale('id')->translatedFormat('d F Y'),
                'disabled' => $date->isSunday(),
            ];
        })->all();

        $slots = collect(config('demo.time_slots'))->map(function ($time, $index) {
            return [
                'time' => $time,
                'available' => $index !== 3,
            ];
        })->all();

        $myPets = collect(config('demo.pets'))->where('owner', 'Rina Pratama')->values()->all();

        return $this->page('pages.customer.booking', 'customer', [
            'bookingDays' => $days,
            'timeSlots' => $slots,
            'myPets' => $myPets,
            'preselectedService' => $request->query('service'),
            'preselectedPet' => $request->query('pet'),
        ]);
    }

    public function customerBookingSuccess(Request $request)
    {
        $serviceSlug = $request->query('service', 'grooming');
        $service = collect(config('demo.services'))->firstWhere('slug', $serviceSlug)
            ?? collect(config('demo.services'))->first();

        $booking = [
            'code' => 'BK-'.now()->format('md').'-013',
            'service' => $service,
            'date' => $request->query('date_label', now()->addDays(2)->locale('id')->translatedFormat('d F Y')),
            'time' => $request->query('time', '10:00'),
            'pet' => $request->query('pet', 'Milo'),
            'method' => $request->query('method', 'Transfer Bank BCA'),
            'total' => (int) $request->query('total', $service['price']),
        ];

        return $this->page('pages.customer.booking-success', 'customer', ['confirmedBooking' => $booking]);
    }

    public function customerBookings()
    {
        $myBookings = collect(config('demo.bookings'))->where('customer', 'Rina Pratama')->values()->all();

        return $this->page('pages.customer.bookings', 'customer', ['myBookings' => $myBookings]);
    }

    public function customerPayments()
    {
        $myPayments = collect(config('demo.payments'))->where('customer', 'Rina Pratama')->values()->all();

        return $this->page('pages.customer.payments', 'customer', ['myPayments' => $myPayments]);
    }

    public function customerReviews()
    {
        $myReviews = collect(config('demo.reviews'))->where('customer', 'Rina Pratama')->values()->all();
        $myBookings = collect(config('demo.bookings'))
            ->where('customer', 'Rina Pratama')
            ->where('status', 'selesai')
            ->values()
            ->all();

        return $this->page('pages.customer.reviews', 'customer', [
            'myReviews' => $myReviews,
            'myBookings' => $myBookings,
        ]);
    }

    public function customerProfile()
    {
        $customer = collect(config('demo.customers'))->firstWhere('name', 'Rina Pratama');
        $myPets = collect(config('demo.pets'))->where('owner', 'Rina Pratama')->values()->all();

        return $this->page('pages.customer.profile', 'customer', [
            'customer' => $customer,
            'myPets' => $myPets,
        ]);
    }

}
