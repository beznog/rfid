@extends('main')
@section('content')
    <ul>
        @foreach ($items as $item)
            <li>
                <div>
                    <div class="thumbnail" style="float: left; margin-right: 20px;">
                        @isset($word->images[0]['thumbnail_url'])
                            <img src="{{ $item->images[0]['thumbnail_url'] }}">
                        @endisset
                    </div>
                    <div>
                        id: {{ $item->id }}
                        <br>
                        Type: {{ $item->itemTypes['item_type'] }}
                        <br>
                        Name: {{ $item->name }}
                        @isset($word->description)
                            <br>
                            Description: {{ $word->description }}
                        @endisset
                        @isset($word->tagId)
                            <br>
                            Tag ID: {{ $word->tagId }}
                        @endisset

                        {{ link_to_action('ItemController@autocompleteEditForm', 'edit', $parameters = array($item->id), $attributes = array('target' => '_blank')) }}  {{ link_to_action('ItemController@delete', 'delete', $parameters = array($item->id), $attributes = array()) }}
                    </div>
                </div>
                <br>
                <br>            
            </li>
        @endforeach
    </ul>
@endsection