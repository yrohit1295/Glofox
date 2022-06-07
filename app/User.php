<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /**
     * Insert records of classes
     * @param object $request_obj
     * @return object
     */

    public function createClasses($request_obj) {
        $result = array();
        $current = strtotime($request_obj->input('start_date'));
        $end = strtotime($request_obj->input('end_date'));
        while ($current <= $end) {
            $query = array();
            $query['class_name'] = $request_obj->input('class_name');
            $query['capacity'] = $request_obj->input('capacity');
            $query['class_date'] = date('Y/m/d', $current);
            $result[] = $query;
            $current = strtotime('+1 days', $current);
        }
        DB::beginTransaction();
        try {
            DB::table('classes')->insert($result);
            DB::commit();
        } catch (\PDOException $exp) {
            DB::rollback();
            return $this->status(null, $message = 'Error on server side', $status_text = 'Error', $status_code = 503);
        }
        return $this->status($data = $result, $status_text = 'Successful', $status_code = 200);
    }

    /**
     * Return status in JSON object
     * @param string $data
     * @param string $message
     * @param string $status_text
     * @param int $status_code
     * @return object
     */
    protected function status($data = null, $message = null, $status_text = null, $status_code = 200) {
        return response()->json([
                    'status' => $status_text,
                    'message' => $message,
                    'data' => $data,
                    'status_code' => $status_code
                        ], $status_code);
    }
    
    /**
     * Insert records of bookings
     * @param object $request_obj
     * @return object
     */
    public function createBookings($request_obj) {
        $result = array();
        $name = $request_obj->input('name');
        $date = strtotime($request_obj->input('date'));
        $result_arr = DB::table('classes')->select('id')->where('class_date','=',date('Y-m-d', $date))->get();
        DB::beginTransaction();
        try {
            DB::table('bookings')->insert(['name'=>$name,'booking_date'=>date('Y-m-d', $date), 'class_id'=>$result_arr[0]->id]);
            DB::commit();
        } catch (\PDOException $exp) {
            DB::rollback();
            return $this->status(null, $message = 'Error on server side', $status_text = 'Error', $status_code = 503);
        }
        return $this->status($data = $result, $status_text = 'Successful', $status_code = 200);
    }
}
