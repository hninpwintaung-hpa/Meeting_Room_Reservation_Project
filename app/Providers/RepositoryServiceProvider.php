<?php

namespace App\Providers;

use App\Repository\Car\CarRepoInterface;
use App\Repository\Car\CarRepository;
use App\Repository\Reservation\ReservationRepoInterface;
use App\Repository\Reservation\ReservationRepository;
use App\Repository\Room\RoomRepoInterface;
use App\Repository\Room\RoomRepository;
use App\Repository\Team\TeamRepoInterface;
use App\Repository\Team\TeamRepository;
use App\Service\Car\CarService;
use App\Service\Car\CarServiceInterface;
use App\Service\Reservation\ReservationService;
use App\Service\Reservation\ReservationServiceInterface;
use App\Service\Room\RoomService;
use App\Service\Room\RoomServiceInterface;
use App\Service\Team\TeamService;
use App\Service\Team\TeamServiceInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(CarRepoInterface::class, CarRepository::class);
        $this->app->bind(CarServiceInterface::class, CarService::class);

        $this->app->bind(RoleRepoInterface::class, RoleRepository::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);

        $this->app->bind(RoomRepoInterface::class, RoomRepository::class);
        $this->app->bind(RoomServiceInterface::class, RoomService::class);

        $this->app->bind(TeamRepoInterface::class, TeamRepository::class);
        $this->app->bind(TeamServiceInterface::class, TeamService::class);

        $this->app->bind(ReservationRepoInterface::class, ReservationRepository::class);
        $this->app->bind(ReservationServiceInterface::class, ReservationService::class);
    }
}
