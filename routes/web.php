<?php

use App\Http\Controllers\LinkListController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\AdminPublisherController;
use App\Http\Controllers\EmailCampaignController;
use App\Http\Controllers\EmailListController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\EmailFromController;
use App\Http\Controllers\ImageManagerController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ClientSummaryReports;
use App\Http\Controllers\RolePermissionController;

use App\Http\Controllers\NicheController;
use App\Http\Controllers\SiteListController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\CouponControlller;
use App\Http\Controllers\PageController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\WhyUsController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ClientTestimonialController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserProfileController;

use App\Http\Controllers\PublisherController;
use App\Http\Controllers\PublisherDashboardController;
use App\Http\Controllers\publisherProfileController;
use App\Http\Controllers\PublisherLinkListController;

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Mpdf\Tag\Article;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::post('/password/update', [ResetPasswordController::class, 'updatePassword'])->name('password.update');

/* Admin routs */

Route::get('/admin', function () {
    return redirect()->route('admin.login');
});

/* Publisher routs */
// Route::get('/publisher', function () {
//     return redirect()->route('publisher.login');
// });

// All User Route Start Here
// Route::get('/login', [LoginController::class, 'index'])->name('login');
// Route::post('/login', [LoginController::class, 'userLogin']);
// Route::get('/register', [RegisterController::class, 'index'])->name('register');
// Route::post('/register', [RegisterController::class, 'userRegister']);

Route::name('user.')->group(function () {
    Route::prefix('/user')->group(function () {

        // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        /* User Routs */
        // Route::prefix('/user')->group(function () {
        //     // Route::get('/', [UserController::class, 'index'])->name('user');
        //     // Route::get('/create', [UserController::class, 'create'])->name('user.create');
        //     // Route::post('/store', [UserController::class, 'store'])->name('user.store');
        //     Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        //     Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
        //     Route::post('/update-password/{id}', [UserController::class, 'updatePassword'])->name('user.update-password');
        //     // Route::get('/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        //     Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
        //     Route::post('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
        //     Route::post('/profile/update-password', [UserProfileController::class, 'updatePassword'])->name('profile.update-password');

        // });

        /* Order Routs */
        Route::prefix('/order')->group(function () {
            Route::any('/', [CheckoutController::class, 'index'])->name('order');
            Route::get('/checkout/{pid}', [CheckoutController::class, 'checkout'])->name('order.checkout');
            Route::get('/invoice/{oid}', [CheckoutController::class, 'invoice'])->name('order.invoice');
            Route::post('/store', [CheckoutController::class, 'store'])->name('order.store');
            Route::get('/edit/{oid}', [CheckoutController::class, 'edit'])->name('order.edit');
            Route::post('/update', [CheckoutController::class, 'update'])->name('order.update');
        });

        /* Settings Routs */
        // Route::prefix('/settings')->group(function () {
        //     Route::get('/', [SettingController::class, 'index'])->name('settings');
        //     Route::post('/store', [SettingController::class, 'store'])->name('settings.store');
        //     Route::get('/destroy/{mkey}', [SettingController::class, 'destroy'])->name('settings.destroy');
        // });
    });
});
// All User Route End Here

// All Publisher Route Start Here
// Route::get('/publisher/login', [LoginController::class, 'showPublisherLoginForm'])->name('publisher.login');
// Route::post('/publisher/login', [LoginController::class, 'publisherLogin']);
// Route::get('/publisher/register', [RegisterController::class, 'showPublisherRegisterForm'])->name('publisher.register');
// Route::post('/publisher/register', [RegisterController::class, 'createPublisher']);

// Route::name('publisher.')->group(function () {
//     Route::prefix('/publisher')->group(function () {

//         Route::get('/dashboard', [PublisherDashboardController::class, 'index'])->name('dashboard');

