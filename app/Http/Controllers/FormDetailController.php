<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormDetail;
use App\Models\FieldValue;
use Illuminate\Http\Request;

class FormDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->id;

        $form = Form::where('id', $id)->first();
        $formDetail = FormDetail::where('form_id', $id)->get();
        $html = '<form>';
        foreach($formDetail as $item){
            if($item->field_type == "textarea"){
                $html .= '<div class="form-group"><label for="'.$item->field_name.'">'.$item->field_label.'</label>';
                $html .= '<textarea class="form-control" name="'.$item->field_name.'" id="'.$item->field_name.'"></textarea></div>';
            }
            else if($item->field_type == "select"){
                $html .= '<div class="form-group"><label for="'.$item->field_name.'">'.$item->field_label.'</label>';
                $html .= '<select name="'.$item->field_name.'" id="'.$item->field_name.'" class="form-control">';
                $FieldValue = FieldValue::where('form_details_id', $item->id)->get();

                foreach($FieldValue as $value){
                    $html .= '<option value="'.$value->field_value.'">'.$value->field_label.'</option>';
                }
                $html .= '</select></div>';
            }
            else if($item->field_type == "radio"){
                $html .= '<div class="form-group"><label for="'.$item->field_name.'">'.$item->field_label.'</label>';
                $FieldValue = FieldValue::where('form_details_id', $item->id)->get();

                foreach ($FieldValue as $value) {
                    $html .= '<div class="form-check">';
                    $html .= '<input class="form-check-input" type="radio" name="'.$item->field_name.'" id="'.$item->field_name.'" value="'.$value->field_value.'">';
                    $html .= '<label class="form-check-label" for="'.$value->field_value.'"> '.$value->field_label.' </label></div>';
                }

            }
            else if($item->field_type == "checkbox"){
                $html .= '<div class="form-group">';
                $html .= '<input type="'.$item->field_type.'" id="'.$item->field_name.'" name="'.$item->field_name.'" class="form-check-input ml-1" value="'.$item->field_name.'">';
                $html .= '<label class="form-check-label ml-4" for="'.$item->field_name.'">'.$item->field_label.'</label></div>';
            }
            else {
                $html .= '<div class="form-group"><label for="'.$item->field_name.'">'.$item->field_label.'</label>';
                $html .= '<input type="'.$item->field_type.'" name="'.$item->field_name.'" id="'.$item->field_name.'" class="form-control"></div>';
            }
        }
        $html .= '<div class="row"><button class="btn btn-primary offset-1 col-3">Submit</button></div>';
        $html .= '</form>';

        return view('formDetails.index',compact('form', 'html'));
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
     * @param  \App\FormDetail  $formDetail
     * @return \Illuminate\Http\Response
     */
    public function show(FormDetail $formDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FormDetail  $formDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(FormDetail $formDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FormDetail  $formDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormDetail $formDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FormDetail  $formDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormDetail $formDetail)
    {
        //
    }
}
