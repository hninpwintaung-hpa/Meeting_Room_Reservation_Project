<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\Room\RoomRepoInterface;
use App\Service\Room\RoomServiceInterface;
use Exception;
use Illuminate\Http\Request;

class RoomController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $roomService, $roomRepo;
    public function __construct(RoomServiceInterface $roomService, RoomRepoInterface $roomRepo)
    {
        $this->roomService = $roomService;
        $this->roomRepo = $roomRepo;
    }
    public function index()
    {
        try {
            $data = $this->roomRepo->get();
            return $this->sendResponse($data, 'All Data.');
        } catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request = $request->validate([
                'room_name' => 'required',
                'room_image' => 'nullable|mimes:jpeg,png,jpg',
                'status' => 'required',
                'capacity' => 'required'
            ]);
            $data = $this->roomService->store($request);
            return $this->sendResponse($data, 'Register successfully.');
        } catch (Exception $e) {
            return $this->sendError('Error in register', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = $this->roomRepo->show($id);
            return $this->sendResponse($data, 'Data Show');
        } catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request = $request->validate([
                'room_image' => 'nullable|mimes:jpeg,png,jpg',
            ]);
            $data = $this->roomService->update($request, $id);
            return $this->sendResponse($data, 'Updated successfully.');
        } catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = $this->roomService->delete($id);
            return $this->sendResponse($data, 'Deleted successfully.');
        } catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }
}
