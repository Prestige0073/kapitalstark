<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\SimulatorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LandingPageController;

/* ── Langue ──────────────────────────────────────────────── */
Route::get('/langue/{locale}', function (string $locale) {
    $supported = ['fr', 'en', 'de', 'es', 'pt'];
    if (in_array($locale, $supported, true)) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale.switch');

/* ── Accueil ─────────────────────────────────────────────── */
Route::get('/', [HomeController::class, 'index'])->name('home');

/* ── Prêts ───────────────────────────────────────────────── */
Route::get('/prets', [LoanController::class, 'index'])->name('loans.index');
Route::prefix('prets')->name('loans.')->group(function () {
    Route::get('/immobilier', [LoanController::class, 'show'])
        ->defaults('type', 'immobilier')->name('immobilier');
    Route::get('/automobile', [LoanController::class, 'show'])
        ->defaults('type', 'automobile')->name('automobile');
    Route::get('/personnel', [LoanController::class, 'show'])
        ->defaults('type', 'personnel')->name('personnel');
    Route::get('/entreprise', [LoanController::class, 'show'])
        ->defaults('type', 'entreprise')->name('entreprise');
    Route::get('/agricole', [LoanController::class, 'show'])
        ->defaults('type', 'agricole')->name('agricole');
    Route::get('/microcredit', [LoanController::class, 'show'])
        ->defaults('type', 'microcredit')->name('microcredit');
});

/* ── Simulateur ──────────────────────────────────────────── */
Route::prefix('simulateur')->name('simulator.')->group(function () {
    Route::get('/',            [SimulatorController::class, 'index'])->name('index');
    Route::get('/comparateur', [SimulatorController::class, 'compare'])->name('compare');
    Route::get('/capacite',    [SimulatorController::class, 'capacity'])->name('capacity');
});

/* ── Pages institutionnelles ─────────────────────────────── */
Route::get('/a-propos',             [PageController::class, 'about'])->name('about');
Route::get('/a-propos/equipe',      [PageController::class, 'team'])->name('about.team');
Route::get('/a-propos/valeurs',     [PageController::class, 'values'])->name('about.values');
Route::get('/a-propos/agences',     [PageController::class, 'agencies'])->name('about.agencies');
Route::get('/a-propos/carrieres',   [PageController::class, 'careers'])->name('about.careers');
Route::get('/presse',               [PageController::class, 'press'])->name('press');
Route::get('/faq',                  [PageController::class, 'faq'])->name('faq');
Route::get('/glossaire',            [PageController::class, 'glossary'])->name('glossary');
Route::get('/mentions-legales',     [PageController::class, 'legal'])->name('legal');
Route::get('/cgu',                  [PageController::class, 'terms'])->name('terms');
Route::get('/confidentialite',      [PageController::class, 'privacy'])->name('privacy');
Route::get('/cookies',              [PageController::class, 'cookies'])->name('cookies');

/* ── Newsletter ──────────────────────────────────────────── */
Route::post('/newsletter',  [PageController::class, 'storeNewsletter'])->name('newsletter.store')->middleware('throttle:newsletter');

/* ── Contact ─────────────────────────────────────────────── */
Route::get('/contact',      [PageController::class, 'contact'])->name('contact');
Route::post('/contact',     [PageController::class, 'sendContact'])->name('contact.send')->middleware('throttle:contact');
Route::get('/contact/rdv',  [PageController::class, 'appointment'])->name('contact.rdv');
Route::post('/contact/rdv', [PageController::class, 'storeAppointment'])->name('contact.rdv.store')->middleware('throttle:appointment');

/* ── Blog & Guides ───────────────────────────────────────── */
Route::get('/blog',         [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}',  [BlogController::class, 'show'])->name('blog.show');
Route::get('/guides',        [PageController::class, 'guides'])->name('guides');
Route::get('/temoignages',   [PageController::class, 'testimonials'])->name('testimonials');

/* ── SEO ─────────────────────────────────────────────────── */
Route::get('/sitemap.xml', function () {
    $urls = [
        ['loc' => url('/'),                       'priority' => '1.0',  'freq' => 'weekly'],
        ['loc' => url('/prets'),                  'priority' => '0.9',  'freq' => 'weekly'],
        ['loc' => url('/prets/immobilier'),        'priority' => '0.9',  'freq' => 'monthly'],
        ['loc' => url('/prets/automobile'),        'priority' => '0.8',  'freq' => 'monthly'],
        ['loc' => url('/prets/personnel'),         'priority' => '0.8',  'freq' => 'monthly'],
        ['loc' => url('/prets/entreprise'),        'priority' => '0.8',  'freq' => 'monthly'],
        ['loc' => url('/prets/agricole'),          'priority' => '0.7',  'freq' => 'monthly'],
        ['loc' => url('/prets/microcredit'),       'priority' => '0.7',  'freq' => 'monthly'],
        ['loc' => url('/simulateur'),              'priority' => '0.9',  'freq' => 'weekly'],
        ['loc' => url('/simulateur/comparateur'),  'priority' => '0.7',  'freq' => 'monthly'],
        ['loc' => url('/simulateur/capacite'),     'priority' => '0.7',  'freq' => 'monthly'],
        ['loc' => url('/blog'),                                       'priority' => '0.8',  'freq' => 'weekly'],
        ['loc' => url('/blog/pret-immobilier-guide-complet'),         'priority' => '0.7',  'freq' => 'monthly'],
        ['loc' => url('/blog/investissement-locatif-guide'),          'priority' => '0.7',  'freq' => 'monthly'],
        ['loc' => url('/blog/assurance-emprunteur-deleguer'),         'priority' => '0.7',  'freq' => 'monthly'],
        ['loc' => url('/blog/pret-agricole-guide'),                   'priority' => '0.6',  'freq' => 'monthly'],
        ['loc' => url('/blog/meilleur-taux-pret-immobilier-2025'),    'priority' => '0.7',  'freq' => 'monthly'],
        ['loc' => url('/blog/taux-endettement-guide-complet'),        'priority' => '0.7',  'freq' => 'monthly'],
        ['loc' => url('/blog/loa-vs-pret-auto'),                      'priority' => '0.6',  'freq' => 'monthly'],
        ['loc' => url('/blog/microcredit-inclusion-financiere'),      'priority' => '0.6',  'freq' => 'monthly'],
        ['loc' => url('/blog/pret-entreprise-creation'),              'priority' => '0.6',  'freq' => 'monthly'],
        ['loc' => url('/blog/remboursement-anticipe-credit'),         'priority' => '0.6',  'freq' => 'monthly'],
        ['loc' => url('/guides'),                  'priority' => '0.7',  'freq' => 'monthly'],
        ['loc' => url('/faq'),                     'priority' => '0.7',  'freq' => 'monthly'],
        ['loc' => url('/glossaire'),               'priority' => '0.6',  'freq' => 'monthly'],
        ['loc' => url('/a-propos'),                'priority' => '0.6',  'freq' => 'monthly'],
        ['loc' => url('/a-propos/equipe'),         'priority' => '0.5',  'freq' => 'monthly'],
        ['loc' => url('/a-propos/valeurs'),        'priority' => '0.5',  'freq' => 'monthly'],
        ['loc' => url('/a-propos/agences'),        'priority' => '0.6',  'freq' => 'monthly'],
        ['loc' => url('/a-propos/carrieres'),      'priority' => '0.5',  'freq' => 'monthly'],
        ['loc' => url('/contact'),                 'priority' => '0.7',  'freq' => 'monthly'],
        ['loc' => url('/contact/rdv'),             'priority' => '0.6',  'freq' => 'monthly'],
        ['loc' => url('/mentions-legales'),        'priority' => '0.3',  'freq' => 'yearly'],
        ['loc' => url('/cgu'),                     'priority' => '0.3',  'freq' => 'yearly'],
        ['loc' => url('/confidentialite'),         'priority' => '0.3',  'freq' => 'yearly'],
    ];
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($urls as $u) {
        $xml .= "  <url>\n";
        $xml .= "    <loc>" . htmlspecialchars($u['loc']) . "</loc>\n";
        $xml .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
        $xml .= "    <changefreq>" . $u['freq'] . "</changefreq>\n";
        $xml .= "    <priority>" . $u['priority'] . "</priority>\n";
        $xml .= "  </url>\n";
    }
    $xml .= '</urlset>';
    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

/* ── Landing pages Google Ads (/lp/*) ───────────────────── */
Route::prefix('lp')->name('landing.')->group(function () {
    Route::get('/{type}',  [LandingPageController::class, 'show'])->name('show');
    Route::post('/{type}', [LandingPageController::class, 'submit'])->name('submit')->middleware('throttle:10,1');
});

/* ── Chat widget public ──────────────────────────────────── */
Route::post('/chat/message', [ChatController::class, 'store'])->name('chat.store')->middleware('throttle:30,1');
Route::get('/chat/poll',     [ChatController::class, 'poll'])->name('chat.poll');

/* ── Auth ────────────────────────────────────────────────── */
Route::middleware('guest')->group(function () {
    Route::get('/espace-client',                  [AuthController::class, 'showLogin'])->name('client.login');
    Route::post('/espace-client',                 [AuthController::class, 'login'])->name('client.login.post')->middleware('throttle:auth');
    Route::get('/espace-client/register',         [AuthController::class, 'showRegister'])->name('client.register');
    Route::post('/espace-client/register',        [AuthController::class, 'register'])->name('client.register.post');
    Route::get('/espace-client/mot-de-passe',     [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/espace-client/mot-de-passe',    [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/espace-client/reinitialiser/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/espace-client/reinitialiser',   [AuthController::class, 'resetPassword'])->name('password.update');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/* ── Dashboard (protégé) ────────────────────────────────── */
Route::prefix('dashboard')->name('dashboard.')->middleware('is_client')->group(function () {
    Route::get('/',           [DashboardController::class, 'index'])->name('index');
    Route::get('/prets',      [DashboardController::class, 'loans'])->name('loans');
    Route::get('/demandes',   [DashboardController::class, 'requests'])->name('requests');
    Route::get('/documents',           [DashboardController::class, 'documents'])->name('documents');
    Route::post('/documents',          [DashboardController::class, 'uploadDocument'])->name('documents.upload');
    Route::get('/documents/{id}/download', [DashboardController::class, 'downloadDocument'])->name('documents.download');
    Route::get('/profil',      [DashboardController::class, 'profile'])->name('profile');
    Route::put('/profil',      [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::put('/password',    [DashboardController::class, 'updatePassword'])->name('password.update');
    Route::get('/messagerie',              [DashboardController::class, 'messages'])->name('messages');
    Route::post('/messagerie',             [DashboardController::class, 'sendMessage'])->name('messages.send')->middleware('throttle:20,1');
    Route::get('/messagerie/poll',         [DashboardController::class, 'pollMessages'])->name('messages.poll')->middleware('throttle:60,1');
    Route::post('/messagerie/typing',      [DashboardController::class, 'setTyping'])->name('messages.typing')->middleware('throttle:30,1');
    Route::get('/messagerie/typing-status',[DashboardController::class, 'getTypingStatus'])->name('messages.typing.status')->middleware('throttle:60,1');
    Route::get('/notifs/poll',             [DashboardController::class, 'pollNotifications'])->name('notifs.poll');
    Route::post('/push/subscribe',    [DashboardController::class, 'savePushSubscription'])->name('push.subscribe');
    Route::post('/push/unsubscribe',  [DashboardController::class, 'removePushSubscription'])->name('push.unsubscribe');
    Route::get('/messagerie/{id}/attachment', [DashboardController::class, 'downloadAttachment'])->name('messages.attachment');
    Route::get('/demandes/nouvelle',  [DashboardController::class, 'newRequest'])->name('requests.new');
    Route::post('/demandes/nouvelle', [DashboardController::class, 'storeRequest'])->name('requests.store');
    Route::get('/demandes/{id}/contrat',    [DashboardController::class, 'downloadContract'])->name('requests.contract');
    Route::post('/demandes/{id}/documents', [DashboardController::class, 'uploadLoanDocuments'])->name('requests.documents');
    Route::post('/demandes/{id}/confirmer', [DashboardController::class, 'confirmLoanRequest'])->name('requests.confirm');
    Route::get('/calendrier',         [DashboardController::class, 'calendar'])->name('calendar');
    Route::post('/calendrier',        [DashboardController::class, 'storeAppointment'])->name('calendar.store');
    Route::get('/mes-recus',                      [DashboardController::class, 'receipts'])->name('receipts');
    Route::get('/ma-carte',                        [DashboardController::class, 'card'])->name('card');
    Route::post('/ma-carte/toggle',               [DashboardController::class, 'toggleCard'])->name('card.toggle');
    Route::get('/ma-carte/recu/{index}',          [DashboardController::class, 'downloadReceipt'])->name('card.receipt');

    // Virements
    Route::get('/virements',              [TransferController::class, 'index'])->name('transfers.index');
    Route::get('/virements/nouveau',      [TransferController::class, 'create'])->name('transfers.create');
    Route::post('/virements',             [TransferController::class, 'store'])->name('transfers.store');
    Route::get('/virements/{transfer}',        [TransferController::class, 'show'])->name('transfers.show');
    Route::get('/virements/{transfer}/status',    [TransferController::class, 'status'])->name('transfers.status');
    Route::post('/virements/{transfer}/executer',  [TransferController::class, 'execute'])->name('transfers.execute');
    Route::post('/virements/{transfer}/debloquer', [TransferController::class, 'unlock'])->name('transfers.unlock');
    Route::get('/virements/{transfer}/recu',      [TransferController::class, 'downloadReceipt'])->name('transfers.receipt');
});

/* ── Admin login (dédié) ─────────────────────────────────── */
Route::get('/gestion-interne/connexion',  [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/gestion-interne/connexion', [AuthController::class, 'adminLogin'])->name('admin.login.post')->middleware('throttle:auth');
Route::post('/gestion-interne/deconnexion', [AuthController::class, 'adminLogout'])->name('admin.logout');

/* ── Admin (protégé) ────────────────────────────────────── */
Route::prefix('admin')->name('admin.')->middleware(['is_admin'])->group(function () {
    Route::get('/',                             [AdminController::class, 'index'])->name('index');
    // Demandes
    Route::get('/demandes',                          [AdminController::class, 'requests'])->name('requests');
    Route::get('/demandes/{id}',                     [AdminController::class, 'showRequest'])->name('requests.show');
    Route::post('/demandes/{id}/envoyer-contrat',    [AdminController::class, 'sendContract'])->name('requests.contract');
    Route::post('/demandes/{id}/valider-dossier',    [AdminController::class, 'validateDossier'])->name('requests.validate');
    Route::post('/demandes/{id}/approuver',          [AdminController::class, 'approveLoan'])->name('requests.approve');
    Route::post('/demandes/{id}/rejeter',            [AdminController::class, 'rejectRequest'])->name('requests.reject');
    Route::post('/demandes/{id}/statut',             [AdminController::class, 'updateRequestStatus'])->name('requests.status');
    // Prêts
    Route::get('/prets',                        [AdminController::class, 'loans'])->name('loans');
    Route::post('/prets',                       [AdminController::class, 'createLoan'])->name('loans.create');
    Route::post('/prets/{id}',                  [AdminController::class, 'updateLoan'])->name('loans.update');
    // Messagerie
    Route::get('/messagerie',                        [AdminController::class, 'messages'])->name('messages');
    Route::post('/messagerie',                       [AdminController::class, 'sendMessage'])->name('messages.send')->middleware('throttle:30,1');
    Route::post('/messagerie/{id}/lu',               [AdminController::class, 'markMessageRead'])->name('messages.read');
    Route::get('/messagerie/{userId}/poll',          [AdminController::class, 'pollMessages'])->name('messages.poll')->middleware('throttle:120,1');
    Route::get('/messagerie/{id}/attachment',        [AdminController::class, 'downloadAttachment'])->name('messages.download');
    Route::post('/messagerie/{userId}/typing',       [AdminController::class, 'setTyping'])->name('messages.typing')->middleware('throttle:30,1');
    Route::get('/messagerie/{userId}/typing-status', [AdminController::class, 'getTypingStatus'])->name('messages.typing.status')->middleware('throttle:120,1');
    // Rendez-vous
    Route::get('/rendez-vous',                  [AdminController::class, 'appointments'])->name('appointments');
    Route::post('/rendez-vous/{id}',            [AdminController::class, 'updateAppointment'])->name('appointments.update');
    Route::delete('/rendez-vous/{id}',          [AdminController::class, 'deleteAppointment'])->name('appointments.delete');
    // Utilisateurs
    Route::get('/utilisateurs',                 [AdminController::class, 'users'])->name('users');
    Route::get('/utilisateurs/{id}',            [AdminController::class, 'showUser'])->name('users.show');
    Route::delete('/utilisateurs/{id}',         [AdminController::class, 'deleteUser'])->name('users.delete');
    // Suppressions
    Route::delete('/demandes/{id}',             [AdminController::class, 'deleteRequest'])->name('requests.delete');
    Route::delete('/prets/{id}',                [AdminController::class, 'deleteLoan'])->name('loans.delete');
    Route::delete('/messages/{id}',             [AdminController::class, 'deleteMessage'])->name('messages.delete');
    // Contacts publics
    Route::get('/contacts',                     [AdminController::class, 'contacts'])->name('contacts');
    Route::post('/contacts/{id}/traite',        [AdminController::class, 'markContactHandled'])->name('contacts.handled');
    Route::delete('/contacts/{id}',             [AdminController::class, 'deleteContact'])->name('contacts.delete');
    Route::post('/rdv-publics/{id}/traite',     [AdminController::class, 'markRdvHandled'])->name('rdv.handled');
    Route::delete('/rdv-publics/{id}',          [AdminController::class, 'deleteRdvRequest'])->name('rdv.delete');
    // Virements
    Route::get('/virements',                          [AdminController::class, 'transfers'])->name('transfers');
    Route::get('/virements/{transfer}',               [AdminController::class, 'showTransfer'])->name('transfers.show');
    Route::post('/virements/{transfer}/valider',       [AdminController::class, 'validateTransfer'])->name('transfers.validate');
    Route::post('/virements/{transfer}/rejeter',       [AdminController::class, 'rejectTransfer'])->name('transfers.reject');
    Route::post('/virements/{transfer}/envoyer-code',  [AdminController::class, 'sendUnlockCode'])->name('transfers.send-code');
    Route::delete('/virements/{id}',                   [AdminController::class, 'deleteTransfer'])->name('transfers.delete');
    // Bibliothèque de documents
    Route::get('/bibliotheque',                       [AdminController::class, 'templateDocuments'])->name('documents');
    Route::post('/bibliotheque',                      [AdminController::class, 'uploadTemplateDocument'])->name('documents.upload');
    Route::delete('/bibliotheque/{id}',               [AdminController::class, 'deleteTemplateDocument'])->name('documents.delete');
    Route::get('/bibliotheque/{id}/download',         [AdminController::class, 'downloadTemplateDocument'])->name('documents.download');
    Route::get('/bibliotheque/json',                  [AdminController::class, 'templateDocumentsJson'])->name('documents.json');
    // Chat public
    Route::get('/chat',                               [AdminController::class, 'chatSessions'])->name('chat.index');
    Route::get('/chat/{session}',                     [AdminController::class, 'chatShow'])->name('chat.show');
    Route::post('/chat/{session}/reply',              [AdminController::class, 'chatReply'])->name('chat.reply');
    Route::get('/chat/{session}/poll',               [AdminController::class, 'chatPoll'])->name('chat.poll');
    Route::delete('/chat/{session}',                 [AdminController::class, 'deleteChatSession'])->name('chat.delete');
});
