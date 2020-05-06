@extends('main')
@section('content')
    <ul>
        @foreach ($words as $word)
            <li>
                <div>
                    <div class="thumbnail" style="float: left; margin-right: 20px;">
                        @isset($word->images[0]['thumbnail_url'])
                            <img src="{{ $word->images[0]['thumbnail_url'] }}">
                        @endisset
                    </div>
                    <div>
                @isset($word->id)
                    id: {{ $word->id }}
                @endisset
                <br>
                @isset($word->wordTypes['word_type'])
                    Type: {{ $word->wordTypes['word_type'] }}
                @endisset
                <br>
                @if ($word->wordTypes['word_type'] == "noun")
                    {{ $word->addParams['article_type'] }}
                @endif
                {{ $word->morphemes['morpheme'] }}

                @if ($word->addParams['reflexive'])
                    sich
                @endif
                @isset($word->addParams['preposition'])
                    {{ $word->addParams['preposition'] }}
                @endisset

                @if ($word->wordTypes['word_type'] == "noun")
                    (pl. {{ $word->addParams['plural'] }})
                @endif
                    - 
                @foreach ($word->translates as $translate)
                    {{ $translate->translate }}
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
                
                @isset($word->addParams['prasens'])
                    <br>
                    {{ $word->addParams['prasens'] }}
                @endisset
                @isset($word->addParams['prateritum'])
                    {{ $word->addParams['prateritum'] }}
                @endisset
                @isset($word->addParams['partizip'])
                    @isset($word->addParams['modal_verb'])
                        {{ $word->addParams['modal_verb'] }}
                    @endisset
                    {{ $word->addParams['partizip'] }}
                @endisset
                
                @isset($word->addParams['examples'])
                    <br>
                    examples: {{ $word->addParams['examples'] }}
                @endisset
                
                @isset($word->addParams['importance'])
                    <br>
                    importance: {{ $word->addParams['importance'] }},
                @endisset
                @isset($word->addParams['complexity'])
                    complexity: {{ $word->addParams['complexity'] }},
                @endisset   
                @isset($word->addParams['knowledge'])
                    knowledge: {{ $word->addParams['knowledge'] }}
                @endisset
                <br>
                @isset($word->collections)
                    Collections: 
                    @foreach ($word->collections as $collection)
                        {{ $collection->collection }}@if(!$loop->last), @endif
                    @endforeach
                @endisset
                <br>
                {{ link_to_action('WordsController@autocompleteEditForm', 'edit', $parameters = array($word->id), $attributes = array('target' => '_blank')) }}  {{ link_to_action('WordsController@delete', 'delete', $parameters = array($word->id), $attributes = array()) }}
                    </div>
                </div>
                <br>
                <br>            
            </li>
        @endforeach
    </ul>
@endsection