<?php
// index.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

$databaseHost = "localhost";
$databaseName = "";
$dbusername = "";
$dbpassword = "";

try {
    $conn = new PDO("mysql:host=$databaseHost;dbname=$databaseName", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donations Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            width: 250px;
            transition: all 0.3s;
        }
        .sidebar.collapsed {
            width: 60px;
        }
        .main-content {
            margin-left: 250px;
            transition: all 0.3s;
        }
        .main-content.expanded {
            margin-left: 60px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="sidebar fixed h-full bg-white shadow-lg">
        <div class="p-4 flex justify-between items-center border-b">
            <h1 class="text-xl font-bold sidebar-text">Dashboard</h1>
            <button id="toggleSidebar" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <nav class="mt-4">
            <a href="#" class="flex items-center p-4 text-gray-700 hover:bg-blue-50">
                <i class="fas fa-home w-6"></i>
                <span class="ml-2 sidebar-text">Overview</span>
            </a>
            <a href="#" class="flex items-center p-4 text-gray-700 hover:bg-blue-50 bg-blue-100">
                <i class="fas fa-clock w-6"></i>
                <span class="ml-2 sidebar-text">Pending Actions</span>
            </a>
            <a href="logout.php" class="flex items-center p-4 text-gray-700 hover:bg-blue-50">
                <i class="fas fa-sign-out-alt w-6"></i>
                <span class="ml-2 sidebar-text">Logout</span>
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content min-h-screen bg-gray-100 p-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6">Pending Donations</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PAN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seva</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        $stmt = $conn->query("SELECT * FROM donations WHERE approved = 0");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['phone']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['pan']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>₹" . htmlspecialchars($row['amount']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['seva']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['message']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>
                                    <button onclick='approveRecord(" . $row['id'] . ")' class='bg-green-500 text-white px-4 py-2 rounded mr-2 hover:bg-green-600'>Approve</button>
                                    <button onclick='disapproveRecord(" . $row['id'] . ")' class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600'>Disapprove</button>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar
        const toggleButton = document.getElementById('toggleSidebar');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            sidebarTexts.forEach(text => {
                text.style.display = text.style.display === 'none' ? 'block' : 'none';
            });
        });

        // Handle approve/disapprove actions
        function approveRecord(id) {
            if (confirm('Are you sure you want to approve this donation?')) {
                fetch('update_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}&action=approve`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error updating record');
                    }
                });
            }
        }

        function disapproveRecord(id) {
            if (confirm('Are you sure you want to disapprove this donation?')) {
                fetch('update_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}&action=disapprove`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error updating record');
                    }
                });
            }
        }
    </script>
</body>
</html>

<?php