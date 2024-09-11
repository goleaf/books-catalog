@if ($sortBy !== $field)
    <i class="fas fa-sort"></i>
@elseif ($sortDirection == 'asc')
    <i class="fas fa-sort-up"></i>
@else
    <i class="fas fa-sort-down"></i>
@endif
