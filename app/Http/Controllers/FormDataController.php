<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormData;
use App\Models\FormDetail;
use App\Models\FieldValue;

class FormDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data = FormData::where('id',$id)->first();

        $form_id = $data->form_id;

        $data = unserialize($data->data);

        $form = Form::where('id', $form_id)->first();
        $formDetail = FormDetail::where('form_id', $form_id)->get();
        $html = '';
        foreach($formDetail as $item){
            if($item->field_type == "textarea"){
                $html .= '<div class="form-group"><label for="'.$item->field_name.'">'.$item->field_label.'</label>';
                $html .= '<textarea class="form-control" name="'.$item->field_name.'" id="'.$item->field_name.'" readonly>'. $data[$item->field_name] .'</textarea></div>';
            }
            else if($item->field_type == "select"){
                $html .= '<div class="form-group"><label for="'.$item->field_name.'">'.$item->field_label.'</label>';
                $html .= '<select name="'.$item->field_name.'" id="'.$item->field_name.'" class="form-control"  readonly>';
                $FieldValue = FieldValue::where('form_details_id', $item->id)->get();

                foreach($FieldValue as $value){
                    $html .= '<option value="'.$value->field_value.'" ';
                    if ($data[$item->field_name] == $value->field_value){
                        $html .= 'selected';
                    }
                    $html .= '>'.$value->field_label.'</option>';
                }
                $html .= '</select></div>';
            }
            else if($item->field_type == "radio"){
                $html .= '<div class="form-group"><label for="'.$item->field_name.'">'.$item->field_label.'</label>';
                $FieldValue = FieldValue::where('form_details_id', $item->id)->get();

                foreach ($FieldValue as $value) {
                    $html .= '<div class="form-check">';
                    $html .= '<input class="form-check-input" type="radio" name="'.$item->field_name.'" id="'.$item->field_name.'" value="'.$value->field_value.'"';
                    if (isset($data[$item->field_name]) && $data[$item->field_name] == $value->field_value){
                        $html .= 'checked';
                    } else {
                        $html .= 'disabled';
                    }
                    $html .= ' readonly>';
                    $html .= '<label class="form-check-label" for="'.$value->field_value.'"> '.$value->field_label.' </label></div>';
                }

            }
            else if($item->field_type == "checkbox"){
                $html .= '<div class="form-group">';
                $html .= '<input type="'.$item->field_type.'" id="'.$item->field_name.'" name="'.$item->field_name.'" class="form-check-input ml-1"  readonly';
                if(isset($data[$item->field_name]) && $data[$item->field_name] == 'on'){
                    $html .= ' checked';
                }
                $html .= '>';
                $html .= '<label class="form-check-label ml-4" for="'.$item->field_name.'">'.$item->field_label.'</label></div>';
            }
            else {
                $html .= '<div class="form-group"><label for="'.$item->field_name.'">'.$item->field_label.'</label>';
                $html .= '<input type="'.$item->field_type.'" name="'.$item->field_name.'" id="'.$item->field_name.'" value="'.$data[$item->field_name].'" class="form-control" readonly></div>';
            }
        }

        return view('formdata.show',compact('form', 'html'));
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
