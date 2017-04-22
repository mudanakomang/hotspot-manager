
@if($user->hasRole('admin') || $user->hasRole('master'))
  <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
      {!! Form::label('group', 'Group', ['class'=>'col-md-2 control-label']) !!}
      <div class="col-md-4">
          {!! Form::select('group', ['GuestInHouse'=>'Guest In House','Public'=>'Public'],null, ['class'=>'form-control '])  !!}
          {!! $errors->first('group', '<p class="help-block">:message</p>') !!}
      </div>
  </div>
@else
  <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
      {!! Form::label('group', 'Group', ['class'=>'col-md-2 control-label']) !!}
      <div class="col-md-4">
          {!! Form::select('group', ['GuestInHouse'=>'Guest In House'],null, ['class'=>'form-control '])  !!}
          {!! $errors->first('group', '<p class="help-block">:message</p>') !!}
      </div>
  </div>
@endif

<div class="form-group{{ $errors->has('num') ? ' has-error' : '' }}">
    {!! Form::label('num', 'Voucher Number', ['class'=>'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('num', null, ['class'=>'form-control '])  !!}
        {!! $errors->first('num', '<p class="help-block">:message</p>') !!}
    </div>
    </div>
<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
    {!! Form::label('description', 'Description', ['class'=>'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::textarea('description', null, ['class'=>'form-control '])  !!}
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>



<div class="form-group">
    <div class="col-md-4 col-md-offset-2">
        {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
    </div>
</div>
