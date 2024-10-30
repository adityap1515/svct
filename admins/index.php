<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Error logging configuration
date_default_timezone_set('Asia/Kolkata');
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');
error_reporting(E_ALL);


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

$section = isset($_GET['section']) ? $_GET['section'] : 'pending';
$sectionTitles = [
    'pending' => 'Pending Donations',
    'approved' => 'Approved Donations',
    'disapproved' => 'Disapproved Donations'
];

$statusMap = [
    'pending' => 0,
    'approved' => 1,
    'disapproved' => 2
];

$currentStatus = $statusMap[$section];
$stmt = $conn->prepare("SELECT * FROM donations WHERE approved = ?");
$stmt->execute([$currentStatus]);
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
        <a href="?section=pending" class="flex items-center p-4 text-gray-700 hover:bg-blue-50 <?php echo $section === 'pending' ? 'bg-blue-100' : ''; ?>">
            <i class="fas fa-clock w-6"></i>
            <span class="ml-2 sidebar-text">Pending Actions</span>
        </a>
        <a href="?section=approved" class="flex items-center p-4 text-gray-700 hover:bg-blue-50 <?php echo $section === 'approved' ? 'bg-blue-100' : ''; ?>">
            <i class="fas fa-check w-6"></i>
            <span class="ml-2 sidebar-text">Approved</span>
        </a>
        <a href="?section=disapproved" class="flex items-center p-4 text-gray-700 hover:bg-blue-50 <?php echo $section === 'disapproved' ? 'bg-blue-100' : ''; ?>">
            <i class="fas fa-times w-6"></i>
            <span class="ml-2 sidebar-text">Disapproved</span>
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
            <h2 class="text-2xl font-bold mb-6"><?php echo $sectionTitles[$section]; ?></h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <div class="flex justify-between items-center mb-6">
    <button onclick="refreshPage()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        <i class="fas fa-sync-alt mr-2"></i>
        Refresh
    </button>
</div>
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">id</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PAN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Seva</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                             <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Action</th>
                            

                             <?php if ($section === 'pending'): ?>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            <?php endif; ?>
                          
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr data-id='" . $row['id'] . "'>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['phone']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['pan']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>₹" . htmlspecialchars($row['amount']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['seva']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['message']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td class='px-6 py-4 whitespace-nowrap'>" . htmlspecialchars($row['lastActionTimestamp']) . "</td>";
                            

                            
                            if ($section === 'pending') {
                                echo "<td class='px-6 py-4 whitespace-nowrap'>
                                        <button onclick='approveRecord(" . $row['id'] . ", \"" . $row['email'] . "\")' class='bg-green-500 text-white px-4 py-2 rounded mr-2 hover:bg-green-600'>Approve</button>
                                        <button onclick='disapproveRecord(" . $row['id'] . ")' class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600'>Disapprove</button>
                                      </td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<script>
    function removeTableRow(id) {
        const row = document.querySelector(`tr[data-id="${id}"]`);
        if (row) {
            row.style.transition = 'opacity 0.3s ease-out';
            row.style.opacity = '0';
            
            setTimeout(() => {
                row.remove();
                
                const tbody = document.querySelector('tbody');
                if (tbody.children.length === 0) {
                    const noDataRow = document.createElement('tr');
                    noDataRow.innerHTML = `
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No pending donations available
                        </td>
                    `;
                    tbody.appendChild(noDataRow);
                }
            }, 300);
        }
    }

  function approveRecord(id, email, name, amount) {
    if (confirm('Are you sure you want to approve this donation?')) {
        fetch('update_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${id}&action=approve&email=${encodeURIComponent(email)}&name=${encodeURIComponent(name)}&amount=${encodeURIComponent(amount)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                removeTableRow(id);
                showNotification('Donation approved successfully', 'success');
            } else {
                showNotification('Error updating record: ' + data.error, 'error');
            }
        })
        .catch(error => {
            showNotification('Error updating record: ' + error, 'error');
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
                    removeTableRow(id);
                    showNotification('Donation disapproved', 'success');
                } else {
                    showNotification('Error updating record: ' + data.error, 'error');

                }
            })
            .catch(error => {
                showNotification('Error updating record: ' + data.error, 'error');

            });
        }
    }

    // Notification system
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg transition-opacity duration-300 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white`;
        notification.style.zIndex = '1000';
        notification.textContent = message;

       
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    function refreshPage() {
    window.location.reload();
}
</script>
</body>
</html>

<?php