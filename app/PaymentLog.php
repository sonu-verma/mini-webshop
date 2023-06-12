<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $fillable = [
        'order_id',
        'payment_by',
        'payment_date',
        'log_msg',
        'status'
    ];
    protected $table = 'payment_logs';


    public function paymentLog($data){
        SELF::create([
            'order_id' => $data['order_id'],
            'payment_by' => $data['payment_by'],
            'payment_date' => date('Y-m-d'),
            'log_msg' => $data['log_msg'],
            'status' => $data['status'],
        ]);
    }
}
