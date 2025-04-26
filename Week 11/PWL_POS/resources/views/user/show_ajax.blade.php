<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Data User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="d-flex align-items-start">
                <!-- Tabel Data User -->
                <div class="flex-grow-1">
                    <!-- Foto Profil -->
                    <div class="text-center mr-4 mb-3">
                        <img src="{{ $user->picture_path ?? asset('profile-icon-png-910.png') }}" alt="Foto Profil"
                            class="rounded-circle border" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <table class="table table-bordered table-striped table-hover table-sm mb-0">
                        <tr>
                            <th style="width: 150px;">ID</th>
                            <td>{{ $user->user_id }}</td>
                        </tr>
                        <tr>
                            <th>Level</th>
                            <td>{{ $user->level->level_nama }}</td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td>{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $user->nama }}</td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td>********</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>