<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\Controller;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $v = Validator::make($request->only(['customer_id','trx_id','trx_amount','trx_timestamp']), [
            'customer_id' => 'required|string',
            'trx_id' => 'required|string',
            'trx_amount' => 'required|integer|min:0|max:10000000',
            'trx_timestamp' => 'required|date_format:Y-m-d H:i:s',
        ]);
        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $v->errors()
            ], 422);
        }

        $data = array_merge(
            $v->validated(),
            [
                'disc' => false,
                'disc_rate' => 10, // percentage
            ]
        );

        
        $data['disc'] = $this->roulette([1, 0], [9, 1]);
        $data['disc_amount'] = $data['disc'] ? floor($data['disc_rate'] * $request->trx_amount / 100) : 0;
        $data['payment_amout'] = $request->trx_amount - $data['disc_amount'];

        return $data;
    }

    /**
     * roulette()
     * Pick a random item based on weights.
     * example:
     * $values = array('true', 'false');
     * $weights = array(1, 9); // 10% chance to get true, 90% chance to get false
     *
     * @param array $values Array of elements to choose from
     * @param array $weights An array of weights. Weight must be a positive number.
     * @return mixed Selected element.
     */
    public function roulette($values, $weights){ 
        $count = count($values); 
        $i = 0; 
        $n = 0; 

        $num = random_int(0, array_sum($weights));  

        while($i < $count){
            $n += $weights[$i]; 
            if($n >= $num){
                break; 
            }
            $i++; 
        } 
        return $values[$i]; 
    }

}
