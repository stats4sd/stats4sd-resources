<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Login;
use ChrisReedIO\Socialment\SocialmentPlugin;
use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use App\Filament\Resources\TagResource;
use Filament\Navigation\NavigationGroup;
use App\Filament\Resources\TroveResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use App\Filament\Resources\TagTypeResource;
use App\Filament\Resources\TroveTypeResource;
use Filament\SpatieLaravelTranslatablePlugin;
use App\Filament\Resources\CollectionResource;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Kainiklas\FilamentScout\FilamentScoutPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('')
            ->login(Login::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder
                    ->items([

                        ...TroveResource::getNavigationItems(),
                        ...CollectionResource::getNavigationItems(),
                    ])
                    ->groups([
                        NavigationGroup::make('Details')
                            ->items([
                                ...TroveTypeResource::getNavigationItems(),
                                ...TagTypeResource::getNavigationItems(),
                                ...TagResource::getNavigationItems(),
                            ]),
                    ]);
            })
            ->plugins([
                SocialmentPlugin::make()
                    ->registerProvider('azure', 'fab-microsoft', 'Stats4SD Staff (via Azure)'),
                SpatieLaravelTranslatablePlugin::make()
                    ->defaultLocales(['en', 'es', 'fr']),
            ]);
    }
}
