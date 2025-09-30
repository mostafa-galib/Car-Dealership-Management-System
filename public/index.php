<?php

require_once __DIR__ . "/../config.php";

$route = $_GET['route'] ?? 'cars';

switch ($route) {

    // ----------------- PUBLIC  -----------------
    case 'cars':
        require_once __DIR__ . "/../app/controllers/CarUnitController.php";
        (new CarUnitController($conn))->index();
        break;

    case 'cars/details':
        require_once __DIR__ . "/../app/controllers/CarUnitController.php";
        (new CarUnitController($conn))->show($_GET['id'] ?? null);
        break;

    // ----------------- COMPARE (Session-based compare cart) -----------------
    case 'cars/compare':
        require_once __DIR__ . "/../app/controllers/CarUnitController.php";
        (new CarUnitController($conn))->compareSelect($_GET['pref'] ?? null);
        break;

    // POST: add to compare cart
    case 'cars/compare/add':
        require_once __DIR__ . "/../app/controllers/CarUnitController.php";
        (new CarUnitController($conn))->compareAdd();
        break;

    // GET: remove one from compare cart
    case 'cars/compare/remove':
        require_once __DIR__ . "/../app/controllers/CarUnitController.php";
        (new CarUnitController($conn))->compareRemove($_GET['id'] ?? null);
        break;

    // GET: clear compare cart
    case 'cars/compare/clear':
        require_once __DIR__ . "/../app/controllers/CarUnitController.php";
        (new CarUnitController($conn))->compareClear();
        break;

    // GET: show comparison table for current selections
    case 'cars/compare/show':
        require_once __DIR__ . "/../app/controllers/CarUnitController.php";
        (new CarUnitController($conn))->compareShow();
        break;

    // ----------------- CUSTOMER AUTH -----------------
    case 'customer/login':
        require_once __DIR__ . "/../app/controllers/CustomerAuthController.php";
        (new CustomerAuthController($conn))->showLogin();
        break;

    case 'customer/login_post':
        require_once __DIR__ . "/../app/controllers/CustomerAuthController.php";
        (new CustomerAuthController($conn))->login();
        break;

    case 'customer/register':
        require_once __DIR__ . "/../app/controllers/CustomerAuthController.php";
        (new CustomerAuthController($conn))->showRegister();
        break;

    case 'customer/register_post':
        require_once __DIR__ . "/../app/controllers/CustomerAuthController.php";
        (new CustomerAuthController($conn))->register();
        break;

    case 'customer/logout':
        require_once __DIR__ . "/../app/controllers/CustomerAuthController.php";
        (new CustomerAuthController($conn))->logout();
        break;

    // ----------------- CUSTOMER ACTIONS (login required) -----------------
    case 'testdrives/store':
        Auth::requireLogin('customer');
        require_once __DIR__ . "/../app/controllers/TestDriveController.php";
        (new TestDriveController($conn))->store();
        break;

    case 'testdrives/my':
        Auth::requireLogin('customer');
        require_once __DIR__ . "/../app/controllers/TestDriveController.php";
        (new TestDriveController($conn))->myList();
        break;

    // Customer: My Reservations

    case 'reservations/store':
        Auth::requireLogin('customer');
        require_once __DIR__ . "/../app/controllers/ReservationController.php";
        (new ReservationController($conn))->store();
        break;

    case 'reservations/my':
        Auth::requireLogin('customer');
        require_once __DIR__ . "/../app/controllers/ReservationController.php";
        (new ReservationController($conn))->myList();
        break;

    case 'reservations/cancel':
        Auth::requireLogin('customer');
        require_once __DIR__ . "/../app/controllers/ReservationController.php";
        (new ReservationController($conn))->cancel();
        break;

    // Customer cancels own test drive
    case 'testdrives/cancel':
        Auth::requireLogin('customer');
        require_once __DIR__ . "/../app/controllers/TestDriveController.php";
        (new TestDriveController($conn))->cancel();
        break;
            
    // ----------------- SALES (separate) -----------------
    case 'sales/login':
        require_once __DIR__ . "/../app/controllers/SalesAuthController.php";
        (new SalesAuthController($conn))->showLogin();
        break;

    case 'sales/login_post':
        require_once __DIR__ . "/../app/controllers/SalesAuthController.php";
        (new SalesAuthController($conn))->login();
        break;

    case 'sales/logout':
        require_once __DIR__ . "/../app/controllers/SalesAuthController.php";
        (new SalesAuthController($conn))->logout();
        break;

    case 'sales/dashboard':
        Auth::requireLogin('sales');
        include __DIR__ . "/../app/views/sales/dashboard.php";
        break;
    
    // ----------------- SALES: Test Drives -----------------
    case 'sales/testdrives':
        Auth::requireLogin('sales');
        require_once __DIR__."/../app/controllers/SalesTestDriveController.php";
        (new SalesTestDriveController($conn))->index();
        break;

    case 'sales/testdrives/updateStatus':
        Auth::requireLogin('sales');
        require_once __DIR__."/../app/controllers/SalesTestDriveController.php";
        (new SalesTestDriveController($conn))->updateStatus();
        break;

    // ----------------- SALES: Reservations -----------------
    case 'sales/reservations':
        Auth::requireLogin('sales');
        require_once __DIR__."/../app/controllers/SalesReservationController.php";
        (new SalesReservationController($conn))->index();
        break;
        
    case 'sales/reservations/update':
        Auth::requireLogin('sales');
        require_once __DIR__ . "/../app/controllers/SalesReservationController.php";
        (new SalesReservationController($conn))->update();
        break;

    // ----------------- SALES: Quotations -----------------
    case 'sales/quotations':
        Auth::requireLogin('sales');
        require_once __DIR__."/../app/controllers/SalesQuotationController.php";
        (new SalesQuotationController($conn))->index();
        break;

    // ----------------- ADMIN AUTH (separate) -----------------
    case 'admin/login':
        require_once __DIR__ . "/../app/controllers/AdminAuthController.php";
        (new AdminAuthController($conn))->showLogin();
        break;

    case 'admin/login_post':
        require_once __DIR__ . "/../app/controllers/AdminAuthController.php";
        (new AdminAuthController($conn))->login();
        break;

    case 'admin/logout':
        require_once __DIR__ . "/../app/controllers/AdminAuthController.php";
        (new AdminAuthController($conn))->logout();
        break;

    case 'admin/dashboard':
        Auth::requireLogin('admin');
        include __DIR__ . "/../app/views/admin/dashboard.php";
        break;

    // ----------------- ADMIN: Cars CRUD -----------------
    case 'admin/cars':
        Auth::requireLogin('admin');
        require_once __DIR__ . "/../app/controllers/AdminCarController.php";
        (new AdminCarController($conn))->index();
        break;

    case 'admin/cars/create':
        Auth::requireLogin('admin');
        require_once __DIR__ . "/../app/controllers/AdminCarController.php";
        (new AdminCarController($conn))->create();
        break;

    case 'admin/cars/store':
        Auth::requireLogin('admin');
        require_once __DIR__ . "/../app/controllers/AdminCarController.php";
        (new AdminCarController($conn))->store();
        break;

    case 'admin/cars/edit':
        Auth::requireLogin('admin');
        require_once __DIR__ . "/../app/controllers/AdminCarController.php";
        (new AdminCarController($conn))->edit($_GET['id'] ?? null);
        break;

    case 'admin/cars/update':
        Auth::requireLogin('admin');
        require_once __DIR__ . "/../app/controllers/AdminCarController.php";
        (new AdminCarController($conn))->update($_POST['id'] ?? null);
        break;

    case 'admin/cars/delete':
        Auth::requireLogin('admin');
        require_once __DIR__ . "/../app/controllers/AdminCarController.php";
        (new AdminCarController($conn))->delete($_GET['id'] ?? null);
        break;

    // ----------------- ADMIN: Car Images (upload/manage) -----------------
    case 'admin/cars/uploadImage':
        Auth::requireLogin('admin');
        require_once __DIR__ . "/../app/controllers/AdminCarController.php";
        (new AdminCarController($conn))->uploadImage();
        break;

    case 'admin/cars/deleteImage':
        Auth::requireLogin('admin');
        require_once __DIR__ . "/../app/controllers/AdminCarController.php";
        (new AdminCarController($conn))->deleteImage($_GET['id'] ?? null);
        break;

    case 'admin/cars/setCover':
        Auth::requireLogin('admin');
        require_once __DIR__ . "/../app/controllers/AdminCarController.php";
        (new AdminCarController($conn))->setCover($_GET['id'] ?? null);
        break;

    case 'admin/cars/updateSort':
        Auth::requireLogin('admin');
        require_once __DIR__ . "/../app/controllers/AdminCarController.php";
        (new AdminCarController($conn))->updateSort();
        break;

    // ----------------- ADMIN: System Settings -----------------
    case 'admin/settings':
    Auth::requireLogin('admin');
    require_once __DIR__ . "/../app/controllers/AdminSettingController.php";
    (new AdminSettingController($conn))->index();
    break;

case 'admin/settings/save':
    Auth::requireLogin('admin');
    require_once __DIR__ . "/../app/controllers/AdminSettingController.php";
    (new AdminSettingController($conn))->save();
    break;
        
    // ----------------- 404 -----------------
    default:
        http_response_code(404);
        echo "404 - Page not found";
}
