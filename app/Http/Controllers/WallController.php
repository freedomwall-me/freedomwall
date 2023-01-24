<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWallRequest;
use App\Http\Requests\UpdateWallRequest;
use App\Models\Wall;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class WallController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('verified', ['except' => ['index', 'show']]);
    }

    protected function index()
    {
        // four each row, five rows ordered by updated_date from newest to oldest
        $walls = Wall::orderBy('id', 'desc')->where('publish_status', 'published')->paginate(20);
        return view('wall.index', ['walls' => $walls]);
    }

    protected function show(int $id)
    {
        $wall = Wall::findOrFail($id);
        // if the wall is draft and the user is not the owner, throw 403
        if ($wall->publish_status == 'draft' && $wall->user_id != Auth::user()->id)
            abort(403);
        return view('wall.show', ['wall' => $wall]);
    }

    protected function create()
    {
        return view('wall.create');
    }

    protected function store(StoreWallRequest $request)
    {
        $valid = $request->validated();

        $wall = new Wall();
        $wall->user_id = Auth::user()->id;
        $wall->title = $valid['title'];
        $wall->tags = $valid['tags'];
        $wall->body = bzcompress($valid['body']);
        $wall->publish_status = $valid['publish_status'];
        $wall->save();

        return redirect()
                ->back()
                ->with('success', 'Wall created successfully!')
                ->with('wall_id', $wall->id);
    }

    protected function edit(int $id)
    {
        $wall = Wall::findOrFail($id);
        // if the user is not the owner, throw 403
        if ($wall->user_id != Auth::user()->id)
            abort(403);
        return view('wall.edit', ['wall' => $wall]);
    }

    protected function update(UpdateWallRequest $request, int $id)
    {
        $valid = $request->validated();

        $wall = Wall::findOrFail($id);
        $wall->title = $valid['title'] ?? $wall->title;
        $wall->tags = $valid['tags'] ?? $wall->tags;
        $wall->body = isset($valid['body']) ? bzcompress($valid['body']) : $wall->body; // if body is not set
        $wall->publish_status = $valid['publish_status'] ?? $wall->publish_status;
        $wall->save();

        return redirect()
                ->back()
                ->with('success', 'Wall updated successfully!')
                ->with('wall_id', $wall->id);
    }

    protected function destroy(int $id)
    {
        $wall = Wall::findOrFail($id);
        if (Auth::user()->id != $wall->user_id)
            abort(403);

        $wall->delete();
        return redirect()->route('wall.index');
    }
}
