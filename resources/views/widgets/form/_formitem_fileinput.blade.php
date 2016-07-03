
<div class="form-group {!! $errors->has($name) ? 'has-error' : null !!}">
    <label class="control-label">File input</label>
    {!! Form::file('fileinput') !!}
</div>