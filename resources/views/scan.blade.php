@extends('main')
@section('content')

<div class="navi-btn-container cell small-12">
    <a href="{{ url()->previous() }}" class="button">
      <i class="fi-arrow-left"></i>
      Back
    </a>
</div>

@if(!empty($system))
  <div class="card">
    <div class="card-divider">
      <h2>{{ $system->name }}</h2>
      <a class="icon-button" href="{{ asset('edit/'.$system->id) }}">
        <i class="fi-pencil"></i>
      </a>
    </div>
    <div class="card-thumbnail" style="background-image: url('{{ (!empty($system->images->count())) ? asset('storage/'.$system->images->first()['url']) : asset('storage/no-image.png') }}');">
    </div>
    <div class="card-section">
      <p>{{ $system->description }}</p>
      @if(!empty($system->components->count()))
            <h3>Components: </h3>
            @foreach ($system->components as $component)
              <ul class="accordion cell small-12" data-accordion data-allow-all-closed="true" data-multi-expand="true"> 
                <li class="accordion-item " data-accordion-item>
                    <a href="#" class="accordion-title">
                        <div class="media-object cell small-12 callout alert" data-tagid="{{ $component->tag_id }}">
                           <div class="media-object-section scanned-status">
                            </div>
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
                          <h3>Elements: </h3>
                          @foreach ($component->elements as $element)
                            <div class="media-object cell small-12 callout alert" data-tagid="{{ $element->tag_id }}">
                               <div class="media-object-section scanned-status">
                                </div>
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
              </ul>
            @endforeach
      @else
        <div class="callout secondary">
            <h5>This system hasn't any components</h5>
        </div>
    @endif
    </div>
  </div>
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
              markItem(param);
            }
        });

        function markItem(param) {
          if($(param).hasClass('alert')) {
            $(param).removeClass('alert');
          }
          $(param).addClass('success');
          isLastScannedChild(param);
        }

        function isLastScannedChild(param) {
          var parentObj = $(param).parents('.accordion');
          if($(parentObj).find('.alert').size()==0) {
            markItem($(parentObj).find('.accordion-title .media-object'));
          }
        }
    </script>
@endsection
