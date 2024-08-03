<?php

namespace App\Rules;

class CheckArray
{
    /**
     *
     * @param string $model
     * @param boolean $checkKeys
     */
    public function __construct( 
        protected string $model,  
        protected bool $checkKeys = false
        ) {}
    
    /**
     *
     * @param [type] $attribute
     * @param [type] $array
     * @return boolean
     */
    public function passes($attribute, $array) : bool
    {
        if($this->checkKeys)
        {  
            $array = array_keys($array);
        }
        foreach ($array as $id){
            if(!preg_match('/^[1-9]+\d*$/', $id)){
                return false;
            }
        }
        $cnt = $this->model::whereIn('id', $array)->count();
        return $cnt === count($array);
    }

    /**
     *
     * @return string
     */
    public function message() : string
    {
        return trans('validation.checkArray');
    }
}
