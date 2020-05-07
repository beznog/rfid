@extends('main')
@section('content')
    <ul>
        @foreach ($items as $item)
            <li>
                <div>
                    <div class="thumbnail" style="float: left; margin-right: 20px;">
                        @isset($item->images[0]['thumbnail_url'])
                            <img src="{{ asset('storage/'.$item->images[0]['thumbnail_url']) }}">
                        @endisset
                    </div>
                    <div>
                        id: {{ $item->id }}
                        <br>
                        Type: {{ $item->itemTypes['item_type'] }}
                        <br>
                        Name: {{ $item->name }}
                        @isset($item->description)
                            <br>
                            Description: {{ $item->description }}
                        @endisset
                        @isset($item->tagId)
                            <br>
                            Tag ID: {{ $item->tagId }}
                        @endisset
                        <br>
                        {{ link_to_action('ItemController@autocompleteEditForm', 'edit', $parameters = array($item->id), $attributes = array('target' => '_blank')) }}  {{ link_to_action('ItemController@delete', 'delete', $parameters = array($item->id), $attributes = array()) }}
                    </div>
                </div>
                <br>
                <br>            
            </li>
        @endforeach
    </ul>
@endsection