<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Job;

class JobController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $halaman ='pekerjaan';
        return view('master.pekerjaan', compact('halaman'));
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
        $data = [
            'job_name' => $request['job_name'],
            'description'=> $request['description'],
            'price' => $request['price'],
            'comm' => $request['comm']
        ];


        return Job::create($data);
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
        $job = Job::findorFail($id);
        return $job;
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
        
        $job = Job::find($id);
        $job->job_name = $request['job_name'];
        $job->description = $request['description'];
        $job->price = $request['price'];
        $job->comm = $request['comm'];
        $job->update();
        
        return $job;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = Job::destroy($id);
    }


    public function apiJob(){
        $job = Job::all();


        return Datatables::of($job)

            ->addColumn('price', function($job){
                return '<div style="text-align:right;">'.number_format($job->price).'</div>';
            })

            ->addColumn('comm', function($job){
                return '<div style="text-align:right;">'.$job->comm.' %</div>';
            })

            ->addColumn('action', function($job){
                return '<center><a onclick="editForm('. $job->id.')" style="margin-left:10px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<a onclick="deleteData('. $job->id.')" style="margin-left:10px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a></center>';
            })->rawColumns(['price','comm', 'action'])->make(true);
    }
}
