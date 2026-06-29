<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('sunday')->default(false);
            $table->boolean('monday')->default(false);
            $table->boolean('tuesday')->default(false);
            $table->boolean('wednesday')->default(false);
            $table->boolean('thursday')->default(false);
            $table->boolean('friday')->default(false);
            $table->boolean('saturday')->default(false);
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();
            $table->boolean('is_site_specific')->default(false);
            $table->boolean('is_night_shift')->default(false);
            $table->timestamps();
        });

        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_chat_enabled')->default(true);
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();
            $table->timestamps();
        });

        Schema::create('persistences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('code');
            $table->timestamps();

            $table->unique('code');
        });

        Schema::create('throttle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('type');
            $table->string('ip')->nullable();
            $table->timestamps();

            $table->index('user_id');
        });

        Schema::create('ip_address_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('status', ['active', 'inactive']);
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();
            $table->timestamps();
        });

        Schema::create('geofence_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('status', ['active', 'inactive']);
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();
            $table->timestamps();
        });

        Schema::create('dynamic_qr_devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('unique_id')->unique();
            $table->string('pin')->nullable();
            $table->string('qr_code_value')->nullable();
            $table->string('token')->nullable();
            $table->dateTime('qr_last_updated_at')->nullable();
            $table->integer('qr_update_interval')->nullable();
            $table->dateTime('qr_expire_at')->nullable();
            $table->enum('status', ['new', 'inuse', 'deactivated'])->default('new');
            $table->enum('device_type', ['android', 'ios', 'web', 'windows', 'mac', 'linux', 'other'])->default('web');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();
            $table->timestamps();
        });

        Schema::create('qr_code_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();
            $table->timestamps();
        });

        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('contact_person_name')->nullable();
            $table->decimal('radius', 11, 8)->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('remarks')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();
            $table->timestamps();
        });

        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->integer('radius')->default(100);
            $table->string('address')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_attendance_enabled')->default(false);
            $table->enum('attendance_type', ['none', 'geofence', 'ip_address', 'static_qr_code', 'dynamic_qr_code', 'site'])->default('none');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->unsignedBigInteger('shift_id')->nullable();
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');

            $table->unsignedBigInteger('dynamic_qr_device_id')->nullable();
            $table->foreign('dynamic_qr_device_id')->references('id')->on('dynamic_qr_devices')->onDelete('cascade');

            $table->unsignedBigInteger('geofence_group_id')->nullable();
            $table->foreign('geofence_group_id')->references('id')->on('geofence_groups')->onDelete('cascade');

            $table->unsignedBigInteger('ip_address_group_id')->nullable();
            $table->foreign('ip_address_group_id')->references('id')->on('ip_address_groups')->onDelete('cascade');

            $table->unsignedBigInteger('qr_code_group_id')->nullable();
            $table->foreign('qr_code_group_id')->references('id')->on('qr_code_groups')->onDelete('cascade');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('user_name')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->string('designation')->nullable();
            $table->string('phone_number')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            // 0 = super admin // 1 = admin // 2 = employee // 3 = manager // 4 = supervisor // 5 = accounts
            // 6 = sales // 7 = intern // 8 = HR
            $table->string('type')->nullable();
            $table->text('permissions')->nullable();
            $table->timestamp('last_login')->nullable();

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('unique_id')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('address')->nullable();
            $table->string('alternate_number')->nullable();
            $table->date('dob')->nullable();
            $table->date('date_of_joining')->nullable();
            $table->decimal('base_salary', 10, 2)->nullable();
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->decimal('overtime_rate', 10, 2)->nullable();
            $table->unsignedBigInteger('created_by_id')->nullable();

            $table->integer('available_leaves')->nullable();
            $table->decimal('primary_sales_target', 10, 2)->nullable();
            $table->decimal('secondary_sales_target', 10, 2)->nullable();

            $table->unsignedBigInteger('shift_id')->nullable();
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');

            $table->unsignedBigInteger('team_id')->nullable();
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');

            $table->enum('status', ['active', 'inactive', 'banned'])->default('active');
            $table->enum('gender', ['male', 'female', 'unknown'])->default('unknown');

            $table->unsignedBigInteger('dynamic_qr_device_id')->nullable();
            $table->foreign('dynamic_qr_device_id')->references('id')->on('dynamic_qr_devices')->onDelete('cascade');

            $table->unsignedBigInteger('geofence_group_id')->nullable();
            $table->foreign('geofence_group_id')->references('id')->on('geofence_groups')->onDelete('cascade');

            $table->unsignedBigInteger('ip_address_group_id')->nullable();
            $table->foreign('ip_address_group_id')->references('id')->on('ip_address_groups')->onDelete('cascade');

            $table->unsignedBigInteger('qr_code_group_id')->nullable();
            $table->foreign('qr_code_group_id')->references('id')->on('qr_code_groups')->onDelete('cascade');

            $table->unsignedBigInteger('site_id')->nullable();
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');

            $table->enum('attendance_type', ['none', 'geofence', 'ip_address', 'static_qr_code', 'dynamic_qr_code', 'site'])->default('none');
            $table->enum('salary_type', ['hourly', 'monthly', 'commission', 'contract'])->default('monthly');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('shifts');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('ip_address_groups');
        Schema::dropIfExists('geofence_groups');
        Schema::dropIfExists('dynamic_qr_devices');
        Schema::dropIfExists('qr_code_groups');
        Schema::dropIfExists('sites');
        Schema::dropIfExists('clients');
    }
};
