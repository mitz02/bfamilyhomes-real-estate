<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\FinanceController;
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/test-storage', function () {
    return config('filesystems.disks.public.root');
});
// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/privacy-policy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms-conditions', [HomeController::class, 'terms'])->name('terms');
Route::get('/refund-policy', [HomeController::class, 'refund'])->name('refund');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::post('/properties/{property}/inquiry', [PropertyController::class, 'storeInquiry'])->name('properties.inquiry');
Route::get('/properties/autocomplete', [PropertyController::class, 'autocomplete'])->name('properties.autocomplete');
Route::get('/blog', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blogs.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,60')->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::post('/admin/stop-impersonation', [AdminController::class, 'stopImpersonation'])->middleware('auth')->name('admin.stop-impersonation');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');
Route::get('/email/verify/{token}', [AuthController::class, 'verifyEmail'])->name('verify.email');
Route::post('/email/resend', [AuthController::class, 'resendVerification'])->middleware('guest')->name('verification.resend');
Route::get('/verify-instructions', function () {
    return view('auth.verify-instructions');
})->middleware('guest')->name('verify.instructions');

// User Dashboard Routes
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile']);
    Route::post('/change-password', [DashboardController::class, 'changePassword'])->name('dashboard.change-password');
    Route::post('/request-investor-upgrade', [DashboardController::class, 'requestInvestorUpgrade'])->name('dashboard.request-investor');
    Route::post('/request-agent', [DashboardController::class, 'requestAgentStatus'])->name('dashboard.request-agent');
    
    // Inspections/Bookings
    Route::post('/inspections', [InspectionController::class, 'store'])->name('inspections.store');
    Route::get('/inspections', [InspectionController::class, 'index'])->name('inspections.index');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    
    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{id}/instructions', [PaymentController::class, 'instructions'])->name('payments.instructions');
    Route::post('/payments/upload-proof', [PaymentController::class, 'uploadProof'])->name('payments.upload-proof');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('/notifications/recent', [NotificationController::class, 'getRecent'])->name('notifications.recent');
});

