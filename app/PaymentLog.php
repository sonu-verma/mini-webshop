<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'payment_by',
        'payment_date',
        'log_msg',
        'status'
    ];
    protected $table = 'payment_logs';


    public static function paymentLog($data){
        SELF::create([
            'order_id' => $data['order_id'],
            'payment_by' => $data['payment_by'],
            'payment_date' => date('Y-m-d'),
            'status' => $data['status'],
        ]);
    }

    public function order(){
        return $this->belongsTo(Order::class)->with('customer');
    }

    public function paidBy(){
        return $this->belongsTo(Customer::class,'payment_by','id');
    }
}