//         /* User Routs */
//         Route::prefix('/user')->group(function () {
//             // Route::get('/', [PublisherController::class, 'index'])->name('user');
//             // Route::get('/create', [PublisherController::class, 'create'])->name('user.create');
//             // Route::post('/store', [PublisherController::class, 'store'])->name('user.store');
//             Route::get('/edit/{id}', [PublisherController::class, 'edit'])->name('user.edit');
//             Route::post('/update/{id}', [PublisherController::class, 'update'])->name('user.update');
//             Route::post('/update-password/{id}', [PublisherController::class, 'updatePassword'])->name('user.update-password');
//             // Route::get('/destroy/{id}', [PublisherController::class, 'destroy'])->name('user.destroy');

//             Route::get('/profile', [publisherProfileController::class, 'index'])->name('profile');
//             Route::post('/profile/update', [publisherProfileController::class, 'update'])->name('profile.update');
//             Route::post('/profile/update-password', [publisherProfileController::class, 'updatePassword'])->name('profile.update-password');

//         });

//         /* Link Placement Routs */
//         Route::prefix('/link_list')->group(function () {
//             Route::get('/', [PublisherLinkListController::class, 'index'])->name('link_list');
//             Route::get('/show/{id}', [PublisherLinkListController::class, 'show'])->name('link_list.show');
//         });
//     });
// });
// All Publisher Route End Here

// All Admin Route Start Here
Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'adminLogin']);
Route::get('/admin/register', [RegisterController::class, 'showAdminRegisterForm'])->name('admin.register');
Route::post('/admin/register', [RegisterController::class, 'createAdmin']);


