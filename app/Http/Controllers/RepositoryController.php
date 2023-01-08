<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreRepositoryRequest;
use App\Http\Requests\UpdateRepositoryRequest;

class RepositoryController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function store(StoreRepositoryRequest $request)
    {
        Log::debug(__METHOD__);
        Log::debug(print_r($request->all(), true));
        $request->user()->repositories()->create($request->all());
        return redirect()->route('repositories.index');
    }

    public function update(UpdateRepositoryRequest $request, Repository $repository)
    {
        $repository->update($request->all());

        return redirect()->route('repositories.edit', $repository->id);
    }
}