// Investor Dashboard Routes
Route::middleware(['auth', 'role:investor'])->prefix('investor')->group(function () {
    Route::get('/', [InvestorController::class, 'dashboard'])->name('investor.dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('investor.profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile']);
    Route::get('/investments', [InvestorController::class, 'investments'])->name('investor.investments');
    Route::get('/investments/{id}/instructions', [InvestorController::class, 'instructions'])->name('investments.instructions');
    Route::post('/invest', [InvestorController::class, 'invest'])->name('investor.invest');
    Route::post('/investments/{investment}/withdraw', [InvestorController::class, 'withdraw'])->name('investor.withdraw');
    Route::post('/investments/{investment}/reinvest', [InvestorController::class, 'reinvest'])->name('investor.reinvest');
});

// Agent Dashboard Routes
Route::middleware(['auth', 'role:agent'])->prefix('agent')->group(function () {
    Route::get('/', [AgentController::class, 'dashboard'])->name('agent.dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('agent.profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile']);
    Route::get('/properties', [AgentController::class, 'index'])->name('agent.properties.index');
    Route::get('/properties/create', [AgentController::class, 'create'])->name('agent.properties.create');
    Route::post('/properties', [AgentController::class, 'store'])->name('agent.properties.store');
    Route::get('/properties/{property}/edit', [AgentController::class, 'edit'])->name('agent.properties.edit');
    Route::put('/properties/{property}', [AgentController::class, 'update'])->name('agent.properties.update');
    Route::delete('/properties/{property}', [AgentController::class, 'destroy'])->name('agent.properties.destroy');
    Route::get('/bookings', [AgentController::class, 'bookings'])->name('agent.bookings');
    Route::get('/inquiries', [AgentController::class, 'inquiries'])->name('agent.inquiries');
    Route::get('/transactions', [AgentController::class, 'transactions'])->name('agent.transactions');
});

// Admin Dashboard Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('admin.profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile']);
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');
    Route::post('/users/{user}/activate', [AdminController::class, 'activateUser'])->name('admin.users.activate');
    Route::post('/users/{user}/deactivate', [AdminController::class, 'deactivateUser'])->name('admin.users.deactivate');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::post('/users/{user}/impersonate', [AdminController::class, 'impersonateUser'])->name('admin.users.impersonate');
    Route::post('/users/{user}/approve-investor', [AdminController::class, 'approveInvestor'])->name('admin.users.approve-investor');
    Route::post('/users/{user}/approve-agent', [AdminController::class, 'approveAgent'])->name('admin.users.approve-agent');
    
    // Property Management
    Route::get('/properties', [AdminController::class, 'properties'])->name('admin.properties');
    Route::get('/properties/create', [AdminController::class, 'createProperty'])->name('admin.properties.create');
    Route::post('/properties', [AdminController::class, 'storeProperty'])->name('admin.properties.store');
    Route::get('/properties/{property}/edit', [AdminController::class, 'editProperty'])->name('admin.properties.edit');
    Route::put('/properties/{property}', [AdminController::class, 'updateProperty'])->name('admin.properties.update');
    Route::post('/properties/{property}/approve', [AdminController::class, 'approveProperty'])->name('admin.properties.approve');
    Route::post('/properties/{property}/reject', [AdminController::class, 'rejectProperty'])->name('admin.properties.reject');
    Route::post('/properties/{property}/toggle-featured', [AdminController::class, 'toggleFeatured'])->name('admin.properties.toggle-featured');
    Route::post('/properties/{property}/update-tags', [AdminController::class, 'updateTags'])->name('admin.properties.update-tags');
    Route::post('/properties/{property}/mark-sold', [AdminController::class, 'markAsSold'])->name('admin.properties.mark-sold');
    Route::post('/properties/{property}/mark-available', [AdminController::class, 'markAsAvailable'])->name('admin.properties.mark-available');
    Route::delete('/properties/{property}', [AdminController::class, 'deleteProperty'])->name('admin.properties.delete');
    
    // Bookings Management
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');
    Route::post('/bookings/{inspection}/assign', [AdminController::class, 'assignInspection'])->name('admin.bookings.assign');
    Route::post('/bookings/{inspection}/status', [AdminController::class, 'updateInspectionStatus'])->name('admin.bookings.status');
    
    // Payments Management
    Route::get('/payments', [AdminController::class, 'payments'])->name('admin.payments');
    Route::post('/payments/{payment}/approve', [AdminController::class, 'approvePayment'])->name('admin.payments.approve');
    Route::post('/payments/{payment}/reject', [AdminController::class, 'rejectPayment'])->name('admin.payments.reject');
    Route::delete('/payments/{payment}', [AdminController::class, 'destroyPayment'])->name('admin.payments.destroy');
    
    // Sales Management
    Route::get('/sales', [AdminController::class, 'sales'])->name('admin.sales');
    Route::get('/sales/create', [AdminController::class, 'createSale'])->name('admin.sales.create');
    Route::post('/sales', [AdminController::class, 'storeSale'])->name('admin.sales.store');
    Route::get('/sales/{payment}', [AdminController::class, 'showSale'])->name('admin.sales.show');
    Route::get('/sales/{payment}/receipt/print', [AdminController::class, 'printReceipt'])->name('admin.sales.receipt.print');
    Route::get('/sales/{payment}/receipt/download', [AdminController::class, 'downloadReceipt'])->name('admin.sales.receipt.download');
    Route::get('/sales/{payment}/receipt/share', [AdminController::class, 'receiptShareImage'])->name('admin.sales.receipt.share');
    Route::delete('/sales/{payment}', [AdminController::class, 'destroySale'])->name('admin.sales.destroy');

    // Purchase History
    Route::get('/purchase-history', [AdminController::class, 'purchaseHistory'])->name('admin.purchase-history');
    Route::delete('/purchase-history/{purchase}', [AdminController::class, 'destroyPurchaseHistory'])->name('admin.purchase-history.destroy');

    // Sale History (property sales only, not rent)
    Route::get('/sale-history', [AdminController::class, 'saleHistory'])->name('admin.sale-history');

    // Financial Reports & Profit Tracking
    Route::get('/finance', [FinanceController::class, 'index'])->name('admin.finance');
    Route::get('/finance/expenses/create', [FinanceController::class, 'createExpense'])->name('admin.finance.expenses.create');
    Route::get('/finance/expenses/{expense}/edit', [FinanceController::class, 'editExpense'])->name('admin.finance.expenses.edit');
    Route::post('/finance/expenses', [FinanceController::class, 'storeExpense'])->name('admin.finance.expenses.store');
    Route::put('/finance/expenses/{expense}', [FinanceController::class, 'updateExpense'])->name('admin.finance.expenses.update');
    Route::delete('/finance/expenses/{expense}', [FinanceController::class, 'destroyExpense'])->name('admin.finance.expenses.destroy');
    Route::get('/finance/purchases/create', [FinanceController::class, 'createPurchase'])->name('admin.finance.purchases.create');
    Route::get('/finance/purchases/{purchase}/edit', [FinanceController::class, 'editPurchase'])->name('admin.finance.purchases.edit');
    Route::post('/finance/purchases', [FinanceController::class, 'storePurchase'])->name('admin.finance.purchases.store');
    Route::put('/finance/purchases/{purchase}', [FinanceController::class, 'updatePurchase'])->name('admin.finance.purchases.update');
    Route::delete('/finance/purchases/{purchase}', [FinanceController::class, 'destroyPurchase'])->name('admin.finance.purchases.destroy');
    
    // Activity Logs
    Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('admin.activity-logs');
    
    // Investment Management
    Route::get('/investments', [AdminController::class, 'investments'])->name('admin.investments');
    Route::post('/investments/{investment}/approve-withdrawal', [AdminController::class, 'approveWithdrawal'])->name('admin.investments.approve-withdrawal');
    Route::post('/investments/{investment}/mark-paid', [AdminController::class, 'markWithdrawalPaid'])->name('admin.investments.mark-paid');
    Route::post('/investments/{investment}/reject-withdrawal', [AdminController::class, 'rejectWithdrawal'])->name('admin.investments.reject-withdrawal');
    
    // Contact Messages / Inquiries
    Route::get('/inquiries', [AdminController::class, 'inquiries'])->name('admin.inquiries');
    Route::get('/inquiries/{inquiry}', [AdminController::class, 'showInquiry'])->name('admin.inquiries.show');
    Route::post('/inquiries/{inquiry}/status', [AdminController::class, 'updateInquiryStatus'])->name('admin.inquiries.status');
    
    // User Profile Views
    Route::get('/users/{user}/profile', [AdminController::class, 'viewUserProfile'])->name('admin.users.profile');
    
    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    
    // Blog Management
    Route::get('/blogs', [BlogController::class, 'adminIndex'])->name('admin.blogs.index');
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('admin.blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('admin.blogs.store');
    Route::get('/blogs/{id}/edit', [BlogController::class, 'edit'])->name('admin.blogs.edit');
    Route::put('/blogs/{id}', [BlogController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy'])->name('admin.blogs.destroy');
    
    // Promotions Management
    Route::get('/promotions', [AdminController::class, 'promotions'])->name('admin.promotions');
    Route::post('/promotions', [AdminController::class, 'storePromotion'])->name('admin.promotions.store');
    Route::delete('/promotions/{promotion}', [AdminController::class, 'deletePromotion'])->name('admin.promotions.delete');
});
