<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['id','job_title','email','first_name','last_name','registered_since','phone'];

    protected $appends = ['customer_name'];

    public function getCustomerNameAttribute(){
        return trim($this->first_name.' '.$this->last_name);
    }
}
