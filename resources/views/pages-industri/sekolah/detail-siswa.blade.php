@extends('components.layout-industri')

@section('title', 'Data Siswa PKL')

@section('content')
<div class="bg-gray-100 font-poppins">
    <main class="p-6 overflow-y-auto h-full ml-4">
        @if(session('success'))
        <div id="flash-message-success" class="bg-green-100 px-4 py-2 my-2 rounded-md text-xs flex items-center max-w-md w-full sm:w-2/3">
            <svg viewBox="0 0 24 24" class="text-green-600 w-4 h-4 mr-2">
                <path fill="currentColor" d="M12,0A12,12,0,1,0,24,12A12.013,12.013,0,0,0,12,0Zm.25,5a1.5,1.5,0,1,1-1.5,1.5A1.5,1.5,0,0,1,12.25,5ZM14.5,18.5h-4a1,1,0,0,1,0-2h.75a.25.25,0,0,0,.25-.25v-4.5a.25.25,0,0,0-.25-.25H10.5a1,1,0,0,1,0-2h1a2,2,0,0,1,2,2v4.75a.25.25,0,0,0,.25.25h.75a1,1,0,1,1,0,2Z"></path>
            </svg>
            <span class="text-green-800">{{ session('success') }}</span>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('flash-message').style.display = 'none';
            }, 3000);
        </script>
        @endif

<div class="max-w-7xl mx-auto bg-white p-4 sm:p-6 rounded-lg shadow-md">
    <div class="mb-4">
         <h1 class="text-xl sm:text-xl font-semibold text-center mb-2 sm:mb-4">Siswa PKL</h1>
         <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0 sm:space-x-4">
            <div class="relative w-full sm:w-auto text-xs">
            <input class="border rounded p-2 pl-10 w-full sm:w-64" id="search" placeholder="Cari Nama Siswa" type="text" oninput="searchTable()">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        <!-- Tombol aksi multiple -->
            <div class="flex space-x-2">
                <button onclick="updateMultipleStatus('diterima')" class="bg-green-200 text-green-800 text-sm px-2 py-1 rounded-shadow">
                    <i class="fas fa-check mr-1"></i> Terima
                </button>
                <button onclick="updateMultipleStatus('ditolak')" class="bg-red-300 text-green-800 text-sm px-2 py-1 rounded-shadow">
                    <i class="fas fa-times mr-1"></i> Tolak
                </button>
            </div> 
        </div>
    </div>

<!-- Tabel -->
<div class="overflow-x-auto">
    <table class="min-w-full bg-white border" id="studentTable">
        <thead class="bg-gray-200 font-semibold text-gray-700 border-b border-gray-300 text-xs">
            <tr>
                <th class="py-2 px-4 text-center">
                    <input type="checkbox" id="checkAll" class="student-checkbox-master">
                </th>
                <th class="py-2 px-4 text-center">No</th>
                <th class="py-2 px-4 text-left">Nama Siswa</th>
                <th class="py-2 px-4 text-left">Jurusan</th>
                <th class="py-2 px-4 text-center">Tanggal Mulai </th>
                <th class="py-2 px-4 text-center">Tanggal Selesai </th>
                <th class="py-2 px-4 text-center">CV</th>
                <th class="py-2 px-4 text-center">Status Persetujuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listSiswa as $item)
                <tr class="student-row bg-white hover:bg-gray-50 transition duration-200 ease-in-out text-xs">
                    <td class="py-2 px-4 border-b text-center">
                        <input type="checkbox" class="student-checkbox" value="{{ $item->id }}" {{ in_array($item->status_persetujuan, ['diterima', 'ditolak']) ? 'disabled' : '' }}>
                    </td>
                    <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                    <td class="py-2 px-4 border-b text-left">{{ $item->nama }}</td>
                    <td class="py-2 px-4 border-b text-left">{{ $item->jurusan }}</td>
                    <td class="py-2 px-4 border-b text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y') }}
                    </td>
                    <td class="py-2 px-4 border-b text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d F Y') }}
                    </td>                    
                    <td class="py-2 px-4 border-b text-center">
                        <a href="{{ asset('storage/' . $item->cv_file) }}" class="bg-blue-500 text-white text-xs px-2 py-1 rounded hover:bg-blue-600 transition duration-300">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </td>
                    <td class="py-2 px-3 border-b text-center">
                        @if ($item->status_persetujuan == 'pending')
                            <span id="status-{{ $item->id }}" class="bg-yellow-200 text-yellow-800 text-xs px-2 py-1 rounded-full">{{ $item->status_persetujuan }}</span>
                        @elseif ($item->status_persetujuan == 'diterima')
                            <span id="status-{{ $item->id }}" class="bg-green-200 text-green-800 text-xs px-2 py-1 rounded-full">{{ $item->status_persetujuan }}</span>
                        @elseif ($item->status_persetujuan == 'ditolak')
                            <span id="status-{{ $item->id }}" class="bg-red-200 text-red-800 text-xs px-2 py-1 rounded-full">{{ $item->status_persetujuan }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
        </div>
    </main>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
            $('#checkAll').on('change', function () {
            $('.student-checkbox:not(:disabled)').prop('checked', this.checked);
        });

        $('.student-checkbox').on('change', function () {
            const allEnabledCheckboxes = $('.student-checkbox:not(:disabled)');
            const allChecked = allEnabledCheckboxes.length > 0 && allEnabledCheckboxes.filter(':checked').length === allEnabledCheckboxes.length;
            $('#checkAll').prop('checked', allChecked);
        });
    });

    

     // Fungsi untuk memilih semua siswa
    function toggleSelectAll(source) {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = source.checked);
    }

// Fungsi untuk update status siswa yang dipilih secara multiple
    function updateMultipleStatus(status) {
        const selectedCheckboxes = document.querySelectorAll('.student-checkbox:checked');
        if (selectedCheckboxes.length === 0) {
            alert('Pilih setidaknya satu siswa untuk memperbarui status.');
            return;
        }

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let completedRequests = 0;

        selectedCheckboxes.forEach(async (checkbox) => {
            const studentId = checkbox.value;
            
            try {
                const response = await fetch('{{ route("sekolah.update-status-siswa") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        id: studentId,
                        status: status,
                    }),
                });

                if (response.ok) {
                    completedRequests++;

                    if (completedRequests === selectedCheckboxes.length) {
                        location.reload();
                    }
                } else {
                    console.error(`Failed to update status for student ${studentId}:`, response.statusText);
                }
            } catch (error) {
                console.error(`Error updating status for student ${studentId}:`, error);
            }
        });
    }

    // Function to handle searching in the student table
    function searchTable() {
        const searchInput = document.getElementById('search').value.toLowerCase();
        const rows = document.querySelectorAll('.student-row');
        rows.forEach(row => {
            const studentName = row.querySelector('td:nth-child(3)').textContent.toLowerCase(); // Changed to check the name column
            if (studentName.includes(searchInput)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Function to view the student details
    function viewStudent(studentId) {
        alert(`Menampilkan data siswa dengan ID: ${studentId}`);
        // You can redirect to a student detail page or show a modal
    }

    // Function to edit the student details
    function editStudent(studentId) {
        alert(`Mengedit data siswa dengan ID: ${studentId}`);
        // You can redirect to an edit page or show a modal
    }
</script>


@endsection