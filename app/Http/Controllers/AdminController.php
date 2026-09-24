<?php

namespace App\Http\Controllers;

use App\Services\StokService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $stokService;

    public function __construct(StokService $stokService)
    {
        $this->stokService = $stokService;
    }

    function index()
    {
        $stats = $this->stokService->getDashboardStats();
        $financial = $this->stokService->getFinancialStats();
        return view('poinakses/admin/dashboard/index', compact('stats', 'financial'));
    }

    public function getStats()
    {
        $stats = $this->stokService->getDashboardStats();
        $financial = $this->stokService->getFinancialStats();
        return response()->json(array_merge($stats, $financial));
    }
}