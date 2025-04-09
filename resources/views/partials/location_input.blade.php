@if (is_a($model, "App\Action"))
    <fieldset id="new" class="form-fieldset">
        <div class="small-help">
            <i class="fas fa-info-circle"></i>
            {{trans('messages.listed_location')}}
        </div>
        {!! Form::label('listed_location', trans('Will this event take place in one of these locations?') . ':') !!}
        {!! Form::select('listed_location', [''=> ' --- '] + $listedLocations + ['other' => trans('Other')]],
	    null,
	    ['class' => 'form-control mb-4'])
	!!}
    <p><strong>{{ trans('Otherwise please enter your venue here:') }}</strong></p>
    </fieldset>
@endif

    <fieldset id="new" class="form-fieldset">
      <label class="form-label h3">{{trans('messages.location')}}</label>
        <div class="small-help mb-3">
            <i class="fas fa-info-circle"></i>
            {{ trans('messages.location_privacy_and_help') }}
        </div>
        {!! Form::label('location[street]', trans('Street Address') . ':') !!}
        {!! Form::text('location[street]', $model->location->street, ['class' => 'form-control mb-3', 'size' => '100']) !!}
        {!! Form::label('location[city]', trans('City') . ':') !!}
        {!! Form::text('location[city]', $model->location->city, ['class' => 'form-control mb-3', 'size' => '30']) !!}
        {!! Form::label('location[county]', trans('County') . ':') !!}
        <div class="small-help">
            <i class="fas fa-info-circle"></i>
            {{ trans('messages.county_help') }}
        </div>
        {!! Form::text('location[county]', $model->location->county, ['class' => 'form-control mb-3', 'size' => '30']) !!}
        {!! Form::label('location[country]', trans('Country') . ':') !!}
        {!! Form::text('location[country]', $model->location->country, ['class' => 'form-control mb-3', 'size' => '30']) !!}
        {!! Form::label('location[name]', trans('Location Name') . ':') !!}
        <div class="small-help">
            <i class="fas fa-info-circle"></i>
            {{ trans('messages.location_name_help') }}
            {!! Form::text('location[name]', $model->location->name, ['class' => 'form-control']) !!}
        </div>
    </fieldset>
