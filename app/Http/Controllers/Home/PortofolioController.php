<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Portofolio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Image;

class PortofolioController extends Controller
{
    //
    public function AllPortofolio() {

        $portofolio = Portofolio::latest()->get();

        return view('admin.portofolio.portofolio_all', compact('portofolio'));
    } // End Method

    public function AddPortofolio() {

        return view('admin.portofolio.portofolio_add');
    } // End Method

    public function StorePortofolio(Request $request) {

        $request->validate([
            'portofolio_name' => 'required',
            'portofolio_title' => 'required',
            'portofolio_image' => 'required',
        ], [
            'portofolio_name.required' => 'Porofolio Name is Required',
            'portofolio_title.required' => 'Porofolio Title is Required',
        ]);

        $image = $request->file('portofolio_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(1020,519)->save('upload/portofolio/'.$name_gen);
            $save_url = 'upload/portofolio/'.$name_gen;

            Portofolio::insert([
                'portofolio_name' => $request->portofolio_name,
                'portofolio_title' => $request->portofolio_title,
                'portofolio_description' => $request->portofolio_description,
                'portofolio_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Portofolio Inserted Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.portofolio')->with($notification);
    } // End Method

    public function EditPortofolio($id) {

        $portofolio = Portofolio::findOrFail($id);
        return view('admin.portofolio.portofolio_edit', compact('portofolio'));
    } // End Method

    public function UpdatePortofolio(Request $request) {

        $portofolio_id = $request->id;

        if($request->file('home_slide')) {
            $image = $request->file('portofolio_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(1020,519)->save('upload/portofolio/'.$name_gen);
            $save_url = 'upload/portofolio/'.$name_gen;

            Portofolio::findOrFail($portofolio_id)->update([
                'portofolio_name' => $request->portofolio_name,
                'portofolio_title' => $request->portofolio_title,
                'portofolio_description' => $request->portofolio_description,
                'portofolio_image' => $save_url,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Portofolio Updated with Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.portofolio')->with($notification);
        }
        else {
            Portofolio::findOrFail($portofolio_id)->update([
                'portofolio_name' => $request->portofolio_name,
                'portofolio_title' => $request->portofolio_title,
                'portofolio_description' => $request->portofolio_description,
                'updated_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Portofolio Updated without Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.portofolio')->with($notification);
        } 
    }// End Method

    public function DeletePortofolio($id) {

        $portofolio = Portofolio::findOrFail($id);
        $img = $portofolio->portofolio_image;
        unlink($img);

        Portofolio::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Portofolio Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.portofolio')->with($notification);
    } // End Method

    public function PortofolioDetails($id) {

        $portofolio = Portofolio::findOrFail($id);
        return view('frontend.portofolio_details', compact('portofolio'));
    } //End Method

    public function HomePortofolio(){

        $portofolio = Portofolio::latest()->get();
        return view('frontend.portofolio',compact('portofolio'));
    } // End Method 
}