Route::name('admin.')->group(function () {
    Route::prefix('/admin')->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        /* Admin Routs */
        Route::prefix('/user')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('user');
            Route::get('/create', [AdminController::class, 'create'])->name('user.create');
            Route::post('/store', [AdminController::class, 'store'])->name('user.store');
            Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('user.edit');
            Route::post('/update/{id}', [AdminController::class, 'update'])->name('user.update');
            Route::post('/update-password/{id}', [AdminController::class, 'updatePassword'])->name('user.update-password');
            Route::get('/destroy/{id}', [AdminController::class, 'destroy'])->name('user.destroy');

            Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
            Route::post('/profile/update', [AdminProfileController::class, 'update'])->name('profile.update');
            Route::post('/profile/update-password', [AdminProfileController::class, 'updatePassword'])->name('profile.update-password');
        });

        /* User List Routs */
        // Route::prefix('/users')->group(function () {
        //     Route::get('/', [AdminUsersController::class, 'index'])->name('users');
        //     Route::get('/create', [AdminUsersController::class, 'create'])->name('users.create');
        //     Route::post('/store', [AdminUsersController::class, 'store'])->name('users.store');
        //     Route::get('/edit/{id}', [AdminUsersController::class, 'edit'])->name('users.edit');
        //     Route::post('/update/{id}', [AdminUsersController::class, 'update'])->name('users.update');
        //     Route::post('/update-password/{id}', [AdminUsersController::class, 'updatePassword'])->name('users.update-password');
        //     Route::get('/destroy/{id}', [AdminUsersController::class, 'destroy'])->name('users.destroy');
        // });

        /* Publisher List Routs */
        // Route::prefix('/publisher')->group(function () {
        //     Route::get('/', [AdminPublisherController::class, 'index'])->name('publisher');
        //     Route::get('/create', [AdminPublisherController::class, 'create'])->name('publisher.create');
        //     Route::post('/store', [AdminPublisherController::class, 'store'])->name('publisher.store');
        //     Route::get('/edit/{id}', [AdminPublisherController::class, 'edit'])->name('publisher.edit');
        //     Route::post('/update/{id}', [AdminPublisherController::class, 'update'])->name('publisher.update');
        //     Route::post('/update-password/{id}', [AdminPublisherController::class, 'updatePassword'])->name('publisher.update-password');
        //     Route::get('/destroy/{id}', [AdminPublisherController::class, 'destroy'])->name('publisher.destroy');
        // });

        /* Link Placement Routs */
        Route::prefix('/link_list')->group(function () {
            Route::get('/', [LinkListController::class, 'index'])->name('link_list');
            Route::get('/create', [LinkListController::class, 'create'])->name('link_list.create');
            Route::post('/store', [LinkListController::class, 'store'])->name('link_list.store');
            Route::get('/show/{id}', [LinkListController::class, 'show'])->name('link_list.show');
            Route::get('/edit/{id}', [LinkListController::class, 'edit'])->name('link_list.edit');
            Route::post('/update', [LinkListController::class, 'update'])->name('link_list.update');
            Route::get('/destroy/{id}', [LinkListController::class, 'destroy'])->name('link_list.destroy');
            Route::get('/destroy-featured-image/{id}', [LinkListController::class, 'destroyFeaturedImage'])->name('link_list.destroy-featured-image');
        });

        // Role
        Route::get('/role', [RolePermissionController::class, 'index'])->name('role');
        Route::get('/role/create', [RolePermissionController::class, 'create'])->name('role.create');
        Route::post('/role/store', [RolePermissionController::class, 'store'])->name('role.store');
        Route::get('/role/edit/{id}', [RolePermissionController::class, 'edit'])->name('role.edit');
        Route::post('/role/update/{id}', [RolePermissionController::class, 'update'])->name('role.update');
        Route::get('/role/destroy/{id}', [RolePermissionController::class, 'destroy'])->name('role.destroy');

        /* Blog Routs */
        Route::prefix('/blog')->group(function () {
            Route::get('/', [BlogController::class, 'index'])->name('blog');
            Route::get('/create', [BlogController::class, 'create'])->name('blog.create');
            Route::post('/store', [BlogController::class, 'store'])->name('blog.store');
            Route::get('/edit/{id?}', [BlogController::class, 'edit'])->name('blog.edit');
            Route::post('/update/{id?}', [BlogController::class, 'update'])->name('blog.update');
            Route::get('/destroy/{id?}', [BlogController::class, 'destroy'])->name('blog.destroy');
            Route::get('/destroy-featured-image/{id}', [BlogController::class, 'destroyFeaturedImage'])->name('blog.destroy-featured-image');
        });

        /* Email Template Routs */
        Route::prefix('/email')->group(function () {

            Route::any('/', [EmailListController::class, 'index'])->name('email');
            Route::post('/store', [EmailListController::class, 'store'])->name('email.store');
            Route::post('/store-csv', [EmailListController::class, 'storeCsv'])->name('email.store-csv');
            Route::post('/edit', [EmailListController::class, 'edit'])->name('email.edit');
            Route::post('/update', [EmailListController::class, 'update'])->name('email.update');
            Route::get('/destroy/{id}', [EmailListController::class, 'destroy'])->name('email.destroy');


            Route::name('email.')->group(function () {
                Route::get('/send', [EmailCampaignController::class, 'sendEmail'])->name('send');
                Route::get('/pending', [EmailCampaignController::class, 'pendingMail'])->name('pending');
                Route::get('/failed', [EmailCampaignController::class, 'failedMail'])->name('failed');
                Route::get('/retry/{id}', [EmailCampaignController::class, 'retryMail'])->name('retry');
                Route::get('/retry-all', [EmailCampaignController::class, 'retryAllMail'])->name('retry-all');
                Route::get('/clear-all', [EmailCampaignController::class, 'clearAllMail'])->name('clear-all');
                Route::get('/failed/destroy/{id}', [EmailCampaignController::class, 'failedDestroy'])->name('failed.destroy');
                Route::get('/campaign', [EmailCampaignController::class, 'index'])->name('campaign');
                Route::get('/campaign/create', [EmailCampaignController::class, 'create'])->name('campaign.create');
                Route::post('/campaign/store', [EmailCampaignController::class, 'store'])->name('campaign.store');
                Route::get('/campaign/success', [EmailCampaignController::class, 'success'])->name('campaign.success');
                Route::post('/campaign/edit', [EmailCampaignController::class, 'edit'])->name('campaign.edit');
                Route::post('/campaign/update', [EmailCampaignController::class, 'update'])->name('campaign.update');
                Route::get('/campaign/destroy/{id}', [EmailCampaignController::class, 'destroy'])->name('campaign.destroy');
            });

            Route::name('email.')->group(function () {
                Route::get('/template', [EmailTemplateController::class, 'index'])->name('template');
                Route::get('/template/create', [EmailTemplateController::class, 'create'])->name('template.create');
                Route::post('/template/store', [EmailTemplateController::class, 'store'])->name('template.store');
                Route::get('/template/edit/{id}', [EmailTemplateController::class, 'edit'])->name('template.edit');
                Route::post('/template/update/{id}', [EmailTemplateController::class, 'update'])->name('template.update');
                Route::get('/template/destroy/{id}', [EmailTemplateController::class, 'destroy'])->name('template.destroy');
            });

            Route::name('email.')->group(function () {
                Route::get('/from', [EmailFromController::class, 'index'])->name('from');
                Route::get('/from/create', [EmailFromController::class, 'create'])->name('from.create');
                Route::post('/from/store', [EmailFromController::class, 'store'])->name('from.store');
                Route::post('/from/edit', [EmailFromController::class, 'edit'])->name('from.edit');
                Route::post('/from/update', [EmailFromController::class, 'update'])->name('from.update');
                Route::get('/from/destroy/{id}', [EmailFromController::class, 'destroy'])->name('from.destroy');
            });

            Route::name('email.')->group(function () {
                Route::get('/images', [ImageManagerController::class, 'index'])->name('images');
                Route::get('/images/create', [ImageManagerController::class, 'create'])->name('images.create');
                Route::post('/images/store', [ImageManagerController::class, 'store'])->name('images.store');
                Route::post('/images/edit', [ImageManagerController::class, 'edit'])->name('images.edit');
                Route::post('/images/update', [ImageManagerController::class, 'update'])->name('images.update');
                Route::get('/images/destroy/{id}', [ImageManagerController::class, 'destroy'])->name('images.destroy');
            });
        });

        /* Payment Method Routs */
        Route::get('/payment-method', [PaymentMethodController::class, 'index'])->name('payment-method');
        Route::post('/payment-method/store', [PaymentMethodController::class, 'store'])->name('payment-method.store');
        Route::post('/payment-method/edit', [PaymentMethodController::class, 'edit'])->name('payment-method.edit');
        Route::post('/payment-method/update', [PaymentMethodController::class, 'update'])->name('payment-method.update');
        Route::get('/payment-method/destroy/{paymentMethod}', [PaymentMethodController::class, 'destroy'])->name('payment-method.destroy');

        /* Page Routs */
        Route::get('/page/{page_url?}', [PageController::class, 'index'])->name('page');
        Route::post('/page-update/{id}', [PageController::class, 'update'])->name('page-update');
        Route::get('/destroy-featured-image/{id}', [PageController::class, 'destroyFeaturedImage'])->name('page.destroy-featured-image');


        /*Route::prefix('/page')->group(function () {
            Route::get('/', [PageController::class, 'index'])->name('page');
            Route::get('/create', [PageController::class, 'create'])->name('page.create');
            Route::post('/store', [PageController::class, 'store'])->name('page.store');
            Route::get('/edit/{id}', [PageController::class, 'edit'])->name('page.edit');
            Route::post('/update/{id}', [PageController::class, 'update'])->name('page.update');
            Route::get('/destroy/{id}', [PageController::class, 'destroy'])->name('page.destroy');
            Route::get('/destroy-featured-image/{id}', [PageController::class, 'destroyFeaturedImage'])->name('page.destroy-featured-image');
        });*/

        /* Service Routs */
        Route::prefix('/home-page')->group(function () {
            Route::get('/', [HomePageController::class, 'index'])->name('home-page');
            Route::name('home-page.')->group(function () {
                Route::post('/update/hero', [HomePageController::class, 'updateHero'])->name('updateHero');
                Route::post('/update/statistics', [HomePageController::class, 'updateStatistics'])->name('updateStatistics');
                Route::post('/update/choose-us', [HomePageController::class, 'updateChooseUs'])->name('updateChooseUs');
                Route::post('/update/cta', [HomePageController::class, 'updateCta'])->name('updateCta');
                Route::post('/store', [HomePageController::class, 'store'])->name('store');
                Route::get('/edit/{id}', [HomePageController::class, 'edit'])->name('edit');
                Route::post('/update', [HomePageController::class, 'update'])->name('update');
                Route::get('/destroy/{id}', [HomePageController::class, 'destroy'])->name('destroy');
            });
        });

        Route::prefix('/service')->group(function () {
            Route::get('/', [ServicesController::class, 'index'])->name('service');
            Route::get('/create', [ServicesController::class, 'create'])->name('service.create');
            Route::post('/store', [ServicesController::class, 'store'])->name('service.store');
            Route::get('/edit/{id}', [ServicesController::class, 'edit'])->name('service.edit');
            Route::post('/update', [ServicesController::class, 'update'])->name('service.update');
            Route::get('/destroy/{id}', [ServicesController::class, 'destroy'])->name('service.destroy');
            Route::get('/destroy-featured-image/{id}', [ServicesController::class, 'destroyFeaturedImage'])->name('service.destroy-featured-image');
        });

        /* Package Routs */
        Route::prefix('/package')->group(function () {
            Route::get('/', [PackageController::class, 'index'])->name('package');
            Route::get('/create', [PackageController::class, 'create'])->name('package.create');
            Route::post('/store', [PackageController::class, 'store'])->name('package.store');
            Route::get('/edit/{id}', [PackageController::class, 'edit'])->name('package.edit');
            Route::post('/update', [PackageController::class, 'update'])->name('package.update');
            Route::get('/destroy/{id}', [PackageController::class, 'destroy'])->name('package.destroy');
        });

        /* Team Routs */
        Route::prefix('/teams')->group(function () {
            Route::get('/', [TeamController::class, 'index'])->name('teams');
            Route::get('/create', [TeamController::class, 'create'])->name('teams.create');
            Route::post('/store', [TeamController::class, 'store'])->name('teams.store');
            Route::get('/edit/{id}', [TeamController::class, 'edit'])->name('teams.edit');
            Route::post('/update/{id}', [TeamController::class, 'update'])->name('teams.update');
            Route::get('/destroy/{id}', [TeamController::class, 'destroy'])->name('teams.destroy');
            Route::get('/destroy-featured-image/{id}', [TeamController::class, 'destroyFeaturedImage'])->name('teams.destroy-featured-image');
        });

        /* Client Testimonials Routs */
        Route::prefix('/client-testimonial')->group(function () {
            Route::get('/', [ClientTestimonialController::class, 'index'])->name('client-testimonial');
            Route::get('/create', [ClientTestimonialController::class, 'create'])->name('client-testimonial.create');
            Route::post('/store', [ClientTestimonialController::class, 'store'])->name('client-testimonial.store');
            Route::get('/edit/{id}', [ClientTestimonialController::class, 'edit'])->name('client-testimonial.edit');
            Route::post('/update/{id}', [ClientTestimonialController::class, 'update'])->name('client-testimonial.update');
            Route::get('/destroy/{id}', [ClientTestimonialController::class, 'destroy'])->name('client-testimonial.destroy');
            Route::get('/destroy-featured-image/{id}', [ClientTestimonialController::class, 'destroyFeaturedImage'])->name('client-testimonial.destroy-featured-image');
        });

        /* Why Choose Us Routs */
        Route::prefix('/why-us')->group(function () {
            Route::get('/', [WhyUsController::class, 'index'])->name('why-us');
            Route::post('/store', [WhyUsController::class, 'store'])->name('why-us.store');
            Route::post('/edit', [WhyUsController::class, 'edit'])->name('why-us.edit');
            Route::post('/update', [WhyUsController::class, 'update'])->name('why-us.update');
            Route::get('/destroy/{id}', [WhyUsController::class, 'destroy'])->name('why-us.destroy');
        });

        /* FAQ Routs */
        Route::prefix('/faq')->group(function () {
            Route::get('/', [FaqController::class, 'index'])->name('faq');
            Route::post('/store', [FaqController::class, 'store'])->name('faq.store');
            Route::post('/edit', [FaqController::class, 'edit'])->name('faq.edit');
            Route::post('/update', [FaqController::class, 'update'])->name('faq.update');
            Route::get('/destroy/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');
        });

        /* Inbox Routs */
        Route::prefix('/inbox')->group(function () {
            Route::get('/', [InboxController::class, 'index'])->name('inbox');
            Route::get('/show/{id}', [InboxController::class, 'show'])->name('inbox.show');
            Route::get('/destroy/{id}', [InboxController::class, 'destroy'])->name('inbox.destroy');
        });

        /* Newsletter Routs */
        Route::prefix('/newsletter')->group(function () {
            Route::get('/', [NewsletterController::class, 'index'])->name('newsletter');
            Route::get('/destroy/{id}', [NewsletterController::class, 'destroy'])->name('newsletter.destroy');
        });

        /* Brand Routs */
        Route::prefix('/brand')->group(function () {
            Route::get('/', [BrandController::class, 'index'])->name('brand');
            Route::post('/store', [BrandController::class, 'store'])->name('brand.store');
            Route::post('/edit', [BrandController::class, 'edit'])->name('brand.edit');
            Route::post('/update', [BrandController::class, 'update'])->name('brand.update');
            Route::get('/destroy/{id}', [BrandController::class, 'destroy'])->name('brand.destroy');
        });

        /* Niche Routs */
        Route::prefix('/niche')->group(function () {
            Route::get('/', [NicheController::class, 'index'])->name('niche');
            Route::post('/store', [NicheController::class, 'store'])->name('niche.store');
            Route::post('/edit', [NicheController::class, 'edit'])->name('niche.edit');
            Route::post('/update', [NicheController::class, 'update'])->name('niche.update');
            Route::get('/destroy/{id}', [NicheController::class, 'destroy'])->name('niche.destroy');
        });

        /* Site List Routs */
        Route::prefix('/site-list')->group(function () {
            Route::get('/', [SiteListController::class, 'index'])->name('site-list');
            Route::get('/create', [SiteListController::class, 'create'])->name('site-list.create');
            Route::post('/store', [SiteListController::class, 'store'])->name('site-list.store');
            // Route::get('/show/{id}', [SiteListController::class, 'show'])->name('site-list.show');
            Route::get('/edit/{id}', [SiteListController::class, 'edit'])->name('site-list.edit');
            Route::post('/update', [SiteListController::class, 'update'])->name('site-list.update');
            Route::get('/destroy/{id}', [SiteListController::class, 'destroy'])->name('site-list.destroy');
            // Route::get('/destroy-featured-image/{id}', [SiteListController::class, 'destroyFeaturedImage'])->name('site-list.destroy-featured-image');
        });

        /* Order Routs */
        Route::prefix('/order')->group(function () {
            Route::any('/', [OrderController::class, 'index'])->name('order');
            Route::get('/create', [OrderController::class, 'create'])->name('order.create');
            Route::post('/store', [OrderController::class, 'store'])->name('order.store');
            Route::get('/edit/{oid}', [OrderController::class, 'edit'])->name('order.edit');
            Route::post('/update', [OrderController::class, 'update'])->name('order.update');
            Route::get('/invoice/{oid}', [OrderController::class, 'invoice'])->name('order.invoice');

            Route::get('/delete/{id}', [OrderController::class, 'delete'])->name('order.delete');
            Route::get('/published/{id}', [OrderController::class, 'published'])->name('order.published');
            Route::get('/restore/{id}', [OrderController::class, 'restore'])->name('order.restore');
            Route::get('/destroy/{id}', [OrderController::class, 'destroy'])->name('order.destroy');

            Route::get('/change-prepaid/{id}', [OrderController::class, 'changePrepaid'])->name('order.change-prepaid');

            Route::post('/change-live-link', [OrderController::class, 'changeLiveLink'])->name('order.change-live-link');
            Route::post('/change-anchor', [OrderController::class, 'changeAnchor'])->name('order.change-anchor');

            Route::post('/site_info', [OrderController::class, 'liveLink'])->name('order.site_info');
            Route::post('/itemInfo', [OrderController::class, 'itemInfo'])->name('order.itemInfo');
        });

        /* Invoice Routs */
        Route::prefix('/invoice')->group(function () {
            Route::any('/', [InvoiceController::class, 'index'])->name('invoice');
            Route::name('invoice.')->group(function () {
                Route::get('/create', [InvoiceController::class, 'create'])->name('create');
                Route::post('/store', [InvoiceController::class, 'store'])->name('store');
                Route::get('/edit/{id}', [InvoiceController::class, 'edit'])->name('edit');
                Route::get('/show/{id}', [InvoiceController::class, 'show'])->name('show');
                Route::post('/update/{id}', [InvoiceController::class, 'update'])->name('update');
                Route::get('/invoice/{oid}', [InvoiceController::class, 'invoice'])->name('invoice');
                Route::get('/restore/{id}', [InvoiceController::class, 'restore'])->name('restore');
                Route::get('/delete/{id}', [InvoiceController::class, 'delete'])->name('delete');
                Route::get('/destroy/{id}', [InvoiceController::class, 'destroy'])->name('destroy');

                Route::post('/orderInfo', [InvoiceController::class, 'orderInfo'])->name('orderInfo');
                Route::post('/customerInfo', [InvoiceController::class, 'customerInfo'])->name('customerInfo');
                Route::post('/invoiceInfo', [InvoiceController::class, 'invoiceInfo'])->name('invoiceInfo');
                Route::get('/allPendingOrder', [InvoiceController::class, 'allPendingOrder'])->name('allPendingOrder');

                Route::get('/send-mail/{id}', [InvoiceController::class, 'sendMail'])->name('send-mail');
                Route::get('/warning-mail/{id}', [InvoiceController::class, 'warningMail'])->name('warning-mail');
                Route::get('/remove-mail/{id}', [InvoiceController::class, 'removeMail'])->name('remove-mail');


                Route::prefix('/delivery')->group(function () {
                    Route::name('delivery.')->group(function () {
                        Route::get('/create', [DeliveryController::class, 'create'])->name('create');
                        Route::post('/store', [DeliveryController::class, 'store'])->name('store');
                        Route::get('/edit/{id}', [DeliveryController::class, 'edit'])->name('edit');
                        Route::get('/show/{id}', [DeliveryController::class, 'show'])->name('show');
                        Route::post('/update/{id}', [DeliveryController::class, 'update'])->name('update');
                        Route::get('/destroy/{id}', [DeliveryController::class, 'destroy'])->name('destroy');
                    });
                });
            });
        });

        Route::prefix('/coupon')->group(function () {
            Route::any('/', [CouponControlller::class, 'index'])->name('coupon');
            Route::name('coupon.')->group(function () {
                Route::get('/create', [CouponControlller::class, 'create'])->name('create');
                Route::post('/store', [CouponControlller::class, 'store'])->name('store');
                Route::post('/edit', [CouponControlller::class, 'edit'])->name('edit');
                Route::get('/show/{id}', [CouponControlller::class, 'show'])->name('show');
                Route::post('/update', [CouponControlller::class, 'update'])->name('update');
                Route::get('/destroy/{id}', [CouponControlller::class, 'destroy'])->name('destroy');
            });
        });

        /* Invoice Routs */
        Route::prefix('/reports')->group(function () {
            Route::any('/', [ReportController::class, 'index'])->name('reports');
            Route::get('/invoices', [ReportController::class, 'invoices'])->name('reports.invoices');
            Route::get('/sites', [ReportController::class, 'sites'])->name('reports.sites');
            Route::get('/sites-summary', [ReportController::class, 'sites_summary'])->name('reports.sites-summary');
            Route::get('/sites-selling', [ReportController::class, 'sites_selling'])->name('reports.sites-selling');
            Route::any('/client-summary', [ClientSummaryReports::class, 'index'])->name('reports.client-summary');
        });

        /* Settings Routs */
        Route::prefix('/settings')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('settings');
            Route::post('/store', [SettingController::class, 'store'])->name('settings.store');
            Route::get('/destroy/{mkey}', [SettingController::class, 'destroy'])->name('settings.destroy');
            Route::post('/statistics', [SettingController::class, 'getStatistics'])->name('settings.statistics');
            ;
        });

        /* About Us Routs */
        Route::prefix('/about-us')->group(function () {
            Route::get('/', [AboutUsController::class, 'index'])->name('about-us');
            Route::post('/store', [AboutUsController::class, 'store'])->name('about-us.store');
            Route::get('/destroy-featured-image/{id}', [AboutUsController::class, 'destroyFeaturedImage'])->name('about-us.destroy-featured-image');
        });
    });
});
// All Admin Route End Here

