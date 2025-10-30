@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    
    <!-- Page Title -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Assign Issues to {{ $device->name }}</h2>
        <p class="text-muted">Select issues and assign their estimated costs</p>
    </div>

    <!-- Card Wrapper -->
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('devices.assign-issues', $device->id) }}" method="POST">
                @csrf

                <!-- Issues List -->
                <div class="list-group mb-4">
                    @foreach($issues as $issue)
                        <div class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <div class="form-check">
                                <input type="checkbox" 
                                       name="issues[]" 
                                       value="{{ $issue->id }}" 
                                       id="issue-{{ $issue->id }}"
                                       class="form-check-input issue-checkbox">
                                <label for="issue-{{ $issue->id }}" class="form-check-label fw-semibold">
                                    {{ $issue->issue }}
                                </label>
                            </div>

                            <input type="number" 
                                   step="0.01" 
                                   name="costs[{{ $issue->id }}]" 
                                   placeholder="Cost"
                                   class="form-control form-control-sm w-25 ms-2 cost-input"
                                   style="display:none;">
                        </div>
                    @endforeach
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check2-circle me-1"></i> Assign Issues
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script for toggling cost inputs -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.issue-checkbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            let costInput = this.closest('.list-group-item').querySelector('.cost-input');
            if (this.checked) {
                costInput.style.display = 'inline-block';
                costInput.required = true;
            } else {
                costInput.style.display = 'none';
                costInput.required = false;
                costInput.value = '';
            }
        });
    });
});
</script>
@endsection
