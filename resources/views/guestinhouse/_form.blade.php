<div class="form-group{{ $errors->has('checkoutdate') ? ' has-error' : '' }}">
    {!! Form::label('checkoutdate', 'Check Out', ['class'=>'col-md-2 control-label']) !!}
    <div class="col-md-4"><i class="glyphicon glyphicon-calendar"></i>
        {!! Form::text('checkoutdate', null, ['class'=>'form-control ','id'=>'datetimepicker','data-date-format'=>'dd M yyyy hh:ii:ss','readonly' => 'true'])  !!}
        {!! $errors->first('checkoutdate', '<p class="help-block">:message</p>') !!}
    </div>
</div>
{!! Form::hidden('attribute','Cleartext-Password') !!}
<div class="form-group{{ $errors->has('userpassword') ? ' has-error' : '' }}">
    {!! Form::label('userpassword', 'User Password', ['class'=>'col-md-2 control-label']) !!}
    <div class="col-md-4"><i class="glyphicon glyphicon-lock"></i>
        {!! Form::text('userpassword', null, ['class'=>'form-control '])  !!}
        {!! $errors->first('userpassword', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-4 col-md-offset-2">
        {!! Form::submit('Check In', ['class'=>'btn btn-primary']) !!}
    </div>
</div>