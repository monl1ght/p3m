@props([
    'id' => null,
    'name' => null,
    'value' => '',
    'options' => [],
    'placeholder' => null,
    'compact' => false,
    'class' => '',
])

@php
    $inputName = $name ?? $id;
    $currentVal = (string)($value ?? '');

    // Normalize options into list of [value, label, dot, icon, divider]
    $normalized = [];
    foreach ($options as $key => $opt) {
        if (is_array($opt)) {
            $val = (string)($opt['value'] ?? $key);
            $lbl = $opt['label'] ?? $val;
            $dot = $opt['dot'] ?? null;
            $icon = $opt['icon'] ?? null;
            $divider = !empty($opt['divider']);
        } else {
            $val = (string)$key;
            $lbl = (string)$opt;
            $dot = null;
            $icon = null;
            $divider = false;
        }
        $normalized[] = [
            'value' => $val,
            'label' => $lbl,
            'dot' => $dot,
            'icon' => $icon,
            'divider' => $divider,
        ];
    }

    // Determine current selected option
    $selectedOption = null;
    foreach ($normalized as $item) {
        if ((string)$item['value'] === $currentVal) {
            $selectedOption = $item;
            break;
        }
    }

    if (!$selectedOption && count($normalized) > 0) {
        $selectedOption = $normalized[0];
    }

    $activeLabel = $selectedOption ? $selectedOption['label'] : ($placeholder ?? 'Pilih...');
    $isFiltered = ($currentVal !== '');
@endphp

<div class="p3m-custom-dropdown {{ $compact ? 'p3m-dropdown-compact' : '' }} {{ $class }}"
     @if($id) id="dropdown_{{ $id }}" @endif>
    <button type="button"
            class="p3m-dropdown-trigger"
            aria-haspopup="listbox"
            aria-expanded="false">
        <span class="p3m-dropdown-label">{{ $activeLabel }}</span>
        <i class="fas fa-chevron-down p3m-dropdown-chevron"></i>
    </button>

    <div class="p3m-dropdown-menu" role="listbox">
        @foreach ($normalized as $item)
            @php
                $isActive = ((string)$item['value'] === $currentVal);
            @endphp
            <div class="p3m-dropdown-item {{ $isActive ? 'active' : '' }}"
                 data-value="{{ $item['value'] }}"
                 data-label="{{ $item['label'] }}"
                 data-dot="{{ $item['dot'] ?? '' }}"
                 data-icon="{{ $item['icon'] ?? '' }}"
                 role="option"
                 aria-selected="{{ $isActive ? 'true' : 'false' }}">
                <span class="p3m-dropdown-item-content">
                    @if(!empty($item['dot']))
                        <span class="p3m-dropdown-dot {{ $item['dot'] }}"></span>
                    @elseif(!empty($item['icon']))
                        <i class="{{ $item['icon'] }}"></i>
                    @endif
                    <span class="p3m-dropdown-item-text">{{ $item['label'] }}</span>
                </span>
                <i class="fas fa-check p3m-dropdown-check"></i>
            </div>
            @if(!empty($item['divider']))
                <div class="p3m-dropdown-divider"></div>
            @endif
        @endforeach
    </div>

    @if($id || $inputName)
        <input type="hidden"
               @if($id) id="{{ $id }}" @endif
               @if($inputName) name="{{ $inputName }}" @endif
               value="{{ $currentVal }}">
    @endif
</div>
