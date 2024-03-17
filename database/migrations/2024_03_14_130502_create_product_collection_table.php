<?php

use App\Models\Collection\Collection;
use App\Models\Product\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_collection', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Collection::class)->constrained()->cascadeOnDelete();
            $table->jsonb('coords');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_collection');
    }
};
