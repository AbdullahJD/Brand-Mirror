<div class="language-switcher d-inline-flex align-items-center {{ $class ?? '' }}">
    @if (app()->getLocale() === 'ar')
        <a href="{{ route('lang.switch', 'en') }}"
           class="btn btn-sm {{ $btnClass ?? 'btn-outline-primary' }}"
           title="{{ __('messages.english') }}">
            English
        </a>
    @else
        <a href="{{ route('lang.switch', 'ar') }}"
           class="btn btn-sm {{ $btnClass ?? 'btn-outline-primary' }}"
           title="{{ __('messages.arabic') }}">
            العربية
        </a>
    @endif
</div>
