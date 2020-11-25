<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ResourceListController extends Controller
{
    /**
     * Create a new controller instance.
     * Se especifica el guard reqres como middleware
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:reqres');
    }

    private function requestHttp($page){
        $response = Http::get('https://reqres.in/api/unknown',[
            'page' => (int)$page
        ]);
            
        return json_decode($response->body(), true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($page=null)
    {
        $arr = $this->requestHttp($page); 
        
        return response()->json([
            'list'      => $arr['data'],
            'paginate'  => [
                'current_page' => $arr['page'],
                'prev_page'    => (int)$arr['page']-1,
                'next_page'    => (int)$arr['page']+1,
                'per_page'     => $arr['per_page'],
                'total_items' => $arr['total'],
                'total_pages' => $arr['total_pages'],
            ]
        ],200);
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($page=null,$text=null)
    {
        $arr = $this->requestHttp($page); 
        if($text){
            $count=0;
            $response=[];
            
            foreach($arr['data'] as $data){
                if (stristr(substr($data['name'], 0, strlen($text)),$text)) {
                    if($count < 9){
                        $count++;
                        array_push($response,$data);
                    }
                    
                }
            }
            return response()->json($response,200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
