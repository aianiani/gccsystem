<!-- Reset Confirmation Modal -->
<div class="modal fade" id="resetLogsModal" tabindex="-1" aria-labelledby="resetLogsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.logs.reset') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="resetLogsModalLabel">Confirm Reset</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p class="text-danger fw-bold">
            Are you sure you want to reset <u>all {{ $logType ?? 'logs and data' }}</u>? This action cannot be undone and will delete all {{ $logType ?? 'logs and data' }} from the system.
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Yes, Reset Everything</button>
        </div>
      </div>
    </form>
  </div>
</div> 