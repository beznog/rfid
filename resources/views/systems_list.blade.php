@extends('main')
@section('content')

@if(!empty($systems))
    <ul class="accordion cell small-12" data-accordion data-allow-all-closed="true" data-multi-expand="true">
        @foreach ($systems as $system)
            <li class="accordion-item " data-accordion-item>
                <a href="#" class="accordion-title">
                    <div class="media-object cell small-12 callout alert" data-tagid="{{ $system->tag_id }}">
                        <div class="media-object-section">
                            <div class="thumbnail" style="background-image: url('{{ (isset($system->images)) ? asset('storage/'.$system->images->first()['thumbnail_url']) : '' }}');">
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
                        @if(!empty($system->components))
                            <ul class="accordion cell small-12" data-accordion data-allow-all-closed="true" data-multi-expand="true">
                                @foreach ($system->components as $component)
                                    <li class="accordion-item " data-accordion-item>
                                        <a href="#" class="accordion-title">
                                            <div class="media-object cell small-12 callout alert" data-tagid="{{ $component->tag_id }}">
                                                <div class="media-object-section">
                                                    <div class="thumbnail" style="background-image: url('{{ (isset($component->images)) ? asset('storage/'.$component->images->first()['thumbnail_url']) : '' }}');">
                                                    </div>
                                                </div>
                                                <div class="media-object-section">
                                                    <h4>{{ $component->name }}</h4>
                                                    <p>{{ $component->description }}</p>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="accordion-content" data-tab-content>
                                            @if(!empty($component->elements))
                                                @foreach ($component->elements as $element)
                                                    <div class="media-object cell small-12 callout alert" data-tagid="{{ $element->tag_id }}">
                                                        <div class="media-object-section">
                                                            <div class="thumbnail" style="background-image: url('{{ (isset($element->images)) ? asset('storage/'.$element->images->first()['thumbnail_url']) : '' }}');">
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
        @endforeach
    </ul>  
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
            var scannedId = JSON.stringify(data.itemId);
            var param = $("body").find($('[data-tagid='+ scannedId +']'));
            $(param).removeClass('alert');
            $(param).addClass('success');
            console.log(param);
        });
    </script>
@endsection
