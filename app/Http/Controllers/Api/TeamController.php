<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\Team\TeamRepoInterface;
use App\Service\Team\TeamServiceInterface;
use Exception;
use Illuminate\Http\Request;

class TeamController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $teamRepo, $teamService;
    public function __construct(TeamRepoInterface $teamRepo, TeamServiceInterface $teamService)
    {
        $this->teamService = $teamService;
        $this->teamRepo = $teamRepo;
    }
    public function index()
    {
        try {
            $data = $this->teamRepo->get();
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
            $input = $request->validate([
                'team_name' => 'required|unique:teams,team_name',
            ]);
            $data = $this->teamService->store($input);
            return $this->sendResponse($data, 'Created Successfully');
        } catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
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
            $data = $this->teamRepo->show($id);
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
            $input = $request->validate([
                'team_name' => 'required|unique:teams,team_name,' . $id,
            ]);
            $data = $this->teamService->update($input, $id);
            return $this->sendResponse($data, 'Updated Successfully');
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
            $data = $this->teamService->delete($id);
            return $this->sendResponse($data, 'Deleted successfully.');
        } catch (Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }
}
