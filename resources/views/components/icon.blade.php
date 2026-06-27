@props(['name', 'class' => 'svg-icon svg-icon-2'])

@switch($name)

    {{-- Dashboard --}}
    @case('dashboard')
        <span {{ $attributes->merge(['class' => $class]) }}>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                <rect x="2" y="2" width="9" height="9" rx="2" fill="black"/>
                <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black"/>
                <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black"/>
                <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black"/>
            </svg>
        </span>
        @break

    {{-- Product --}}
    @case('product')
        <span {{ $attributes->merge(['class' => $class]) }}>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                <path d="M21 9V11C21 11.6 20.6 12 20 12H14V8H20C20.6 8 21 8.4 21 9Z" fill="black"/>
                <path d="M15 2C13.3 2 12 3.3 12 5V8H15C16.7 8 18 6.7 18 5C18 3.3 16.7 2 15 2Z" fill="black"/>
                <path opacity="0.3" d="M9 2C10.7 2 12 3.3 12 5V8H9C7.3 8 6 6.7 6 5C6 3.3 7.3 2 9 2Z" fill="black"/>
            </svg>
        </span>
        @break

    {{-- Category --}}
    @case('category')
        <span {{ $attributes->merge(['class' => $class]) }}>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                <path d="M4 4H10V10H4V4Z" fill="black"/>
                <path opacity="0.3" d="M14 4H20V10H14V4Z" fill="black"/>
                <path opacity="0.3" d="M14 14H20V20H14V14Z" fill="black"/>
                <path opacity="0.3" d="M4 14H10V20H4V14Z" fill="black"/>
            </svg>
        </span>
        @break

    {{-- Order --}}
    @case('order')
        <span {{ $attributes->merge(['class' => $class]) }}>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                <path opacity="0.3" d="M4 4H20V20H4V4Z" fill="black"/>
                <path d="M7 9H17V11H7V9Z" fill="black"/>
                <path d="M7 13H17V15H7V13Z" fill="black"/>
            </svg>
        </span>
        @break

    {{-- Default --}}
    @default
        <span {{ $attributes->merge(['class' => $class]) }}>
            ⚙️
        </span>

@endswitch