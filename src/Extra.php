<?php
namespace  Sheld\Contentbox;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model{
    protected $fillable = ['type' ,'name','varkey','yinti','default','validations','extras','mustinput'];
}
