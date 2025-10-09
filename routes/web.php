<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Clan\Info\AdminInfoController;
use App\Http\Controllers\Admin\Clan\Regulation\AdminRegulationController;
use App\Http\Controllers\Admin\Clan\Application\AdminApplicationController;
use App\Http\Controllers\Admin\Clan\Coslist\AdminCoslistController;
use App\Http\Controllers\Public\Clan\Info\PublicInfoController;
use App\Http\Controllers\Public\Clan\Regulation\PublicRegulationController;
use App\Http\Controllers\Public\Clan\Application\PublicApplicationController;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\Public\Link\PublicContactController;
use App\Http\Controllers\Admin\Link\AdminContactController;
use App\Http\Controllers\Public\Forum\PublicForumController;
use App\Http\Controllers\Admin\Forum\AdminForumSectionController;
use App\Http\Controllers\Admin\Forum\AdminForumSubsectionController;
use App\Http\Controllers\Public\Forum\ForumReplyController;
use App\Http\Controllers\User\Guide\UserGuideController;
use App\Http\Controllers\Social\CommentController;
use App\Http\Controllers\Social\LikeController;
use App\Http\Controllers\User\Galery\Photo\UserPhotoController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\Galery\Screenshot\UserScreenshotController;
use App\Http\Controllers\User\Galery\Other\UserOtherController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\User\AdminUserController;
use App\Http\Controllers\Member\ApplicationVoteController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

// Temporary login route to satisfy auth redirects (replace with real auth later)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Public
Route::get('/clan', [PublicInfoController::class, 'index'])->name('clan.info.index');
Route::get('/clan/regulation', [PublicRegulationController::class, 'index'])->name('clan.regulation');
Route::get('/clan/application', [PublicApplicationController::class, 'create'])->name('clan.application');
Route::post('/clan/application', [PublicApplicationController::class, 'store'])
    ->middleware('throttle:application-submissions')
    ->name('clan.application.store');

Route::get('/clan/coslist', [\App\Http\Controllers\Public\Clan\Coslist\PublicCoslistController::class, 'index'])->name('clan.coslist.index');




// Gallery
Route::get('/gallery/photo', [UserPhotoController::class, 'index'])->name('gallery.photo.index');
Route::middleware('auth')->group(function () {
    Route::get('/gallery/photo/create', [UserPhotoController::class, 'create'])->name('gallery.photo.create');
    Route::get('/gallery/photo/{photo}/edit', [UserPhotoController::class, 'edit'])->name('gallery.photo.edit');
    Route::post('/gallery/photo', [UserPhotoController::class, 'store'])->name('gallery.photo.store');
    Route::put('/gallery/photo/{photo}', [UserPhotoController::class, 'update'])->name('gallery.photo.update');
    Route::delete('/gallery/photo/{photo}', [UserPhotoController::class, 'destroy'])->name('gallery.photo.destroy');
});
Route::get('/gallery/photo/{photo}', [UserPhotoController::class, 'show'])->name('gallery.photo.show');

// Gallery: screenshots
Route::get('/gallery/screenshots', [UserScreenshotController::class, 'index'])->name('gallery.screenshot.index');
Route::middleware('auth')->group(function () {
    Route::get('/gallery/screenshots/create', [UserScreenshotController::class, 'create'])->name('gallery.screenshot.create');
    Route::post('/gallery/screenshots', [UserScreenshotController::class, 'store'])->name('gallery.screenshot.store');
    Route::get('/gallery/screenshots/{photo}/edit', [UserScreenshotController::class, 'edit'])->name('gallery.screenshot.edit');
    Route::put('/gallery/screenshots/{photo}', [UserScreenshotController::class, 'update'])->name('gallery.screenshot.update');
    Route::delete('/gallery/screenshots/{photo}', [UserScreenshotController::class, 'destroy'])->name('gallery.screenshot.destroy');
});
Route::get('/gallery/screenshots/{photo}', [UserScreenshotController::class, 'show'])->name('gallery.screenshot.show');

// Gallery: other
Route::get('/gallery/other', [UserOtherController::class, 'index'])->name('gallery.other.index');
Route::middleware('auth')->group(function () {
    Route::get('/gallery/other/create', [UserOtherController::class, 'create'])->name('gallery.other.create');
    Route::post('/gallery/other', [UserOtherController::class, 'store'])->name('gallery.other.store');
    Route::get('/gallery/other/{photo}/edit', [UserOtherController::class, 'edit'])->name('gallery.other.edit');
    Route::put('/gallery/other/{photo}', [UserOtherController::class, 'update'])->name('gallery.other.update');
    Route::delete('/gallery/other/{photo}', [UserOtherController::class, 'destroy'])->name('gallery.other.destroy');
});
Route::get('/gallery/other/{photo}', [UserOtherController::class, 'show'])->name('gallery.other.show');

