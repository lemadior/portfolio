<?php

namespace App\Http\Controllers\Admin\Faux;

use App\Http\Requests\Admin\Faux\StoreRequest;
use App\Services\Admin\Faux\StoreService;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    protected StoreService $service;

    public function __construct()
    {
        $this->service = new StoreService();
    }

    public function store(StoreRequest $request)
    {

        $this->service->createStudent($request);

        return redirect()->route('admin.faux.index');
    }
}
