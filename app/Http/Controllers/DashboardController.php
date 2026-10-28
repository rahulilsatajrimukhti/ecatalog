<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $service) {}

    public function index(): View
    {
        return view('dashboard', $this->service->getDashboardData());
    }
}