Route::get('/link', [PublicContactController::class, 'index'])->name('link.index');
Route::get('/forum', [PublicForumController::class, 'index'])->name('forum.index');
Route::get('/forum/{sectionSlug}/{subSlug}', [PublicForumController::class, 'subsection'])->name('forum.subsection');
Route::middleware('auth')->group(function () {
    Route::post('/forum/{sectionSlug}/{subSlug}/replies', [ForumReplyController::class, 'store'])->name('forum.replies.store');
    Route::put('/forum/{sectionSlug}/{subSlug}/replies/{reply}', [ForumReplyController::class, 'update'])->name('forum.replies.update');
    Route::delete('/forum/{sectionSlug}/{subSlug}/replies/{reply}', [ForumReplyController::class, 'destroy'])->name('forum.replies.delete');
    // pin/unpin for admins and moderators
    Route::post('/forum/{sectionSlug}/{subSlug}/replies/{reply}/pin', function (string $sectionSlug, string $subSlug, \App\Models\ForumReply $reply) {
        $user = Auth::user();
        abort_unless($user && in_array($user->role, ['admin','moderator']), 403);
        $reply->update(['pinned' => !$reply->pinned]);
        return redirect()->route('forum.subsection', [$sectionSlug, $subSlug]);
    })->name('forum.replies.pin');
});

// Member voting for applications (member or higher)
Route::middleware(['auth','role:member,moderator,admin'])->group(function () {
    Route::get('/member/applications', [ApplicationVoteController::class, 'index'])->name('member.applications.index');
    Route::post('/member/applications/{application}/vote', [ApplicationVoteController::class, 'vote'])->name('member.applications.vote');
});

Route::get('/guide/east', function () {
    return redirect()->route('guide.east.index');
});

Route::get('/guide/central', function () {
    return redirect()->route('guide.central.index');
});

Route::get('/guide/north', function () {
    return redirect()->route('guide.north.index');
});

Route::get('/guide/other', function () {
    return redirect()->route('guide.other.index');
});

Route::get('/guide/west', function () {
    return redirect()->route('guide.west.index');
});

// Guides routes by kind
foreach (['east','north','west','central','other'] as $kind) {
    Route::get("/guide/$kind", [UserGuideController::class, 'index'])->name("guide.$kind.index")->defaults('kind', $kind);
    Route::middleware('auth')->group(function () use ($kind) {
        Route::get("/guide/$kind/create", [UserGuideController::class, 'create'])->name("guide.$kind.create")->defaults('kind', $kind);
        Route::post("/guide/$kind", [UserGuideController::class, 'store'])->name("guide.$kind.store")->defaults('kind', $kind);
        Route::get("/guide/$kind/{guide}/edit", [UserGuideController::class, 'edit'])->name("guide.$kind.edit")->defaults('kind', $kind);
        Route::put("/guide/$kind/{guide}", [UserGuideController::class, 'update'])->name("guide.$kind.update")->defaults('kind', $kind);
        Route::delete("/guide/$kind/{guide}", [UserGuideController::class, 'destroy'])->name("guide.$kind.destroy")->defaults('kind', $kind);
    });
    Route::get("/guide/$kind/{guide}", [UserGuideController::class, 'show'])->name("guide.$kind.show")->defaults('kind', $kind);
}

// Social: comments and likes
Route::middleware('auth')->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/likes/toggle', [LikeController::class, 'toggle'])->name('likes.toggle');
    // Account
    Route::get('/account', [\App\Http\Controllers\Account\AccountController::class, 'index'])->name('account.index');
    Route::post('/account/profile', [\App\Http\Controllers\Account\AccountController::class, 'updateProfile'])->name('account.profile');
    Route::post('/account/avatar', [\App\Http\Controllers\Account\AccountController::class, 'updateAvatar'])->name('account.avatar');
    Route::post('/account/password', [\App\Http\Controllers\Account\AccountController::class, 'updatePassword'])->name('account.password');
    Route::post('/account/notifications/{id}/read', [\App\Http\Controllers\Account\AccountController::class, 'markNotificationRead'])->name('account.notifications.read');
});

Route::get('/admin', function () {
    return view('admin.main.index');
});

