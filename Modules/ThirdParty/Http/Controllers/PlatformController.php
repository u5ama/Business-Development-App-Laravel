<?php

namespace Modules\ThirdParty\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\ThirdParty\Entities\Platform;
use Modules\ThirdParty\Http\Requests\CreatePlatformRequest;

class PlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return 123;
        return view('thirdparty::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('thirdparty::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CreatePlatformRequest $request)
    {
        // Retrieve the validated input data...
        $userData = session()->all()['user_data'];
        $user_id = $userData['id'];
        $business_id = $userData['business'][0]['business_id'];

        $validated = $request->validated();

        Platform::create(array_merge($validated,[
            'user_id' => $user_id,
            'business_id' => $business_id
        ]));
        
        return redirect()->route('apps-connection')->with('success', $request->platform_name.' added successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('thirdparty::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('thirdparty::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
