<?php

namespace App\Base\Validation;

class Validator
{
    /**
     * @param array $data
     * @param array $rules
     * @return bool|mixed
     */
    public function make(array $data, array $rules)
    {
        foreach ($rules as $attribute => $rules) {
            $rules = explode('|', $rules);

            foreach ($rules as $rule) {
                if (!($this->{'validate' . ucfirst($rule)}(@$data[$attribute]))) {
                    return $this->messages($rule, $attribute);
                }
            }
        }

        return false;
    }

    /**
     * @param $value
     * @return bool
     */
    protected function validateRequired($value)
    {
        if (is_null($value)) {
            return false;
        } elseif (is_string($value) && trim($value) === '') {
            return false;
        } elseif ((is_array($value) || is_array($value)) && count($value) < 1) {
            return false;
        }

        return true;
    }

    /**
     * @param $email
     * @return bool
     */
    protected function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $rule
     * @param string $attribute
     * @return mixed
     */
    protected function messages(string $rule, string $attribute = '')
    {
        $messages = array(
            'email' => 'Invalid Email address',
            'required' => $attribute . ' field is required'
        );

        return $messages[$rule];
    }
}