/*Artisan Commends*/
Route::get('/clear', function () {
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    ResponseCache::clear();
    flash()->addSuccess('Clear successful.');
    return redirect()->route('home');
});

Route::get('/cache', function () {
    Artisan::call('view:cache');
    flash()->addSuccess('Cache successful.');
    return redirect()->route('home');
});

/* Frontend route */
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/contact-email', [HomeController::class, 'contactEmail']);
Route::post('/newslatter', [HomeController::class, 'newslatter'])->name('newslatter');

Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/blog', [HomeController::class, 'blog']);
Route::get('/blog-details/{url}', [HomeController::class, 'blogDetail']);
Route::get('/service/{url}', [HomeController::class, 'singleService']);
Route::get('/pricing/{url}', [HomeController::class, 'pricing']);
Route::get('/about-us', [HomeController::class, 'aboutUs']);
Route::get('/login', [HomeController::class, 'login']);

Route::get('/guest-posting', [HomeController::class, 'guestPosting']);
Route::get('/link-insertion', [HomeController::class, 'linkInsertion']);

Route::get('/activities/{id}', [HomeController::class, 'activities']);

// Order Download & Copy URL
Route::get('/download-order-invoice/{id}', [HomeController::class, 'download']);
Route::get('/order-invoice/{id}', [HomeController::class, 'orderInvoice']);

// invoice Download & Copy URL
Route::get('/download-invoice/{id}', [HomeController::class, 'downloadInvoice']);
Route::get('/invoice/{id}', [HomeController::class, 'invoiceView']);

//Extra page Routes
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy']);
Route::get('/terms-of-service', [HomeController::class, 'termsService']);
Route::get('/refund-policy', [HomeController::class, 'refundPolicy']);
Route::get('/dmca', [HomeController::class, 'dmca']);

Route::get('/websites', [HomeController::class, 'siteList']);
Route::get('/websites/{id}/details', [HomeController::class, 'siteDetails']);
/* Frontend route */
