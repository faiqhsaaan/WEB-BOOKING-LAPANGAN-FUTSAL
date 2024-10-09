@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Brand Edit')

@section('content')
<main class="md:ml-64 h-auto pt-20">
    <div class="p-12">
        <div class="mb-5">
            <h2 class="text-4xl font-bold text-gray-900">Notification</h2>
        </div>
        <div class="bg-white shadow-xl mx-auto w-full max-w-[1250px] p-10 rounded-lg">
            <h3 class="mb-3 block text-base font-medium text-[#07074D]">Notifikasi Saat Ini</h3>
            @forelse($notifications as $notification)
                <form action="{{ route('notifications.update', $notification->id) }}" method="POST" class="mb-3">
                    @csrf
                    @method('PUT')
                    <div class="form-row align-items-center mb-7">
                        <div class="col-auto">
                            <input type="number" name="minutes_before" value="{{ $notification->minutes_before }}" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" min="1" max="10080" required>
                        </div>
                        <div class="col-auto">
                            <span class="mb-3 block text-base font-medium text-[#07074D]">
                                menit sebelum pertandingan
                            </span>
                        </div>
                        <div class="flex justify-start gap-2">
                            <div class="col-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active_{{ $notification->id }}" {{ $notification->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active_{{ $notification->id }}">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="hover:shadow-form rounded-md bg-green-700 py-1 px-2 text-sm text-center font-semibold text-white outline-none">Update</button>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="hover:shadow-form rounded-md bg-red-700 py-1 px-2 text-sm text-center font-semibold text-white outline-none" onclick="deleteNotification({{ $notification->id }})">Hapus</button>
                            </div>
                        </div>
                    </div>
                </form>
            @empty
                <p>Belum ada notifikasi yang diatur.</p>
            @endforelse

            <h3 class="mb-3 mt-7 block text-base font-medium text-[#07074D]">Tambah Notifikasi Baru</h3>
            <form action="{{ route('notifications.store') }}" method="POST">
                @csrf
                <div class="form-row align-items-center">
                    <div class="col-auto mb-2">
                        <input type="number" name="minutes_before" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" min="1" max="10080" required placeholder="Menit sebelum pertandingan">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="hover:shadow-form rounded-md bg-green-700 py-1 px-2 text-sm text-center font-semibold text-white outline-none">Tambah Notifikasi</button>
                    </div>
                </div>
            </form>

            <div class="mt-3">
                <strong>Contoh waktu umum:</strong>
                <button type="button" class="btn btn-outline-secondary btn-sm mr-2" onclick="setMinutes(15)">15 menit</button>
                <button type="button" class="btn btn-outline-secondary btn-sm mr-2" onclick="setMinutes(30)">30 menit</button>
                <button type="button" class="btn btn-outline-secondary btn-sm mr-2" onclick="setMinutes(60)">1 jam</button>
                <button type="button" class="btn btn-outline-secondary btn-sm mr-2" onclick="setMinutes(120)">2 jam</button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setMinutes(1440)">1 hari</button>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
function setMinutes(minutes) {
    document.querySelector('input[name="minutes_before"]').value = minutes;
}

function deleteNotification(id) {
    if (confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
        fetch(`/notifications/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        }).then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Terjadi kesalahan saat menghapus notifikasi.');
            }
        });
    }
}
</script>
@endsection
