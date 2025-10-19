
@props(['route'])
<div>
    <!-- The whole future lies in uncertainty: live immediately. - Seneca -->
    <button class="btn btn-round btn-icon border" onclick="window.location.href='{{ route($route) }}'">
        <i class="fas fa-redo" style="font-size: 15px"></i>
    </button>
</div>