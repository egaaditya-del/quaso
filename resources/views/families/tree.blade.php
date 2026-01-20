@extends('layouts.app')

@section('title', 'Pohon Keluarga')

@section('styles')
<style>
    #treeContainer {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 500px;
        border-radius: 8px;
        overflow-x: auto;
        padding: 20px;
    }

    .tree {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .tree-item {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        margin: 10px;
    }

    .tree-box {
        background: white;
        border: 2px solid #764ba2;
        border-radius: 8px;
        padding: 15px;
        margin: 5px;
        min-width: 200px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .tree-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0,0,0,0.2);
    }

    .tree-box h3 {
        margin: 0 0 5px 0;
        font-size: 16px;
        color: #333;
    }

    .tree-box p {
        margin: 0;
        font-size: 12px;
        color: #666;
    }

    .tree-box .gender {
        display: inline-block;
        margin-top: 8px;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: bold;
    }

    .tree-box .gender.male {
        background: #dbeafe;
        color: #1e40af;
    }

    .tree-box .gender.female {
        background: #fbecf8;
        color: #be185d;
    }

    .tree-connector {
        width: 2px;
        height: 20px;
        background: #764ba2;
    }

    .tree-children {
        display: flex;
        justify-content: center;
        gap: 40px;
        margin-top: 30px;
        flex-wrap: wrap;
    }

    .generation {
        display: flex;
        justify-content: center;
        gap: 60px;
        margin: 40px 0;
        flex-wrap: wrap;
    }

    @media print {
        body {
            background: white;
        }
        #treeContainer {
            background: white;
            border: 1px solid #ccc;
        }
    }
</style>
@endsection

@section('content')
<div class="mb-6">
    <h1 class="text-4xl font-bold text-gray-800 mb-2">Pohon Keluarga</h1>
    <p class="text-gray-600">Visualisasi struktur keluarga Anda secara interaktif</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
    <!-- Filter Options -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Filter & Aksi</h3>
            
            <div class="space-y-4">
                <div>
                    <label for="rootMember" class="block text-sm font-semibold text-gray-700 mb-2">
                        Pilih Kepala Keluarga
                    </label>
                    <select id="rootMember" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($rootFamilies as $family)
                            <option value="{{ route('families.getTreeData', $family) }}">{{ $family->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button onclick="zoomIn()" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-search-plus mr-2"></i>Perbesar
                </button>

                <button onclick="zoomOut()" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-search-minus mr-2"></i>Perkecil
                </button>

                <button onclick="resetZoom()" class="w-full bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                    <i class="fas fa-redo mr-2"></i>Reset
                </button>

                <button onclick="window.print()" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-print mr-2"></i>Cetak
                </button>

                <a href="{{ route('families.create') }}" class="block w-full bg-purple-600 text-white text-center px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    <i class="fas fa-plus mr-2"></i>Tambah Anggota
                </a>

                <a href="{{ route('families.index') }}" class="block w-full bg-gray-600 text-white text-center px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                    <i class="fas fa-list mr-2"></i>Daftar
                </a>
            </div>

            <!-- Info Box -->
            <div class="mt-6 pt-6 border-t">
                <p class="text-sm text-gray-600 mb-2"><strong>Klik pada nama anggota keluarga</strong> untuk melihat detail lengkap mereka.</p>
            </div>
        </div>
    </div>

    <!-- Tree Visualization -->
    <div class="lg:col-span-3">
        <div id="treeContainer" class="tree">
            <div class="tree-item">
                <div class="text-white text-center">
                    <i class="fas fa-spinner fa-spin text-4xl"></i>
                    <p class="mt-2">Memuat pohon keluarga...</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    let currentZoom = 1;

    // Load tree on page load
    document.addEventListener('DOMContentLoaded', function() {
        @if($rootFamilies->count() > 0)
            loadTree("{{ route('families.getTreeData', $rootFamilies[0]) }}");
        @else
            document.getElementById('treeContainer').innerHTML = `
                <div class="text-white text-center">
                    <i class="fas fa-inbox text-4xl mb-4"></i>
                    <p class="mt-4">Belum ada data keluarga untuk ditampilkan</p>
                    <a href="{{ route('families.create') }}" class="mt-4 inline-block bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
                        Tambah Anggota Keluarga Pertama
                    </a>
                </div>
            `;
        @endif

        // Handle member selection
        document.getElementById('rootMember').addEventListener('change', function() {
            if (this.value) {
                loadTree(this.value);
            }
        });
    });

    function loadTree(url) {
        fetch(url)
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('treeContainer');
                container.innerHTML = '';
                container.appendChild(buildTreeHtml(data));
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('treeContainer').innerHTML = `
                    <div class="text-white text-center">
                        <p>Gagal memuat pohon keluarga</p>
                    </div>
                `;
            });
    }

    function buildTreeHtml(data) {
        const container = document.createElement('div');
        container.className = 'tree-item';

        const box = document.createElement('div');
        box.className = 'tree-box';
        box.style.cursor = 'pointer';

        const name = document.createElement('h3');
        name.textContent = data.name;

        const status = document.createElement('p');
        status.textContent = data.status;

        const genderBadge = document.createElement('div');
        if (data.gender) {
            genderBadge.className = `gender ${data.gender === 'Laki-laki' ? 'male' : 'female'}`;
            genderBadge.innerHTML = `<i class="fas fa-${data.gender === 'Laki-laki' ? 'mars' : 'venus'} mr-1"></i>${data.gender}`;
        }

        box.appendChild(name);
        box.appendChild(status);
        if (data.gender) {
            box.appendChild(genderBadge);
        }

        // Make box clickable
        box.onclick = function() {
            window.location.href = `/families/${data.id}`;
        };

        box.onmouseover = function() {
            this.style.transform = 'translateY(-5px)';
        };

        box.onmouseout = function() {
            this.style.transform = 'translateY(0)';
        };

        container.appendChild(box);

        // Add children if they exist
        if (data.children && data.children.length > 0) {
            const connector = document.createElement('div');
            connector.className = 'tree-connector';
            container.appendChild(connector);

            const childrenContainer = document.createElement('div');
            childrenContainer.className = 'tree-children';

            data.children.forEach(child => {
                childrenContainer.appendChild(buildTreeHtml(child));
            });

            container.appendChild(childrenContainer);
        }

        return container;
    }

    function zoomIn() {
        currentZoom += 0.2;
        applyZoom();
    }

    function zoomOut() {
        if (currentZoom > 0.4) {
            currentZoom -= 0.2;
        }
        applyZoom();
    }

    function resetZoom() {
        currentZoom = 1;
        applyZoom();
    }

    function applyZoom() {
        const tree = document.querySelector('.tree');
        if (tree) {
            tree.style.transform = `scale(${currentZoom})`;
            tree.style.transformOrigin = 'top center';
        }
    }
</script>
@endsection
