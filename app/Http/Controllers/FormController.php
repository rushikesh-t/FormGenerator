<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormDetail;
use App\Models\FieldValue;
use Illuminate\Http\Request;


class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $form = Form::all();
        return view('form.index',compact('form'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('form.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $field_name = $request->field_name;
        $field_type = $request->field_type;
        $field_label = $request->field_label;

        $fields = count($field_name);
        $form = new Form;
        $form->name = $request->name;
        $form->info = $request->info;
        $form->save();
        $form_id = $form->id;

        for ($x = 0; $x < $fields; $x++) {
            $FormDetail = new FormDetail;
            $FormDetail->form_id = $form_id;
            $FormDetail->field_name = $field_name[$x];
            $FormDetail->field_type = $field_type[$x];

            if($field_label[$x] == ""){
                $FormDetail->field_label = $field_name[$x];
            } else {
                $FormDetail->field_label = $field_label[$x];
            }

            $FormDetail->save();

            if($field_type[$x] == "radio" || $field_type[$x] == "select") {
                $fieldValues = $request->input( $field_name[$x].'-value' );
                $fieldLabels = $request->input( $field_name[$x].'-label' );

                $values = count($fieldValues);
                $form_details_id = $FormDetail->id;

                for ($y = 0; $y < $values; $y++) {
                    $FieldValue = new FieldValue;
                    $FieldValue->form_details_id = $form_details_id;
                    $FieldValue->field_value = $fieldValues[$y];

                    if ($fieldLabels[$y] == ""){
                        $FieldValue->field_label = $fieldValues[$y];
                    } else {
                        $FieldValue->field_label = $fieldLabels[$y];
                    }

                    $FieldValue->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Form Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        //
    }
}
