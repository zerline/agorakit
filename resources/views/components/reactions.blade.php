@props(['model'])

<div id="model-{{$model->id}}">

    <div class="flex align-items-center mt-2">
        @foreach ($model->reactions as $reaction)
        @if (Auth::check() && Auth::user()->is($reaction->user))
        <a up-target="#model-{{$model->id}}" class="m-0 p-0 h-5 w-5 mr-1"
            href="{{route('reaction.unreact', ['model' => $model->modelName, 'id' => $model->id])}}">
            <img alt="{{ $reaction->type }}" src="{{asset('/images/reactions/' . $reaction->type . '.png')}}" class="image-cover h-5 w-5"
                title="{{ $reaction->user->name }} - click to remove" />
        </a>
        @else

            @if ($reaction->user)
            <img alt="{{ $reaction->type }}" src="{{asset('/images/reactions/' . $reaction->type . '.png')}}" class="image-cover h-5 w-5 mr-1"
                title="{{ $reaction->user->name }}" />
            @endif

        @endif
        @endforeach


        @can('react', $model)
        <div class="dropdown">
            <a class="cursor-pointer d-flex align-items-center bg-gray-s300 text-gray-700 rounded-lg text-xs opacity-25 hover:opacity-100"
                type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img alt="" src="{{asset('/images/reactions/reaction.svg')}}" class="image-cover h-5 w-5"
                    title="Add a reaction" />

            </a>

            <div class="dropdown-menu dropdown-menu-left grid-cols-3 p-2" aria-labelledby="dropdownMenuButton">

                @foreach (setting()->getArray('reactions') as $reaction)
                <a up-target="#model-{{$model->id}}" class="no-underline"
                    href="{{route('reaction.react', ['model' => $model->modelName, 'id' => $model->id, 'reaction'=> $reaction])}}">
                    <img alt="{{ $reaction }}" src="{{asset('/images/reactions/' . $reaction . '.png')}}"
                        class="image-cover h-8 w-8 hover:bg-gray-300 p-1 rounded" title="{{$reaction}}" />
                </a>
                @endforeach

            </div>
        </div>
        @endcan


    </div>
</div>