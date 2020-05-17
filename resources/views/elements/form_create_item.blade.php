@if(count($errors))
    <div class="form-group">
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif


{{ Form::open([
                'url' => (empty($item)) ? '/add' : '/edit/'.$item->id, 
                'id' => (empty($item)) ? 'add' : 'edit', 
                'files' => true,
                'enctype' => 'multipart/form-data',
                'class' => 'grid-x grid-padding-x', 
                'autocomplete' => 'off', 
                'name' => (empty($item)) ? 'add' : 'edit'
            ]) 
}}


@isset($item['id'])
    {{ Form::hidden(
            'id', 
            $value = $item->id, 
            $attributes = array(
                'id'=>'item_id_hidden'
            )
    )}}
@endisset

<div class="cell small-12 parameter default" data-parameter-name="item">
{{ Form::text(
        'name', 
        $value = (isset($item->name)) ? $item->name : '', 
        $attributes = array(
            'id'=>'name_text', 
            'placeholder'=>'Name', 
            'autocomplete'=>'off'
        )
)}}    
</div>

<div class="cell small-12 parameter" data-parameter-name="preposition">
    {{ Form::select(
            'item_type_id', 
            [
                '1' => 'System', 
                '2' => 'Component',
                '3' => 'Element',
            ], 
            (!empty($item->item_type_id)) ? $item->item_type_id : null,
            (!empty($item->item_type_id)) ? [] : ['placeholder' => 'Type']
    )}}
</div>

<div class="cell small-12 parameter default" data-parameter-name="description">
    {{ Form::textarea(
                'description', 
                (isset($item->description)) ? $item->description : null, 
                [
                    'placeholder'=>'Description'
                ]
    )}}
</div>


<div class="cell small-12 parameter default" data-parameter-name="images">
    <span class="added-image">
        @isset($item)
            @isset($item->images->first()->thumbnail_url)
                <div class="image">
                    <div class="thumbnail" style="background-image: url({{  (!empty($item->images->first()->thumbnail_url)) ? asset('storage/'.$item->images->first()->thumbnail_url) : asset('storage/no-image.png')  }});">
                        <a href="{{ asset('delete/image/'.$item->id) }}">
                            <i class="fi-trash delete-button"></i>
                        </a>
                    </div>
                </div>
            @endisset
        @endisset
    </span>
    {{ Form::file(
            'images'
    )}}
</div>


<ul class="accordion cell small-12 show-items show-all-components parameter" data-accordion data-allow-all-closed="true" data-multi-expand="true">
    <li class="accordion-item " data-accordion-item>
        <a href="#" class="accordion-title">
            Show all components
        </a>
        <div class="accordion-content" data-tab-content>
            <div class="cell small-12">
                @if(!empty($components->count()))

                    @if(!empty($item->components))
                        @php
                            $relatedComponents = $item->components->pluck('id')->toArray();
                        @endphp
                    @endif
                    
                    @foreach ($components as $component)
                            <div class="media-object cell small-12 callout secondary" data-tagid="{{ $component->tag_id }}">
                                <div class="media-object-section">
                                    <div class="switch">
                                      <input class="switch-input" id="component-{{ $component->id }}" type="checkbox" name="components[]" value="{{ $component->id }}" 
                                      @if(!empty($relatedComponents))
                                            @if (in_array($component->id, $relatedComponents)) checked="true" @endif
                                      @endif                                      
                                      >
                                      <label class="switch-paddle" for="component-{{ $component->id }}">
                                        <span class="show-for-sr">{{ $component->name }}}</span>
                                      </label>
                                    </div>
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
                    @endforeach
                @else
                    <div class="callout secondary">
                        <h5>No components</h5>
                    </div>
                @endif
            </div>
        </div>
    </li>
</ul> 


<ul class="accordion cell small-12 show-items show-all-elements parameter" data-accordion data-allow-all-closed="true" data-multi-expand="true">
    <li class="accordion-item " data-accordion-item>
        <a href="#" class="accordion-title">
            Show all elements
        </a>
        <div class="accordion-content" data-tab-content>
            <div class="cell small-12">
                @if(!empty($elements->count()))
                    
                    @if(!empty($item->elements))
                        @php
                            $relatedElements = $item->elements->pluck('id')->toArray();
                        @endphp
                    @endif

                    @foreach ($elements as $element)
                            <div class="media-object cell small-12 callout secondary" data-tagid="{{ $element->tag_id }}">
                                <div class="media-object-section">
                                    <div class="switch">
                                      <input class="switch-input" id="element-{{ $element->id }}" type="checkbox" name="elements" value="{{ $element->id }}"
                                      @if(!empty($relatedElements))
                                            @if (in_array($element->id, $relatedElements)) checked="true" @endif
                                      @endif 
                                      >
                                      <label class="switch-paddle" for="element-{{ $element->id }}">
                                        <span class="show-for-sr">{{ $component->name }}}</span>
                                      </label>
                                    </div>
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
                        <h5>No element</h5>
                    </div>
                @endif
            </div>
        </div>
    </li>
</ul> 





<div class="cell small-12 parameter default" data-parameter-name="tag_id">
    {{ Form::text(
            'tag_id', 
            $value = (isset($item['tagId'])) ? $item['tagId'] : '', 
            $attributes = array(
                'placeholder'=>'Tag ID'
            )
    )}}
</div>


<div class="cell small-12 parameter default">
    {{ Form::submit('Submit', ['class'=>'button cell small-12']) }}
</div>


{!! Form::close() !!}
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
        for (var i=0; i<1; i++) {
          console.log(dataJSON.itemIds[i]);
          $("body").find($('[name=tag_id]')).val(dataJSON.itemIds[i]);
        }
    });


    showChildrenFromItemType($('[name=item_type_id]').val());

    $('[name=item_type_id]').on('change', function() {
        console.log(this.value);
        showChildrenFromItemType(this.value);
    });


    function showChildrenFromItemType(value) {
        $('.show-items').addClass('hide');
        if(value == 1) {
            $('.show-all-components').removeClass('hide');
        }
        else if(value == 2) {
            $('.show-all-elements').removeClass('hide');
        }
    }

</script>