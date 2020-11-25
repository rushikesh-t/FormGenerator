
@extends('layouts.app')

@section('title', 'Form List')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-light">
            <div class="row">
                <h3 class="col-9">Create Form</h3>
                <a href="{{ route('form.index') }}" class="col-3 btn btn-primary">Back</a>
            </div>
        </div>
        <div class="card-body">
            {{-- <form> --}}
            <form method="POST" id="createForm" action="{{ route("form.store") }}">
                @csrf
                <div class="row">
                    <button class="btn btn-primary col-4">Submit</button>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="col-6">
                        <label for="info">Info:</label>
                        <textarea name="info" id="info" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row">
                    <button type="button" class="col-4 btn btn-primary" id="add"> Add </button>
                </div>
                <div class="formData">
                </div>
            </form>
        </div>
    </div>

    <!-- Laravel Javascript Validation -->
    {{-- <script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\FormValidationRequest', '#createForm') !!} --}}

    <script>
        $(document).ready(function(){
            var count = 1;
            var element = '<select id="element" class="form-control">'
            element +='<option> == Element == </option>'
            element +='<option value="input">input</option>'
            element +='<option value="select">select</option>'
            element +='<option value="textarea">textarea</option>'
            element +='</select>'
            

            dynamic_field(count, element);

            $(document).on('click', '#add',function(){
                count++;
                dynamic_field(count, element);
            })

            $(document).on('click', '#remove',function(){
                count--;
                $(this).closest('.fieldDetails').remove();
            })

            function dynamic_field(number,element){
                var html = '<div class="row border m-2 p-2 fieldDetails">';
                if(number > 1){
                    html += '<div class="col-12 row"><button type="button" class="offset-8 col-4 btn btn-danger" id="remove"> Remove </button></div>';
                }
                html += '<div class="col-12">' + element + '</div>';
                $('.formData').append(html);
            }

            $(document).on('change', '#element',function(){
                
                if($(this).closest('.fieldDetails').find(".fieldType").length)
                {
                    $(this).closest('.fieldDetails').find(".fieldType").remove();
                }
                var type = $(this).val();
                if(type == "input"){
                    var types = '<select id="type" name="field_type[]" class="form-control">'
                    types +='<option> == Type == </option>'
                    types +='<option value="text">text</option>'
                    types +='<option value="password">password</option>'
                    types +='<option value="email">email</option>'
                    types +='<option value="number">number</option>'
                    types +='<option value="time">time</option>'
                    types +='<option value="checkbox">checkbox</option>'
                    types +='<option value="radio">radio</option>'
                    types +='</select>'

                    var html = '<div class="col row fieldType">';
                    html += '<div class="col-4"><label>Name:</label><input type="text" name="field_name[]" id="field_name" class="form-control"></div>';
                    html += '<div class="col-4"><label>Label:</label><input type="text" name="field_label[]" id="field_label" class="form-control"></div>';
                    html += '<div class="col-4"><label>Type:</label>' + types + '</div>';
                    html += '</div>';
                }
                else if(type == "textarea"){
                    var html = '<div class="col row fieldType">';
                    html += '<div class="col-4"><label>Name:</label><input type="text" name="field_name[]" id="field_name" class="form-control"></div>';
                    html += '<div class="col-4"><label>Label:</label><input type="text" name="field_label[]" id="field_label" class="form-control"></div>';
                    html += '<div class="col-4"><label>Type:</label><input type="text" class="form-control disable" name="field_type[]" value="textarea" readonly></div>';
                    html += '</div>';

                }
                else if(type == "select"){
                    var html = '<div class="col row fieldType">'
                    html += '<div class="col-4"><label>Name:</label><input type="text" name="field_name[]" id="field_name" class="form-control"></div>';
                    html += '<div class="col-4"><label>Label:</label><input type="text" name="field_label[]" id="field_label" class="form-control"></div>';
                    html += '<div class="col-4"><label>Type:</label><input type="text" class="form-control disable" name="field_type[]" value="select" readonly></div>';
                    html += '</div>';
                }

                $(this).closest('.fieldDetails').append(html);

                if(type == "select"){
                    var html = '<div class="col-12 row optionButton"><button type="button" id="addOption" class="btn btn-primary m-3">Add Option</button></div>';
                    $(this).closest('.fieldDetails').find('.fieldType').append(html);
                }
            })
            
            $(document).on('change', '#type',function(){
                if($(this).val() == "radio"){
                    var html = '<div class="col-12 row optionButton"><button type="button" id="addOption" class="btn btn-primary m-3">Add Option</button></div>';
                    $(this).closest('.fieldDetails').find('.fieldType').append(html);
                }
            });

            $(document).on('click', '#addOption',function(){
                var name =$(this).closest('.fieldDetails').find("#field_name").val();

                if(name != ""){
                    var html = '<div class="col-12 row m-1 p-1 border fieldOption">'
                    html += '<div class="col-4"><label>Value:</label><input type="text" class="form-control" name="'+name+'-value[]"></div>'
                    html += '<div class="col-4"><label>Label:</label><input type="text" class="form-control" name="'+name+'-label[]"></div>'
                    html += '<div class="offset-2 col-2"><button type="button" class="btn btn-danger mt-4" id="removeOption">remove</div>'
                    html += '</div>'

                    $(this).closest('.fieldType').find('.optionButton').append(html);
                }else{ alert("Enter Name First!"); }
            });

            $(document).on('click', '#removeOption',function(){
                $(this).closest('.fieldOption').remove();
            });
            // $(document).on('submit', '#createForm',function(e){
            //     e.preventDefault();
            //     $.ajax({
            //         url : '{{ route("form.store") }}',
            //         type: 'POST',
            //         data : {
            //             "_token": "{{ csrf_token() }}",
            //             "data": $(this).serialize(),
            //         },
            //         dataType : 'json',
            //         success : function(data){
            //             alert("form submited");
            //         }
            //     });
            // });
        });
    </script>
@endsection