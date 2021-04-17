<?php

namespace App\Http\Controllers;

use APP\Http\Requests\OfferRequest;
use App\models\Offer ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
//use Mcamara\LaravelLocalization\LaravelLocalization;
use LaravelLocalization;

class CurdController extends Controller
{

    public function create () {
        return view('offers.creat') ;

    }

    public function store (Request $request)
    {
        //validate

        $rules = [
            'name_ar' => 'required|max:100|unique:offers,name_ar',
            'name_en' => 'required|max:100|unique:offers,name_en',
            'price' => 'required|numeric',
            'details_ar' => 'required',
            'details_en' => 'required',

        ];

        $message = [
           'name_ar.required' => __('messeg.offer name required'),
            'name_ar.uniq' => 'الاسم مميز',
            'name_en.required' => __('messeg.offer name required'),
            'name_en.uniq' => 'الاسم مميز',
            'price.numeric' => 'يجب ان يكون السعر رقم',
            'details_ar.required' => 'مطلوب',
            'details_en.required' => 'مطلوب',

        ];
        $validator = Validator::make($request->all(), $rules,$message);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }


        //insert
        Offer::create([
            'photo'=>Storage::disk('public')->put('offers', $request->photo),
            'name_ar' => $request->name_ar ,
            'name_en' => $request->name_en ,
            'price' => $request->price ,
            'details_ar' => $request->details_ar ,
            'details_en' => $request->details_en ,

        ]);
        return redirect()->back()->with(['success'=>'تم اضافة العرض بنجاح']);

    }


    public function getAllOffers()
    {
        $offers = Offer::select('id','price',
            'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
            'details_' . LaravelLocalization::getCurrentLocale() . ' as details' )->get();
        return view('offers.all', compact('offers'));
   }

   public function editOffer($offer_id)
   {
       $offer=Offer::find($offer_id);

       if(!$offer)
           return redirect() ->back();
      $offer= Offer::select('id','name_ar','name_en' ,'price','details_ar','details_en') -> find($offer_id);
      return view('offers.edit',compact('offer'));

   }


   public function deleteOffer($offer_id)
   {
       $offer=Offer::find($offer_id);
       if(!$offer)
           return redirect() ->back() -> with(['error' => __('messeg.offer not exist')]);

       $offer->delete();

       return redirect()->route('offers.all' )
                        -> with(['success'=>__('messeg.offer deleted successfully')]);
   }


   public function updateOffer(Request $request , $offer_id)
   {
   // validation request
       $rules = [
           'name_ar' => 'required|max:100|unique:offers,name_ar',
           'name_en' => 'required|max:100|unique:offers,name_en',
           'price' => 'required|numeric',
           'details_ar' => 'required',
           'details_en' => 'required',

       ];

       $message = [
           'name_ar.required' => __('messeg.offer name required'),
           'name_ar.uniq' => 'الاسم مميز',
           'name_en.required' => __('messeg.offer name required'),
           'name_en.uniq' => 'الاسم مميز',
           'price.numeric' => 'يجب ان يكون السعر رقم',
           'details_ar.required' => 'مطلوب',
           'details_en.required' => 'مطلوب',

       ];
       $validator = Validator::make($request->all(), $rules,$message);

       if ($validator->fails()) {
           return redirect()->back()->withErrors($validator)->withInput($request->all());
       }
      // check if offer exists
       $offer= Offer::select('id','name_ar','name_en' ,'price','details_ar','details_en') -> find($offer_id);

       if(!$offer)
           return redirect() ->back();

       //update data
       $offer -> update($request -> all());
       return  redirect() -> back() -> with(['success' => 'تم التحديث بنجاح']) ;
   }
}


