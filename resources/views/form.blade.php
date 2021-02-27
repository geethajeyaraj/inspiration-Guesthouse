<div class="s3-section">
 <div class="s3-section-body">
<fieldset class="form-horizontal  ">
    @foreach($rows as $row)
    <div class="row">
        @foreach($row as $r)
        <div class="col-md-{{ (12/count($row)) }}">
            @if($r['field_type']!="empty" && $r['field_type']!="title")
            <div class="form-group   {{ $errors->has($r['field_name']) ? 'is-invalid':'' }}">
                <label for="{{ $r['field_name'] }}">{!! $r['label_name'] !!}</label>
                @if(isset($r['class_name']))
                @php($class_name=$r['class_name'])
                @else
                @php($class_name='')
                @endif
                @if($errors->has($r['field_name']))
                @php($class_name=$class_name." is-invalid")
                @endif

                @if($r['field_type']=="text")

                <div class="input-group">
                       
                    @if(isset($r['icon']))
                <div class="input-group-prepend"><span class="input-group-text">{!! $r['icon'] !!}</span></div>
                    @endif 
                                    
                {!! Form::input('text',$r['field_name'],null, ['class' => 'form-control m-input '.$class_name ,
                'placeholder' => $r['placeholder'], 'autocomplete'=>"nope" ])
                !!}
                </div>
                    

                @elseif($r['field_type']=="password")
                  {!! Form::input('password',$r['field_name'],'', ['class' => 'form-control m-input '.$class_name ,
                  'placeholder' => $r['placeholder']])
                  !!}
                @elseif($r['field_type']=="textarea")
                {!! Form::textarea($r['field_name'],null, ['rows'=>'3','class' => 'form-control m-input '.$class_name ,
                'placeholder' => $r['placeholder' ] , 'id'=>$r['field_name'] ])
                !!}
                @elseif($r['field_type']=="select")
                {!! Form::select($r['field_name'],$r['values_data'],null, ['class' => 'form-control m-input
                '.$class_name, 'placeholder' => $r['placeholder'],'id'=>$r['field_name'] ])
                !!}
                 @elseif($r['field_type']=="select-multiple")

                 {!! Form::select($r['field_name'],$r['values_data'],null, ['multiple'=>'multiple','class' => 'form-control m-input
                 '.$class_name, 'id'=>$r['id'] ])
                 !!}

                @elseif($r['field_type']=="file")
                {!! Form::file($r['field_name'], ['class' => 'form-control m-input
                '.$class_name, 'placeholder' => $r['placeholder'],'id'=>$r['field_name'] ])
                !!}
                
                @elseif($r['field_type']=="image")
                  <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="width: 150px; height: auto;">
                           @if(isset($model_name->{ $r['field_name'] }))
                            @if(file_exists(storage_path().'/app/'.$model_name->{ $r['field_name'] }))
                            <img src="{{ url($model_name->{ $r['field_name'] }) }}" style="max-width:150px;max-height:150px;" class="" alt="User Image">
                            @else
                            <img src="{{ url('assets/media/user.jpg') }}" class="" alt="User Image">
                            @endif
                            @else
                            <img src="{{ url('assets/media/user.jpg') }}" class="" alt="User Image">
                           @endif
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width:150px; max-height:150px;">
                        </div>
                        <div>
                            <span class="btn btn-sm btn-primary btn-file">
                                <span class="fileinput-new">
                                    Select image </span>
                                <span class="fileinput-exists">
                                    Change </span>
                                <input type="file" id="{{ $r['field_name'] }}" name="{{ $r['field_name'] }}">
                            </span>
                            <a href="#" class="btn btn-sm  btn-danger fileinput-exists" data-dismiss="fileinput">
                                Remove </a>
                        </div>
                    </div>

                @endif
                @if($errors->has($r['field_name']))
                <span class="s3-form-help invalid-feedback">{{ $errors->first($r['field_name']) }}</span>
                @else
                <span class="s3-form-help vaild-feedback">@if(isset($r['help_text'])) {{ $r['help_text'] }} @endif </span>
                @endif
            </div>
            @elseif($r['field_type']=="title")
            <div class="row">
                                            
                    <div class="col-lg-12">
                        <h3 class="s3-section-title">{{ $r['field_name'] }}</h3>
                    </div>
                </div>
            @endif
        </div>
        @endforeach
    </div>
@endforeach


</fieldset>
        </div></div>