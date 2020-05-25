@extends('main')
@section('content')

    <div class="navi-btn-container cell small-12">
        <a href="{{ url()->previous() }}" class="button">
          <i class="fi-arrow-left"></i>
          Back
        </a>
    </div>

    <ul>
        @foreach ($items as $item)
            <li>
                <div class="media-object cell small-12 callout secondary" data-tagid="{{ $item->tag_id }}">
                    <div class="media-object-section">
                        <div class="thumbnail" style="background-image: url('{{ (!empty($item->images->count())) ? asset('storage/'.$item->images->first()['thumbnail_url']) : asset('storage/no-image.png') }}');">
                        </div>
                    </div>
                    <div class="media-object-section">
                        <h6>Type: {{ $item->item_type_id }}</h6>
                        <h4>{{ $item->name }}</h4>
                        <p>{{ $item->description }}</p>

                        <div class="buttons-container">
                            <a class="button primary" target="_self" href="{{ asset('scan/'.$item->id) }}">
                                <i class="fi-sound"></i>
                                Scan
                            </a>
                            <a class="button primary" target="_self" href="{{ asset('edit/'.$item->id) }}">
                                <i class="fi-pencil"></i>
                                Edit
                            </a>
                            <a class="button primary" target="_self" href="{{ asset('delete/'.$item->id) }}">
                                <i class="fi-trash"></i>
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endsection
