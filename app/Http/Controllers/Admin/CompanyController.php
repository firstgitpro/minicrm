<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use Maatwebsite\Excel\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    //list companies
    public function index(){
        $companies = DB::table('companies')->paginate(2);
        return view('admin.companies.index',['companies'=>$companies]);
    }

    public function show($id){

    }

    // store company to database
    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|unique:companies|max:255',
            'email' => 'required|unique:companies',
            'logo' => 'required',
        ]);

        $model = new Company();
        $model->name = request('name');
        $model->email = request('email');

        $file = $request->file('logo');

        if( $file->isValid() ) {
            $clientName = $file->getClientOriginalName();
            $tmpName = $file->getFileName();
            $realPath = $file->getRealPath();
            $entension = $file->getClientOriginalExtension();
            $mimeTye = $file->getMimeType();
            $newName = $newName = md5(date('ymdhis').$clientName).".".$entension;
            $path = $file->move(storage_path('/app/public'),$newName);
            $model->logo = $newName;
        }

        $res = $model->save();

        if( $res ){
            return redirect('/admin/companies');
        }else{
            flash('fail to save')->overlay();
            return redirect('/admin/companies/add');
        }
    }

    public function create(){
        return view('admin.companies.add');
    }


    public function destroy($id){
        $res = Company::destroy( $id );
        if ($res) {
            return response()->json(['message'=>'delete success','valid'=>1]);
        }else{
            return response()->json(['message'=>'delete failure','valid'=>0]);
        }
    }

    public function update(Request $request,$id){
        $res = Company::findorfail( $id );
        $res->email = $request->email;
        $res->name = $request->name;

        $file = $request->file('logo');

        if( $file->isValid() ) {
            $clientName = $file->getClientOriginalName();
            $entension = $file->getClientOriginalExtension();
            $newName = md5(date('ymdhis').$clientName) . "." . $entension;
            $path = $file->move(storage_path('/app/public'),$newName);
            $res->logo = $newName;
        }

        $data = $res->save();

        if ($data) {
            flash('update success')->overlay();
            return redirect()->back();
        }

        flash('update failure')->overlay();
    }

    public function edit($id){
        $item = Company::findorfail($id);
        return view('admin.companies.update', compact('item'));
    }


    public function export(Excel $excel){
        $cellData = [
            ['company name',
                'company email',
                'logo_url',
                'created_date'],
        ];
        $companies = Company::all();
        foreach ($companies as $data){
            $data = [$data->name,
                $data->email,
                $data->logo,
                $data->created_at];
            array_push($cellData,$data);
        }

        $export_name = 'company_list' . date('Y-m-d-H:i');

        $excel->create($export_name,function($excel) use ($cellData) {
            $excel->sheet('score', function($sheet) use ($cellData) {$sheet->rows($cellData);});
        })->export('xls');
    }


}
