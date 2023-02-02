<?php

namespace App\Http\Controllers;

use App\Http\HttpResponse;
use App\Http\Requests\StoreWallRequest;
use App\Http\Requests\UpdateWallRequest;
use App\Http\Resources\WallResource;
use App\Models\Wall;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class WallController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    use HttpResponse;

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
        $this->middleware('verified', ['except' => ['index', 'show']]);
    }

    protected function index(/* $user = null, $paginate = null, $page = null */ Request $request)
    {
        $user = $request->query('user');
        $paginate = $request->query('paginate');
        $page = $request->query('page');

        $query = Wall::query();
        if ($user) {
            // if the user is not the owner, throw 403
            if ($user != auth('sanctum')->id()) {
                return $this->error('Unauthorized', 403);
            }

            $query->where('user_id', $user);
        } else {
            $query->where('publish_status', 'published'); // if user not specified, only show published posts
        }

        $query->orderBy('id', 'desc');
        if ($paginate) {
            $np = $query->paginate($paginate, ['*'], 'page', $page);
        } else {
            $np = $query->get();
        }

        return $this->success([
            'walls' => WallResource::collection($np)
        ]);
    }

    protected function show(Wall $wall)
    {
        // if the wall is draft and the user is not the owner, throw 403
        if ($wall->publish_status == 'draft' && $wall->user_id != auth('sanctum')->id()) {
            return $this->error('Unauthorized', 403);
        }

        return $this->success(new WallResource($wall));
    }

    protected function create()
    {
        return view('wall.create');
    }

    protected function store(StoreWallRequest $request)
    {
        $request->validated();

        $wall = new Wall();
        $wall->user_id = Auth::id();
        $wall->title = $request->title;
        $wall->tags = $request->tags;
        $wall->body = bzcompress($request->body);
        $wall->publish_status = $request->publish_status;
        $wall->save();

        return $this->success(new WallResource($wall));
    }

    protected function edit(Wall $wall)
    {
        // if the user is not the owner, throw 403
        if ($wall->user_id != auth('sanctum')->id()) {
            abort(403);
        }

        return view('wall.edit', ['wall' => $wall]);
    }

    protected function update(UpdateWallRequest $request, Wall $wall)
    {
        $request->validated();

        $wall->title = $request->title ?? $wall->title;
        $wall->tags = $request->tags ?? $wall->tags;
        $wall->body = $request->body ? bzcompress($request->body) : $wall->body; // if body is not set
        $wall->publish_status = $request->publish_status ?? $wall->publish_status;
        $wall->save();

        return $this->success(new WallResource($wall));
    }

    protected function destroy(Wall $wall)
    {
        if (auth('sanctum')->id() != $wall->user_id) {
            return $this->error('Unauthorized', 403);
        }

        $wall->delete();

        return $this->success('Wall deleted successfully');
    }
}