// Admin area protected by auth + role:admin or moderator
Route::middleware(['auth','role:admin,moderator'])->group(function () {
    // users
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.delete');

    // link
    Route::get('/admin/link', [AdminContactController::class, 'index'])->name('admin.link.index');
    Route::post('/admin/link', [AdminContactController::class, 'store'])->name('admin.link.store');

    // info
    Route::get('/admin/clan/info', [AdminInfoController::class, 'index'])->name('admin.clan.info.index');
    Route::get('/admin/clan/info/create', [AdminInfoController::class, 'create'])->name('admin.clan.info.create');
    Route::post('/admin/clan/info/store', [AdminInfoController::class, 'store'])->name('admin.clan.info.store');

    // Coslist
    Route::get('/admin/clan/coslist', [AdminCoslistController::class, 'index'])->name('admin.clan.coslist.index');
    Route::get('/admin/clan/coslist/create/personal', [AdminCoslistController::class, 'createPersonal'])->name('admin.clan.coslist.create.personal');
    Route::get('/admin/clan/coslist/create/guild', [AdminCoslistController::class, 'createGuild'])->name('admin.clan.coslist.create.guild');
    Route::post('/admin/clan/coslist/store/personal', [AdminCoslistController::class, 'storePersonal'])->name('admin.clan.coslist.store.personal');
    Route::post('/admin/clan/coslist/store/guild', [AdminCoslistController::class, 'storeGuild'])->name('admin.clan.coslist.store.guild');
    Route::delete('/admin/clan/coslist/{coslist}', [AdminCoslistController::class, 'delete'])->name('admin.clan.coslist.delete');

    // regulation
    Route::get('/admin/clan/regulation', [AdminRegulationController::class, 'index'])->name('admin.clan.regulation.index');
    Route::get('/admin/clan/regulation/create', [AdminRegulationController::class, 'create'])->name('admin.clan.regulation.create');
    Route::post('/admin/clan/regulation/store', [AdminRegulationController::class, 'store'])->name('admin.clan.regulation.store');

    // application
    Route::get('/admin/clan/application', [AdminApplicationController::class, 'index'])->name('admin.clan.application.index');
    Route::get('/admin/clan/application/{application}', [AdminApplicationController::class, 'show'])->name('admin.clan.application.show');
    Route::post('/admin/clan/application/{application}/status', [AdminApplicationController::class, 'update'])->name('admin.clan.application.status.update');
    Route::delete('/admin/clan/application/{application}', [AdminApplicationController::class, 'delete'])->name('admin.clan.application.delete');

    // forum sections
    Route::get('/admin/forum/sections', [AdminForumSectionController::class, 'index'])->name('admin.forum.sections.index');
    Route::get('/admin/forum/sections/create', [AdminForumSectionController::class, 'create'])->name('admin.forum.sections.create');
    Route::post('/admin/forum/sections', [AdminForumSectionController::class, 'store'])->name('admin.forum.sections.store');
    Route::get('/admin/forum/sections/{section}/edit', [AdminForumSectionController::class, 'edit'])->name('admin.forum.sections.edit');
    Route::put('/admin/forum/sections/{section}', [AdminForumSectionController::class, 'update'])->name('admin.forum.sections.update');
    Route::delete('/admin/forum/sections/{section}', [AdminForumSectionController::class, 'destroy'])->name('admin.forum.sections.destroy');

    // forum subsections
    Route::get('/admin/forum/sections/{section}/subsections/create', [AdminForumSubsectionController::class, 'create'])->name('admin.forum.subsections.create');
    Route::post('/admin/forum/sections/{section}/subsections', [AdminForumSubsectionController::class, 'store'])->name('admin.forum.subsections.store');
    Route::get('/admin/forum/sections/{section}/subsections/{subsection}/edit', [AdminForumSubsectionController::class, 'edit'])->name('admin.forum.subsections.edit');
    Route::put('/admin/forum/sections/{section}/subsections/{subsection}', [AdminForumSubsectionController::class, 'update'])->name('admin.forum.subsections.update');
    Route::delete('/admin/forum/sections/{section}/subsections/{subsection}', [AdminForumSubsectionController::class, 'destroy'])->name('admin.forum.subsections.destroy');
});

// Media proxy for public disk (avoids symlink issues on some environments)
Route::get('/media/{path}', function (string $path) {
    $absolute = storage_path('app/public/'.$path);
    if (!is_file($absolute)) {
        abort(404);
    }
    $mime = \Symfony\Component\Mime\MimeTypes::getDefault()->guessMimeType($absolute) ?? 'application/octet-stream';
    return response()->file($absolute, ['Content-Type' => $mime]);
})->where('path', '.*')->name('media');

