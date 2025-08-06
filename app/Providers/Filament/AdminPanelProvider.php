<?php

namespace App\Providers\Filament;

use Auth;
use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use GuzzleHttp\Client;
use Filament\PanelProvider;
use App\Filament\Widgets\credit;
use Filament\Navigation\MenuItem;
use App\Livewire\ProfileComponent;
use Filament\Support\Colors\Color;
use App\Filament\Pages\EditProfile;
use App\Filament\Widgets\ClientAppList;
use App\Livewire\CustomProfileComponent;
use Filament\Http\Middleware\Authenticate;
use App\Filament\Widgets\UserWelcomeWidget;
use Illuminate\Session\Middleware\StartSession;
use App\Filament\Pages\MyCustomProfileComponent;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('dashboard')
            ->profile()
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn() => auth()->user()->name)
                    ->url(fn(): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle')

            ])
            ->colors([
                'primary' => Color::Indigo,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                UserWelcomeWidget::class,
                credit::class,
                ClientAppList::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
                FilamentEditProfilePlugin::make()
                    ->slug('my-profile')
                    ->setTitle(fn() => auth()->check() ? auth()->user()->name : 'Profil Saya')
                    ->setNavigationLabel('My Profile')
                    ->setNavigationGroup('Group Profile')
                    ->setIcon('heroicon-o-user')
                    ->setSort(10)
                    ->shouldRegisterNavigation(true)
                    ->shouldShowEditProfileForm(
                         auth()->user()?->source && strtolower(auth()->user()->source) === 'manual'
                    )

                    ->shouldShowEmailForm(false)
                    ->shouldShowDeleteAccountForm(false)
                    ->shouldShowSanctumTokens(true)
                    ->shouldShowBrowserSessionsForm(true)
                    ->shouldShowAvatarForm(
                        false,
                        directory: 'avatars',
                        rules: 'mimes:jpeg,png|max:1024'
                    ),

            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
