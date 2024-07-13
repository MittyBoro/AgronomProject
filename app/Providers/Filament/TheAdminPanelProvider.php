<?php

namespace App\Providers\Filament;

use App\Filament\Providers\GoogleFontProvider;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\EditUser;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Platform;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Vite;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class TheAdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('theadmin')
            ->path('@theadmin')
            ->login()
            ->font('Nunito', provider: GoogleFontProvider::class)
            ->colors([
                'primary' => Color::Green,
            ])
            ->brandLogo(fn() => view('filament.logo'))
            ->favicon(fn() => Vite::asset('resources/panel/images/favicon.svg'))
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources',
            )
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages',
            )
            ->pages([Pages\Dashboard::class])
            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets',
            )
            ->widgets([Widgets\AccountWidget::class])

            // navigation
            ->navigationItems([
                // ...
                NavigationItem::make('dashboard')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->label(fn(): string => 'Открыть сайт')
                    ->url('/', shouldOpenInNewTab: true)
                    ->sort(33),
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Редактировать')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->url(
                        fn(): string => UserResource::getUrl('edit', [
                            auth()->id(),
                        ]),
                    ),
            ])
            ->sidebarWidth('16rem')
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->globalSearchFieldSuffix(
                fn(): ?string => match (Platform::detect()) {
                    Platform::Windows, Platform::Linux => 'CTRL+K',
                    Platform::Mac => '⌘K',
                    default => null,
                },
            )
            ->renderHook(
                'panels::head.start',
                fn(): string => Vite::useHotFile('hot')
                    ->useBuildDirectory('assets/build')
                    ->withEntryPoints([
                        'resources/panel/js/app.js',
                        'resources/panel/scss/app.scss',
                    ])
                    ->toHtml(),
            )
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
            ->authMiddleware([Authenticate::class]);
    }
}
