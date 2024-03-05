<a id="aPopup-{{ $task['id_task'] }}" href="#" onclick="openPopup({{ $task['id_task'] }}, '{{ $task['status_c'] }}'); return false;" data-bs-toggle="tooltip" data-bs-html="true" title="<b>{{ __('babel.'.$task['status_c'])}} : </b>{{ $task['status_description'] }}">
    <span class="badge" style="
        @if ($task['html_color'])
            color:{{ $task['html_color'] }};
            background: {{ convertOpacity($task['html_color']) }}
        @else
            color:#70AD47;
            background: {{ convertOpacity('#70AD47')}}
        @endif
    ">
        @if (isset($task['status_c']))
            {{ __('babel.'.$task['status_c']) }}
        @else
            New
        @endif
    </span>
</a>
