<?php
header('Content-Type: application/json'); // Set content type to JSON

session_start();
include 'db.php'; // Include database connection

header('Content-Type: application/json'); // Set content type to JSON

$response = [
    'success' => false,
    'error_message' => '',
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $new_country = $_POST['new_country'];

    if (empty($new_password) && empty($new_country)) {
        $response['error_message'] = 'The fields can\'t be left empty. Try again.';
    } else {
        try {
            $update_fields = [];
            $params = ['email' => $_SESSION['email']];

            if (!empty($new_password)) {
                $update_fields[] = "password = :new_password";
                $params['new_password'] = $new_password;
            }

            if (!empty($new_country)) {
                $update_fields[] = "country = :new_country";
                $params['new_country'] = $new_country;
            }

            if (!empty($update_fields)) {
                $stmt = $pdo->prepare("UPDATE Users SET " . implode(', ', $update_fields) . " WHERE emailaddress = :email");
                $stmt->execute($params);
                $response['success'] = true;
                $response['message'] = 'Profile updated successfully!';
            } else {
                $response['message'] = 'No changes were made.';
            }
        } catch (Exception $e) {
            $response['error_message'] = 'Error updating profile: ' . $e->getMessage();
        }
    }
}

echo json_encode($response);
?>
