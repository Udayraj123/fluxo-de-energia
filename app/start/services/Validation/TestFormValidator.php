<?php
/**
 * Created by PhpStorm.
 * User: aneeshdash
 * Date: 11/12/14
 * Time: 6:39 PM
 */
namespace services\Validation;

class TestFormValidator extends Validator {

    /**
     * @var array Validation rules for the test form, they can contain in-built Laravel rules or our custom rules
     */
    public $rules = array(
        'name' => array( 'required', 'alpha_dash', 'max:200' ),
        'email' => array( 'required', 'email', 'min:6', 'max:200' ),
        'phone' => array( 'required', 'numeric', 'digits_between:8,25' ),
        'pin_code' => array( 'required', 'alpha_num', 'max:25' ),
    );

}   //end of class


//EOF