@php $current_locale=app()->getLocale() @endphp
<div class="btn-group" role="group" aria-label="Basic outlined example">
    @foreach(config('app.available_locales') as $locale_name => $available_locale)
        @if($available_locale === $current_locale)
            <a type="button" class="btn btn-primary text-light btn-sm">{{$locale_name}}</a>
        @else
            <a type="button" class="btn btn-outline-primary  btn-sm" href="{{ route('changeLang',['locale'=>$available_locale]) }}">{{ $locale_name }}</a>
        @endif
    @endforeach
</div>
