<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {!! Form::label('name', 'Name', ['class'=>'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('name', null, ['class'=>'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    {!! Form::label('email', 'Email', ['class'=>'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text('email', null, ['class'=>'form-control']) !!}
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
    {!! Form::label('role', 'Role', ['class'=>'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::select('role',$sec,null, ['class'=>'form-control']) !!}
        {!! $errors->first('role', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group">
    <div class="col-md-4 col-md-offset-2">
        {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
    </div>
</div>
