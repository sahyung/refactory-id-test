<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Tier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TierController extends Controller
{
    public function browse(Request $request)
    {

    }

    public function read($id)
    {

    }

    public function edit(Request $request, $id)
    {

    }
    public function add(Request $request)
    {
        $data = $request->only(['name', 'min', 'max', 'disc_rate', 'disc_prob']);
        $v = Validator::make($data, [
            'name' => 'required|string',
            'min' => 'required|numeric|min:0',
            'max' => 'required|numeric|min:0|gte:min',
            'disc_rate' => 'required|numeric|digits_between:0,100',
            'disc_prob' => 'required|numeric|digits_between:0,100',
        ]);

        $v->after(function ($v) use ($data)  {
            $tier = DB::table('tiers')
                ->orWhere(function ($query) use ($data) {
                    $query->where('min', '<=', $data['max'])
                    ->where('max', '>=', $data['max']);
                })
                ->orWhere(function ($query) use ($data) {
                    $query->where('min', '<=', $data['min'])
                    ->where('max', '>=', $data['min']);
                })
                ->first();

            if($tier)
            {
                if ($tier->min <= $data['min'] && $tier->max >= $data['min']) $v->errors()->add('min', 'The min cannot overlap with existing tier');
                if ($tier->min <= $data['max'] && $tier->max >= $data['max']) $v->errors()->add('max', 'The max cannot overlap with existing tier');
            }
        });

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'data' => $data,
                'errors' => $v->errors()
            ], 422);
        }
        
        $tier = Tier::create($v->validated());
        return response()->json([
            'success' => true,
            'data' => $tier,
        ], 200);
    }

    public function delete($id)
    {
    }

}
