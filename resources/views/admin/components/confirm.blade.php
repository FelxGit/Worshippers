<?php
  $color = 'white'; // Default color

  if ($type === 'confirm-danger') {
      $color = '#dc4c64';
  } elseif ($type === 'confirm-warning') {
      $color = 'rgba(255, 152, 0)';
  } elseif ($type === 'confirm-info') {
      $color = 'rgba(86, 204, 242)';
  }
?>
<!-- Modal -->
<div class="modal modal-confirm fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body" style="border-top: 5px solid {{ $color }}; border-radius: 5px">
        <div class="confirm-content">
          <i class="sign fa-solid fa-triangle-exclamation" style="color: {{ $color }}"></i>
          <span>
            <h4>{{ $title ? : '' }}</h4>
            <span class="modal-description">{{ $description ? : '' }}</span>
          </span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
        <button onClick="{{ $onConfirm }}" type="button" class="btn btn-danger">Save changes</button>
      </div>
    </div>
  </div>
</div>