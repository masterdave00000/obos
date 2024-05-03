<?php 

include './../../../config/constants.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clean_billing_id = filter_var($_POST['billing_id'], FILTER_SANITIZE_NUMBER_INT);
    $billing_id = filter_var($clean_billing_id, FILTER_VALIDATE_INT);
    $clean_category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);
    $category_id = filter_var($clean_category_id, FILTER_VALIDATE_INT);
    $section = $_POST['section'];
    $capacity = $_POST['capacity'];
    $fee = $_POST['fee'];
    
}

$billingQuery = "UPDATE equipment_billing SET
    category_id = :category_id,
    section = :section,
    capacity = :capacity,
    fee = :fee 
    WHERE billing_id = :billing_id
";

$billingStatement = $pdo->prepare($billingQuery);
$billingStatement->bindParam(':billing_id', $billing_id);
$billingStatement->bindParam(':category_id', $category_id);
$billingStatement->bindParam(':section', $section);
$billingStatement->bindParam(':capacity', $capacity);
$billingStatement->bindParam(':fee', $fee);

if ($billingStatement->execute()) {
    $_SESSION['update'] = "
        <div class='msgalert alert--success' id='alert'>
            <div class='alert__message'>
                Billing Updated Successfully
            </div>
        </div>
    ";

    header('location:' . SITEURL . 'inspection/billing/');
} else {
    $_SESSION['update'] = "
        <div class='msgalert alert--danger' id='alert'>
            <div class='alert__message'>	
                Failed to Update Billing
            </div>
        </div>
    ";

    header('location:' . SITEURL . "inspection/billing/update-billing.php?billing_id='$billing_id'");
}