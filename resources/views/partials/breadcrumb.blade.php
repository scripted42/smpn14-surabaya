@props(['items' => []])

<nav class="breadcrumb-nav" aria-label="Breadcrumb">
    <div class="container">
        <ol class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Beranda</a>
            </li>
            @foreach($items as $item)
                <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}" {{ $loop->last ? 'aria-current=page' : '' }}>
                    <span class="breadcrumb-separator">/</span>
                    @if(!empty($item['url']) && !$loop->last)
                        <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                    @else
                        <span>{{ $item['label'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</nav>
