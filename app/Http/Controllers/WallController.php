<?php

namespace App\Http\Controllers;

use App\Models\Wall;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class WallController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    protected function validateRequest(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'body' => 'required',
            'publish_status' => 'required|in:draft,published',
        ]);
    }

    protected function done()
    {
        return redirect()->route('wall.index');
    }

    protected function index()
    {
        // four each row, five rows ordered by updated_date from newest to oldest
        $walls = Wall::orderBy('id', 'desc')->where('publish_status', 'published')->paginate(20);
        return view('wall.index', ['walls' => $walls]);
    }

    protected function show(int $id)
    {
        $wall = Wall::find($id);
        return view('wall.show', ['wall' => $wall]);
    }

    protected function create()
    {
        return view('wall.create');
    }

    protected function store(Request $request)
    {
        $this->validateRequest($request);

        $wall = new Wall();
        $wall->user_id = \Auth::user()->id;
        $wall->title = $request->title;
        $wall->tags = $request->tags;
        $wall->body = bzcompress($request->body);
        $wall->publish_status = $request->publish_status;
        $wall->save();

        return $this->done();
    }

    protected function edit(int $id)
    {
        $wall = Wall::find($id);
        return view('wall.edit', ['wall' => $wall]);
    }

    protected function update(Request $request, int $id)
    {
        $this->validateRequest($request);

        $wall = Wall::find($id);
        $wall->title = $request->title;
        $wall->tags = $request->tags;
        $wall->body = bzcompress($request->body);
        $wall->save();

        return $this->done();
    }

    protected function destroy(int $id)
    {
        $wall = Wall::find($id);
        $wall->delete();

        return $this->done();
    }
}
