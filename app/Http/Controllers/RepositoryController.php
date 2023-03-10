<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreRepositoryRequest;
use App\Http\Requests\UpdateRepositoryRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class RepositoryController extends Controller
{
    public function index(Request $request)
    {
        $repositories = $request->user()->repositories;
        return view('repositories.index', compact('repositories'));
    }

    public function create()
    {
        return view('repositories.create');
    }

    public function store(StoreRepositoryRequest $request)
    {
        $request->user()->repositories()->create($request->all());
        return redirect()->route('repositories.index');
    }

    public function show(Request $request, Repository $repository)
    {
        if (! Gate::allows('show-repository', $repository)) {
            abort(403);
        }
        return view('repositories.show', compact('repository'));
    }

    public function edit(Request $request, Repository $repository)
    {
        if (! Gate::allows('show-repository', $repository)) {
            abort(403);
        }
        return view('repositories.edit', compact('repository'));
    }

    public function update(UpdateRepositoryRequest $request, Repository $repository)
    {
        $repository->update($request->all());

        return redirect()->route('repositories.edit', $repository->id);
    }

    public function destroy(Repository $repository)
    {
        if (! Gate::allows('delete-repository', $repository)) {
            abort(403);
        }
        $repository->delete();

        return redirect()->route('repositories.index');
    }
}
