<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\OrderRepository;
use App\Repositories\CountryRepository;
use App\Repositories\OperatorRepository;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\AirtimeProductRepository;
use App\Repositories\DataRepository;
use App\Repositories\AirtimeRepository;
use App\Repositories\HistoryRepository;
use App\Repositories\LoanHistoryRepository;
use App\Repositories\PaystackRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\WalletRepository;
use App\Repositories\FaqRepository;
use App\Repositories\SupportRepository;
use App\Repositories\ActivityRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use App\Repositories\KycRepository;
use App\Repositories\AdminRepository;
use App\Repositories\SmsDebtorRepository;
use App\Repositories\TermConditionRepository;
use App\Repositories\PaymentGatewayRepository;
use App\Repositories\FundRepository;
use App\Repositories\BulkSmsRepository;




use App\Interfaces\FundRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\CountryRepositoryInterface;
use App\Interfaces\OperatorRepositoryInterface;
use App\Interfaces\ProductCategoryRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\AirtimeProductRepositoryInterface;
use App\Interfaces\DataRepositoryInterface;
use App\Interfaces\AirtimeRepositoryInterface;
use App\Interfaces\HistoryRepositoryInterface;
use App\Interfaces\LoanHistoryRepositoryInterface;
use App\Interfaces\PaystackRepositoryInterface;
use App\Interfaces\PaymentRepositoryInterface;
use App\Interfaces\WalletRepositoryInterface;
use App\Interfaces\FaqRepositoryInterface;
use App\Interfaces\SupportRepositoryInterface;
use App\Interfaces\ActivityRepositoryInterface;
use App\Interfaces\NotificationRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\KycRepositoryInterface;
use App\Interfaces\BulkSmsInterface;
use App\Interfaces\AdminRepositoryInterface;
use App\Interfaces\SmsDebtorRepositoryInterface;
use App\Interfaces\TermConditionRepositoryInterface;
use App\Interfaces\PaymentGatewayRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(OperatorRepositoryInterface::class, OperatorRepository::class);
        $this->app->bind(ProductCategoryRepositoryInterface::class, ProductCategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(AirtimeProductRepositoryInterface::class, AirtimeProductRepository::class);
        $this->app->bind(DataRepositoryInterface::class, DataRepository::class);
        $this->app->bind(AirtimeRepositoryInterface::class, AirtimeRepository::class);
        $this->app->bind(HistoryRepositoryInterface::class, HistoryRepository::class);
        $this->app->bind(LoanHistoryRepositoryInterface::class, LoanHistoryRepository::class);
        $this->app->bind(PaystackRepositoryInterface::class, PaystackRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(WalletRepositoryInterface::class, WalletRepository::class);
        $this->app->bind(FaqRepositoryInterface::class, FaqRepository::class);
        $this->app->bind(SupportRepositoryInterface::class, SupportRepository::class);
        $this->app->bind(ActivityRepositoryInterface::class, ActivityRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(KycRepositoryInterface::class, KycRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(SmsDebtorRepositoryInterface::class, SmsDebtorRepository::class);
        $this->app->bind(TermConditionRepositoryInterface::class, TermConditionRepository::class);
        $this->app->bind(PaymentGatewayRepositoryInterface::class, PaymentGatewayRepository::class);
        $this->app->bind(FundRepositoryInterface::class, FundRepository::class);
        $this->app->bind(BulkSmsInterface::class, BulkSmsRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
