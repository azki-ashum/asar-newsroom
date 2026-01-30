@if (function_exists('get_galleries') && $galleries->isNotEmpty())
    <div class="gallery-wrap">
        @foreach ($galleries as $gallery)
            <div class="gallery-item">
                <div class="img-wrap">
                    @php
                        $galleryLink = !empty($gallery->url_1) ? $gallery->url_1 : $gallery->url;
                    @endphp
                    <a href="{{ $galleryLink }}" class="d-inline-block" target="_blank" rel="noopener">
                        {{ RvMedia::image($gallery->image, $gallery->name, 'medium') }}
                    </a>
                </div>
                <div class="gallery-detail">
                    <div class="gallery-title">
                        <a href="{{ $galleryLink }}" target="_blank" rel="noopener">
                            {{ $gallery->name }}
                        </a>
                    </div>
                    @if (!empty($gallery->caption_url_1))
                        <div class="gallery-caption">{{ $gallery->caption_url_1 }}</div>
                    @elseif (trim($gallery->user->name))
                        <div class="gallery-author">
                            {{ __('By :name', ['name' => $gallery->user->name]) }}
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div style="clear: both"></div>
@endif
