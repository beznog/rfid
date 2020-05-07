<div class="card news-card" data-id="@isset($card['id']){{ $card['id'] }}@endisset">
  <img src="@isset($card['images'][0]['thumbnail_url']){{ $card['images'][0]['thumbnail_url'] }}@endisset">
  <div class="card-section">
    {{-- <div class="news-card-date">Sunday, 16th April</div> --}}
    <article class="news-card-article">
      <h4 class="news-card-title">@isset($card['addParams']['article_type']){{ $card['addParams']['article_type'] }}@endisset @isset($card['morpheme']){{ ucfirst($card['morpheme']) }}@endisset {{ (!empty($card['addParams']['plural'])) ? '(pl. '.ucfirst($card['addParams']['plural']).')' : '' }}</h4>
      <h6 class="news-card-title">{{ (!empty($card['addParams']['prasens'])) ? $card['addParams']['prasens'].' -' : '' }} {{ (!empty($card['addParams']['prateritum'])) ? $card['addParams']['prateritum'].' -' : '' }} {{ (!empty($card['addParams']['partizip'])) ? $card['addParams']['modal_verb'].' '.$card['addParams']['partizip'] : '' }}</h6>
      <h6 class="news-card-title">{{ (isset($card['translate'])) ? implode(', ', $card['translate']) : '' }}</h6>
      <p class="news-card-description">{{ (!empty($card['addParams']['examples'])) ? $card['addParams']['examples'] : '' }}</p>
      <p class="news-card-description">importance: {{ (!empty($card['addParams']['importance'])) ? $card['addParams']['importance'] : '' }} complexity: {{ (!empty($card['addParams']['complexity'])) ? $card['addParams']['complexity'] : '' }} knowledge: {{ (!empty($card['addParams']['knowledge'])) ? $card['addParams']['knowledge'] : '' }}</p>
    </article>
    <div class="news-card-tag">
    @if(!empty($card['collections']))
        @foreach ($card['collections'] as $collection)
            <span class="label"><a href="#">{{ $collection }}</a></span>
        @endforeach
    @endif

    </div>






    {{--
    <div class="news-card-author">
      <div class="news-card-author-image">
        <img src="https://i.imgur.com/lAMD2kS.jpg" alt="user">
      </div>
      <div class="news-card-author-name">
        By <a href="#">Harry Manchanda</a>
      </div>
    </div>
    --}}
  </div>
</div>
