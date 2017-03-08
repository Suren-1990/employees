<?php

namespace App\Http\Controllers;

use App\Base\Request;
use App\Models\Employer;
use App\Base\Validation\Validator;

class HomeController
{
    /**
     * @return null|string
     */
    public function index()
    {
        $employees = Employer::all();

        $no = 0;

        return view('home', [
            'employees' => $employees,
            'no' => $no
        ]);
    }


    public function store(Request $request)
    {
        $data = $request->all();

        $params = [];

        parse_str($data['data'], $params);

        $filtered = array_filter_recursive($params);

        $validator = new Validator();

        $validator = $validator->make($filtered, [
            'firstName' => 'required',
            'lastName' => 'required',
            'city' => 'required',
            'country' => 'required',
            'age' => 'required',
            'bankAccountNumber' => 'required',
            'creditCardNumber' => 'required',
            'email' => 'required',
            'addresses' => 'required',
            'phones' => 'required',
        ]);

        if ($validator) {
            header("HTTP/1.0 422 Unprocessable Entity");
            return json_encode([
                'message' => $validator
            ]);
        }

        if (Employer::save($filtered)) {
            return json_encode([
                'message' => 'Success'
            ]);
        }

        header("HTTP/1.0 404 Not Found");
        return json_encode(['message' => 'something went wrong']);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function edit(Request $request)
    {
        $email = $request->get('email');

        $employer = Employer::findBy('email', $email);

        if ($employer) {
            return json_encode($employer);
        }

        header("HTTP/1.0 404 Not Found");
        return json_encode(['message' => 'Not found']);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function update(Request $request)
    {
        $data = $request->all();

        $params = [];

        parse_str($data['email'], $params);

        $filtered = array_filter_recursive($params);

        $validator = new Validator();

        $validator = $validator->make($filtered, [
            'firstName' => 'required',
            'lastName' => 'required',
            'city' => 'required',
            'country' => 'required',
            'age' => 'required',
            'bankAccountNumber' => 'required',
            'creditCardNumber' => 'required',
            'email' => 'required|email',
            'addresses' => 'required',
            'phones' => 'required',
        ]);

        if ($validator) {
            header("HTTP/1.0 422 Unprocessable Entity");
            return json_encode([
                'message' => $validator
            ]);
        }

        if (Employer::update($filtered['email'], $filtered)) {
            return json_encode([
                'message' => 'Success'
            ]);
        }

        header("HTTP/1.0 404 Not Found");
        return json_encode([
            'message' => 'Something Went Wrong'
        ]);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function destroy(Request $request)
    {
        $email = $request->get('email');

        Employer::delete($email);

        return json_encode([
            'message' => 'Success',
            'email' => $email
        ]);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function multiDestroy(Request $request)
    {
        $emails = $request->get('emails');

        foreach ($emails as $email) {
            Employer::delete($email);
        }

        return json_encode($emails);
    }

    /**
     * @param Request $request
     * @return null|string
     */
    public function search(Request $request)
    {
        $q = $request->get('q');

        $query = $q;

        $qq = strip_tags($q);
        $qq = preg_replace('!\s+!', ' ', $qq);
        $qq = stripslashes($qq);
        $qq = trim($qq, '/');
        $qq = trim($qq);
        $qq = explode(' ', $qq);
        $queryVariables = array_unique(array_filter($qq));

        $jsonData = Employer::all();

        $items = [];
        foreach ($queryVariables as $queryVariable) {
            $find = false;
            foreach ($jsonData as $obj) {
                $item = new static();
                foreach ($obj as $key => $value) {
                    if (!is_array($value)) {
                        if (strpos($value, $queryVariable) !== false) {
                            $find = true;
                        }
                    } else {
                        foreach ($value as $v) {
                            if (strpos($v, $queryVariable) !== false) {
                                $find = true;
                            }
                        }
                    }

                    $item->$key = $value;
                }
                if ($find) {
                    $items[] = $item;
                    $find = false;
                }
            }
        }

        $no = 0;

        return view('result', [
            'items' => $items,
            'no' => $no,
            'query' => $query
        ]);
    }
}
