<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function subjectClasses(Request $request)
    {

        $this->globalVariables();
        $user = $this->user;

        $api_key = config('variables.api_key');
        $api_url = 'https://sis.materdeicollege.com/api/hr/subject-classes';

        $client = new Client();

        $response = $client->get($api_url, [
            'query' => [
                'code' => $api_key,
                'term_id' => $request->term_id,
                'teacher_id' => $user->teacher->id,
            ],
            'verify' => false,
        ]);

        $response = json_decode($response->getBody(), true);

        return response()->json($response);
    }
}
