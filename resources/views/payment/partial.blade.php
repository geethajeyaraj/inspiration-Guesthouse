<div class="modal-dialog" role="document" id="ajax-container">
    <div class="modal-content">
        {{ Form::open(['url' => url(route('paynow',$booking_id)),'id'=>'update_form', 'files' => true,'class'=>'form-vertical
validate_form', 'method' => 'get','autocomplete'=>'off']) }}
        <div class="modal-header">
            <h5 class="modal-title">Partial Payment</h5>
            <button title="Close (Esc)" type="button" class="mfp-close" style="color:#bcbcbc">×</button>
        </div>
        <div class="modal-body">

            <div class="s3-section">
                <div class="s3-section-body">
                    <fieldset class="form-horizontal  ">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <label for="amount">Amount</label>

                                    {!! Form::input('text','amount',$amount, ['class' => 'form-control m-input',
                'placeholder' => 'Enter amount', 'autocomplete'=>"nope" ])  !!}

                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>



        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-clean pull-left ajax-close">Close</button>
            <button id="update_btn" type="submit" class="btn btn-primary"><i class="la la-check"></i> Submit </button>
        </div>
        {{ Form::close() }}
    </div>
</div>