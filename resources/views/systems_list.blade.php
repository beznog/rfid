@extends('main')
@section('content')

@if(!empty($systems->count()))
        @foreach ($systems as $system)
        <div class="buttons-container">
            <a class="button primary" target="_self" href="{{ asset('scan/'.$system->id) }}">
                <i class="fi-sound"></i>
                Scan
            </a>
            <a class="button primary" target="_self" href="{{ asset('edit/'.$system->id) }}">
                <i class="fi-pencil"></i>
                Edit
            </a>
            <a class="button primary" target="_self" href="{{ asset('delete/'.$system->id) }}">
                <i class="fi-trash"></i>
                Delete
            </a>
        </div>
        <ul class="accordion cell small-12" data-accordion data-allow-all-closed="true" data-multi-expand="true">
            <li class="accordion-item " data-accordion-item>
                <a href="#" class="accordion-title">
                    <div class="media-object cell small-12 callout secondary" data-tagid="{{ $system->tag_id }}">
                        <div class="media-object-section">
                            <div class="thumbnail" style="background-image: url('{{ (!empty($system->images->count())) ? asset('storage/'.$system->images->first()['thumbnail_url']) : asset('storage/no-image.png') }}');">
                            </div>
                        </div>
                        <div class="media-object-section">
                            <h4>{{ $system->name }}</h4>
                            <p>{{ $system->description }}</p>
                        </div>
                    </div>
                </a>

                <div class="accordion-content" data-tab-content>
                    <div class="cell small-12">
                        @if(!empty($system->components->count()))
                            <ul class="accordion cell small-12" data-accordion data-allow-all-closed="true" data-multi-expand="true">
                                @foreach ($system->components as $component)
                                    <div class="buttons-container">
                                        <a class="button primary" target="_self" href="{{ asset('scan/'.$component->id) }}">
                                            <i class="fi-sound"></i>
                                            Scan
                                        </a>
                                        <a class="button primary" target="_self" href="{{ asset('edit/'.$component->id) }}">
                                            <i class="fi-pencil"></i>
                                            Edit
                                        </a>
				        <a class="button primary" target="_self" href="{{ asset('delete/'.$system->id) }}">
				            <i class="fi-trash"></i>
               			            Delete
				        </a>
                                    </div>
                                    <li class="accordion-item " data-accordion-item>
                                        <a href="#" class="accordion-title">
                                            <div class="media-object cell small-12 callout secondary" data-tagid="{{ $component->tag_id }}">
                                                <div class="media-object-section">
                                                    <div class="thumbnail" style="background-image: url('{{ (!empty($component->images->count())) ? asset('storage/'.$component->images->first()['thumbnail_url']) : asset('storage/no-image.png') }}');">
                                                    </div>
                                                </div>
                                                <div class="media-object-section">
                                                    <h4>{{ $component->name }}</h4>
                                                    <p>{{ $component->description }}</p>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="accordion-content" data-tab-content>

                                            @if(!empty($component->elements->count()))
                                                @foreach ($component->elements as $element)
                                                    <div class="buttons-container">
                                                        <a class="button primary" target="_self" href="{{ asset('scan/'.$element->id) }}">
                                                            <i class="fi-sound"></i>
                                                            Scan
                                                        </a>
                                                        <a class="button primary" target="_self" href="{{ asset('edit/'.$element->id) }}">
                                                            <i class="fi-pencil"></i>
                                                            Edit
                                                        </a>
            						<a class="button primary" target="_self" href="{{ asset('delete/'.$system->id) }}">
						            <i class="fi-trash"></i>
						            Delete
						        </a>
                                                    </div>
                                                    <div class="media-object cell small-12 callout secondary" data-tagid="{{ $element->tag_id }}">
                                                        <div class="media-object-section">
                                                            <div class="thumbnail" style="background-image: url('{{ (!empty($element->images->count())) ? asset('storage/'.$element->images->first()['thumbnail_url']) : asset('storage/no-image.png') }}');">
                                                            </div>
                                                        </div>
                                                        <div class="media-object-section">
                                                            <h4>{{ $element->name }}</h4>
                                                            <p>{{ $element->description }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="callout secondary">
                                                    <h5>This component hasn't any elements</h5>
                                                </div>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="callout secondary">
                                <h5>This system hasn't any components</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </li>
        </ul>  
        @endforeach
@else
    <div class="callout alert">
        <h5>No system found</h5>
    </div>
@endif
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('cf2a99a82e6f0c9cde6a', {
          cluster: 'eu'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            console.log(data);
            var dataJSON = JSON.stringify(data);
		dataJSON = JSON.parse(dataJSON);
		console.log(dataJSON.itemIds);
            for (var i=0; i<dataJSON.itemIds.length; i++) {
		console.log(dataJSON.itemIds[i]);
		var param = $("body").find($('[data-tagid=' + dataJSON.itemIds[i] +']'));
                $(param).removeClass('alert');
                $(param).addClass('success');

            }

            //var param = $("body").find($('[data-tagid='+ scannedId +']'));
            //$(param).removeClass('alert');
            //$(param).addClass('success');
//            console.log(scannedId);
        });
    </script>
@endsection
