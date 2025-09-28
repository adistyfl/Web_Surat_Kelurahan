<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Arsip Surat - Kelurahan Karangduren')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Menu</h2>
                <div class="text-gray-400 text-sm mt-1">--------</div>
            </div>
            
            <nav class="mt-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-100 border-r-2 border-blue-500' : '' }}">
                            <span class="text-yellow-500 mr-3">★</span>
                            Arsip
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}" 
                           class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('categories.*') ? 'bg-gray-100 border-r-2 border-blue-500' : '' }}">
                            <span class="text-gray-500 mr-3">⚙</span>
                            Kategori Surat
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" 
                           class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('about') ? 'bg-gray-100 border-r-2 border-blue-500' : '' }}">
                            <span class="text-blue-500 mr-3">ℹ</span>
                            About
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 p-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-800">
                            @yield('page-title', 'Dashboard')
                        </h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 p-4 text-right">
                <span class="text-pink-500 text-sm font-semibold bg-pink-100 px-2 py-1 rounded">
                    Made with ♥ by Kelurahan Karangduren
                </span>
            </footer>
        </div>
    </div>

    <!-- Modal untuk konfirmasi hapus -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-bold text-gray-900 text-center">Alert</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 text-center">
                        Apakah Anda yakin ingin menghapus arsip surat ini?
                    </p>
                </div>
                <div class="flex justify-center mt-4 space-x-4">
                    <button id="cancelDelete" 
                            class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400">
                        Batal
                    </button>
                    <button id="confirmDelete" 
                            class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700">
                        Ya!
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle delete modal
        let deleteForm = null;
        
        function showDeleteModal(form) {
            deleteForm = form;
            document.getElementById('deleteModal').classList.remove('hidden');
        }
        
        document.getElementById('cancelDelete').addEventListener('click', function() {
            document.getElementById('deleteModal').classList.add('hidden');
            deleteForm = null;
        });
        
        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (deleteForm) {
                deleteForm.submit();
            }
            document.getElementById('deleteModal').classList.add('hidden');
        });

        // Handle search
        function performSearch() {
            const searchValue = document.getElementById('searchInput').value;
            const currentUrl = new URL(window.location);
            
            if (searchValue.trim()) {
                currentUrl.searchParams.set('search', searchValue);
            } else {
                currentUrl.searchParams.delete('search');
            }
            
            window.location = currentUrl.toString();
        }
    </script>
    
    @stack('scripts')
</body>
</html>