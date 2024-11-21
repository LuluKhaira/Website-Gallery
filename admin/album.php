<?php
include '../navbar/nav_admin.php';
include '../config/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Management | Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine-ie11.min.js" defer></script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <main class="flex-grow container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-8 text-gray-800">Album Management</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $sql = mysqli_query($conn, "SELECT * FROM album ORDER BY tanggaldibuat DESC");
            while ($row = mysqli_fetch_array($sql)) {
                ?>
                <div onclick="location.href='album_foto.php?albumid=<?php echo $row['albumid']; ?>'"
                    class="bg-white rounded-xl shadow-lg overflow-hidden cursor-pointer transition-all duration-300 hover:shadow-xl hover:-translate-y-2 fade-in">
                    <div class="p-6">
                        <h2 class="text-2xl font-semibold mb-3 text-gray-800">
                            <?php echo htmlspecialchars($row['namaalbum']); ?></h2>
                        <p class="text-gray-600 mb-4 line-clamp-3"><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                        <p class="text-sm text-gray-500">Created:
                            <?php echo date('F j, Y', strtotime($row['tanggaldibuat'])); ?></p>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 flex justify-between items-center">
                        <button onclick="event.stopPropagation(); openEditModal(<?php echo $row['albumid']; ?>)"
                            class="text-blue-600 hover:text-blue-800 transition-colors duration-300 flex items-center">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </button>
                        <form action="../config/album_function.php" method="POST" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this album?');">
                            <input type="hidden" name="albumid" value="<?php echo $row['albumid']; ?>">
                            <button type="submit" name="delete"
                                class="text-red-600 hover:text-red-800 transition-colors duration-300 flex items-center">
                                <i class="fas fa-trash-alt mr-2"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Edit Album Modal -->
                <div id="editModal<?php echo $row['albumid']; ?>"
                    class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md transform transition-all duration-300 scale-90 opacity-0"
                        id="modalContent<?php echo $row['albumid']; ?>">
                        <h2 class="text-3xl font-bold mb-6 text-gray-800">Edit Album</h2>
                        <form action="../config/album_function.php" method="POST">
                            <input type="hidden" name="albumid" value="<?php echo $row['albumid']; ?>">
                            <div class="mb-6">
                                <label for="editAlbumName<?php echo $row['albumid']; ?>"
                                    class="block text-sm font-medium text-gray-700 mb-2">Album Name</label>
                                <input type="text" id="editAlbumName<?php echo $row['albumid']; ?>" name="namaalbum"
                                    value="<?php echo htmlspecialchars($row['namaalbum']); ?>" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300">
                            </div>
                            <div class="mb-6">
                                <label for="editDescription<?php echo $row['albumid']; ?>"
                                    class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea id="editDescription<?php echo $row['albumid']; ?>" name="deskripsi" rows="4"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300"><?php echo htmlspecialchars($row['deskripsi']); ?></textarea>
                            </div>
                            <div class="flex justify-end space-x-4">
                                <button type="button" onclick="closeEditModal(<?php echo $row['albumid']; ?>)"
                                    class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors duration-300">Cancel</button>
                                <button type="submit" name="edit"
                                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-300">Save
                                    Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>

    <!-- Floating Action Button -->
    <button onclick="openCreateModal()"
        class="fixed bottom-8 right-8 bg-blue-600 text-white rounded-full p-6 shadow-lg hover:bg-blue-700 transition-all duration-300 hover:scale-110">
        <i class="fas fa-plus text-2xl"></i>
    </button>

    <!-- Create Album Modal -->
    <div id="createModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md transform transition-all duration-300 scale-90 opacity-0"
            id="createModalContent">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Create New Album</h2>
            <form action="../config/album_function.php" method="POST">
                <div class="mb-6">
                    <label for="newNamaAlbum" class="block text-sm font-medium text-gray-700 mb-2">Album Name</label>
                    <input type="text" id="newNamaAlbum" name="namaalbum" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300">
                </div>
                <div class="mb-6">
                    <label for="newDescription" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="newDescription" name="deskripsi" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300"></textarea>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeCreateModal()"
                        class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors duration-300">Cancel</button>
                    <button type="submit" name="add"
                        class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors duration-300">Create
                        Album</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id) {
            const modal = document.getElementById(`editModal${id}`);
            const content = document.getElementById(`modalContent${id}`);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                content.classList.remove('scale-90', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeEditModal(id) {
            const modal = document.getElementById(`editModal${id}`);
            const content = document.getElementById(`modalContent${id}`);
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-90', 'opacity-0');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }

        function openCreateModal() {
            const modal = document.getElementById('createModal');
            const content = document.getElementById('createModalContent');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                content.classList.remove('scale-90', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeCreateModal() {
            const modal = document.getElementById('createModal');
            const content = document.getElementById('createModalContent');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-90', 'opacity-0');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
</body>

</html>