<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGithubOauthChangeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('github_token_added_at')->nullable()->after('github_token');
            $table->timestamp('github_token_changed_at')->nullable()->after('github_token_added_at');
            $table->timestamp('github_token_deleted_at')->nullable()->after('github_token_changed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('github_token_added_at');
            $table->dropColumn('github_token_changed_at');
            $table->dropColumn('github_token_deleted_at');
        });
    }
}
