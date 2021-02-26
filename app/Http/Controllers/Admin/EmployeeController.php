<?php

namespace App\Http\Controllers\Admin;

require base_path() . '/vendor/autoload.php';

use App\Employee;
use App\Company;
use CURLFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Dompdf\Dompdf;
use Intervention\Image\Facades\Image as ImageManager;
use Log;
use View;

class EmployeeController extends Controller
{
    //list employees
    public function index(){
        $employees = DB::table('employees')->leftJoin('companies','employees.Company','=','companies.id')->select('employees.First_name','employees.last_name','employees.email','employees.phone','companies.name','employees.id')->paginate(1);
        return view('admin.employees.index',['employees'=>$employees]);
    }

    // store employee to database
    public function store(Request $request){

        $validatedData = $request->validate([
            'First_name' => 'required|unique:employees|max:50',
            'last_name' => 'required|unique:employees|max:50',
            'email' => 'required|unique:employees',
            'phone' => 'required',
            'Company' => 'required'
        ]);

        $model = new Employee();
        $model->First_name = request('First_name');
        $model->last_name = request('last_name');
        $model->email = request('email');
        $model->phone = request('phone');
        $model->Company = request('Company');

        $res = $model->save();

        if( $res ){
            return redirect('/admin/employees/index');
        }else{
            return redirect('/admin/employees/add');
        }
    }

    public function show($id){
    }

    public function create(){
        $companies = Company::all();
        return view('admin.employees.add',['companies'=>$companies]);
    }

    public function destroy($id){
        $res = Employee::destroy( $id );
        if ($res) {
            return response()->json(['message'=>'delete success','valid'=>1]);
        }else{
            return response()->json(['message'=>'delete failure','valid'=>0]);
        }
    }

    public function update(Request $request,$id){
        $res = Employee::findorfail( $id );
        $res->First_name = $request->First_name;
        $res->last_name = $request->last_name;
        $res->email = $request->email;
        $res->phone = $request->phone;
        $res->Company = $request->Company;


        $data = $res->save();

        if ($data) {
            flash('update success')->overlay();
            return redirect()->back();
        }
    }

    public function edit($id){
        $record = Employee::findorfail($id);
        $companies = Company::all();
        return view('admin.employees.update', compact('record'))->with('companies',$companies);
    }


    /**
     * export data as pdf
     * @return mixed
     */
    public function export(){
        $html = '<table><tr><td>First_name</td><td>last_name</td><td>email</td><td>phone</td><td>company</td></tr> ';

        $res = DB::table('employees')->leftJoin('companies','employees.Company','=','companies.id')
            ->select('employees.First_name','employees.last_name','employees.email','employees.phone','companies.name as company_name')->get();

        foreach ( $res as $emp ){
            $html .= '<tr><td>'.$emp->First_name.'</td><td>'.$emp->last_name.'</td><td>'.$emp->email.'</td><td>'.$emp->phone.'</td><td>'.$emp->company_name.'</td></tr>';
        }

        $html .= '</table>';

        //$pdf = App::make('dompdf.wrapper');
        $pdf = new Dompdf();

        $pdf->loadHTML( $html );
        return $pdf->stream();
    }


    /**
     *
     * test pdf manipulation with dompdf
     * @throws \Dompdf\Exception
     *
     */
    public function pdftest(){
        $old_pdf_url = 'http://www.orimi.com/pdf-test.pdf';
        $dompdf = new Dompdf();
        $dompdf->getOptions()->setIsRemoteEnabled(1 );
        $dompdf->loadHtmlFile( $old_pdf_url );
        $dompdf->setPaper('A4','landscape');
        $dompdf->render();
        $dompdf->stream();
    }

    /**
     * test file upload and generate 3 different sizes
     * @param Request $request
     *
     */
    public function uploadtest(Request $request){

        $file = $request->file('testimage');
        if( $file->isValid() ){

            $clientName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $newName = md5( date('Ymdhis') . $clientName ) . '.' . $extension;
            $newName_s = 's_' . $newName;
            $newName_m = 'm_' . $newName;

            $path = storage_path('/app/public' );

            $file->move( $path , $newName );

            $path_small = $path . '/' . $newName_s;
            $path_medium = $path . '/' . $newName_m;
            $path_original = $path . '/' . $newName;


            $image_small = ImageManager::make( $path_original )->resize(100,100);
            $image_medium = ImageManager::make( $path_original )->resize(500,500);

            // no aws account,need visa to apply,no visa,so save to this machine instead
            $image_small->save( $path_small );
            $image_medium->save( $path_medium );

            $image_rec = new \App\Image();
            $image_rec->image_id = $newName;
            $image_rec->image_original = $path_original;
            $image_rec->image_medium = $path_small;
            $image_rec->image_small = $path_medium;

            $image_rec->save();

            flash('upload success')->overlay();
            return redirect()->back();

        }

    }


    private function uploadToAmazonS3(){
        // todo
    }
    
}
