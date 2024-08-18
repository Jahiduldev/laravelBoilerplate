<?php

use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', [UserTypeEnum::ADMIN->value, UserTypeEnum::VENDOR->value, UserTypeEnum::CUSTOMER->value])->default(UserTypeEnum::CUSTOMER->value)->change();

            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->enum('status', [UserStatusEnum::ACTIVE->value, UserStatusEnum::INACTIVE->value])->default(UserStatusEnum::ACTIVE->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type')->default('customer')->change();
            $table->dropColumn(['photo', 'phone', 'address', 'status']);
        });
    }
};
