<?php

namespace services\Validation;

class Validator {
    public  function  validate() {
        $validation = \Validator::make(
            array(
                'state' => \Input::get('state'),
                'city' => \Input::get('city'),
                'school' => \Input::get('school'),
                'squad' => \Input::get('squad'),
                'medium' => \Input::get('medium'),
                'name1' =>\Input::get('name1'),
                'email1' => \Input::get('email1'),
                'contact1' => \Input::get('contact1'),
                'name2' =>\Input::get('name2'),
                'email2' => \Input::get('email2'),
                'contact2' => \Input::get('contact2'),
            ),
            array(
                'state' => 'required',
                'city' => 'required',
                'other_city' => 'required_if:city,other',
                'school' => 'required',
                'name' => 'required_if:school,other|alpha_dash',
                'addr1' => 'required_if:school,other|alpha_dash',
                'addr2' => 'required_if:school,other|alpha_dash',
                'pincode' => 'required_if:school,other|digits:6',
                'contact' => 'required_if:school,other|integer',
                'squad' => 'required',
                'medium' => 'required',
                'name1' => 'required|alpha',
                'email1' => 'required|email',
                'contact' => 'requred|numeric',
                'name2' => 'required|alpha',
                'email2' => 'required|email',
                'contact2' => 'requred|numeric',
            )
        );
    }
}