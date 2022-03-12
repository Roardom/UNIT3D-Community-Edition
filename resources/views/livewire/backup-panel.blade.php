<div>
    <button id="create-backup" class="btn btn-primary btn-xs" style="margin-right: 16px;">
        {{ __('backup.create_a_new_backup') }}
    </button>
    <div class="dropdown" style="display: inline-block; margin-right: 16px;">
        <a class="dropdown btn btn-xs btn-success" data-toggle="dropdown" href="#" aria-expanded="true">
            <i class="{{ config('other.font-awesome') }} fa-line-columns"></i>
        </a>
        <ul class="dropdown-menu">
            <li role="presentation">
                <a role="menuitem" class="dropdown-item" href="#" id="create-backup-only-db"
                   wire:click.prevent="">
                    {{ __('backup.create_a_new_db_backup') }}
                </a>
                <a role="menuitem" class="dropdown-item" href="#" id="create-backup-only-files"
                   wire:click.prevent="">
                    {{ __('backup.create_a_new_files_backup') }}
                </a>
            </li>
        </ul>
    </div>
    <button wire:loading.attr="disabled" wire:click="updateBackupStatuses">
        <i class="{{ config('other.font-awesome') }} fa-sync" wire:loading.class="fa-spin"></i>
    </button>
</div>
<table class="data-table">
    <thead>
    <tr>
        <th scope="col">Disk</th>
        <th scope="col">Healthy</th>
        <th scope="col">Amount of backups</th>
        <th scope="col">Newest backup</th>
        <th scope="col">Used storage</th>
    </tr>
    </thead>
    <tbody>
        @forelse ($backupStatuses as $backupStatus)
            <tr>
                <td>{{ $backupStatus['disk'] }}</td>
                <td>
                    @if($backupStatus['healthy'])
                        <i class="{{ config('other.font-awesome') }} fa-check-circle" style="color: green"></i>
                    @else
                        <i class="{{ config('other.font-awesome') }} fa-times-circle" style="color: red"></i>
                    @endif
                </td>
                <td>{{ $backupStatus['amount'] }}</td>
                <td>{{ $backupStatus['newest'] }}</td>
                <td>{{ $backupStatus['usedStorage'] }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    No Backups
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
<x-panel :heading="__('backup.existing_backups')">
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('backup.location') }}</th>
                <th>{{ __('backup.date') }}</th>
                <th>{{ __('backup.file_size') }}</th>
                <th>{{ __('backup.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($files as $file)
                <tr>
                    <td>{{ $file['path'] }}</td>
                    <td>{{ $file['date'] }}</td>
                    <td>{{ $file['size'] }}</td>
                    <td>
                        <a
                            download
                            href="#"
                            target="_blank"
                            wire:click.prevent="downloadFile('{{ $file['path'] }}')"
                        >
                            <i class="{{ config('other.font-awesome') }} fa-download"></i>
                        </a>
                        <a
                            href="#"
                            target="_blank"
                            wire:click.prevent="showDeleteModal({{ $loop->index }})"
                        >
                            <i class="{{ config('other.font-awesome') }} fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        {{ 'No backups present' }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title mb-3">Delete backup</h5>
                    @if($deletingFile)
                        <span class="text-muted">
                    Are you sure you want to delete the backup created at {{ $deletingFile['date'] }} ?
                </span>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" wire:click="deleteFile">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-panel>

<script nonce="{{ Bepsvpt\SecureHeaders\SecureHeaders::nonce('script') }}">
  document.addEventListener('livewire:load', function () {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    })
    @this.updateBackupStatuses()
    @this.on('backupStatusesUpdated', function () {
    @this.getFiles()
    })
    @this.on('showErrorToast', function (message) {
      Toast.fire({
        text: message,
        duration: 10000,
        gravity: 'bottom',
        position: 'right',
        backgroundColor: 'red',
        className: 'toastify-custom',
      })
    })
    const backupFun = function (option = '') {
      Swal.fire({
        title: '<strong style=" color: rgb(17,17,17);">Success</strong>',
        icon: 'success',
        html: 'Creating a new backup in the background...' + (option ? ' (' + option + ')' : ''),
        showCloseButton: true,
      })
    @this.createBackup(option)
    }
    $('#create-backup').on('click', function () {
      backupFun()
    })
    $('#create-backup-only-db').on('click', function () {
      backupFun('only-db')
    })
    $('#create-backup-only-files').on('click', function () {
      backupFun('only-files')
    })
    const deleteModal = $('#deleteModal')
  @this.on('showDeleteModal', function () {
    deleteModal.modal('show')
  })
  @this.on('hideDeleteModal', function () {
    deleteModal.modal('hide')
  })
    deleteModal.on('hidden.bs.modal', function () {
    @this.deletingFile
      = null
    })
  })
</script>