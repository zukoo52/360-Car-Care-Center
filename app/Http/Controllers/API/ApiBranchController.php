<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchPhone;
use Exception;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;

class ApiBranchController extends Controller
{
    /** get available branches to view branches page
     *
     */

    public function getBranches(Request $request)
    {
        $users = Branch::query();
        if ($keyword = $request->get("keyword")) {
            $users->where('address', 'like', '%' . $keyword . '%')->orWhere('name', 'like', '%' . $keyword . '%')->orWhere('id', 'like', '%' . $keyword . '%');
        }
        if ($limit = $request->get("limit")) {
            return response()->json($users->paginate($limit));
        }


        return response()->json($users);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createNewBranch(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'city'=> ['required'],
            'address'=> ['required','unique:branches'],
            'manager_name'=> ['required'],
            'phone_number'=> ['required','regex:/^[0-9]{10}$/'],
            'branch_status'=> ['required'],
        ]);
        $branch = Branch::create($validatedData);

        if (!$branch) return response()->json(['message' => 'Failed to create the branch, please try again!'], 500);
        return response()->json(["message" => "Branch created successfully!", "branch" => $branch], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUpdateBranch($id)
    {
        $branch = Branch::find($id);

        if (is_null($branch)) {
            return response()->json(['message' => 'Failed to locate Branch!'], 404);
        } else {
            return response()->json([
                'message' => 'Found role and related permissions!',
                'branch' => $branch
            ], 200);
        }
    }

    public function updateBranch(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'city'=> ['required'],
            'address'=> ['required', 'unique:branches,address,' . $id],
            'manager_name'=> ['required'],
            'phone_number'=> ['required','regex:/^[0-9]{10}$/'],
            'branch_status'=> ['required'],
        ]);

        $branch = Branch::find($id);
        if (is_null($branch)) return response()->json(['message' => "No record found to update!"], 404);

        $branch->update($validatedData);


        if (!$branch) return response()->json(['message' => 'Please try again!'], 500);
        return response()->json(['message' => 'Branch information has been successfully updated', 'branch' => $branch], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteBranch($id)
    {
        $branch = Branch::find($id);
        if (is_null($branch)) return response()->json(['message' => "No record found to update!"], 404);

        $branch->update(['branch_status'=>"Permanently Closed"]);

        if (!$branch) return response()->json(['message' => 'Please try again!'], 500);
        return response()->json(['message' => 'Branch has been successfully deleted.!', 'branch' => $branch], 200);
    }
}
