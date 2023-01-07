<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('type')->nullable();
            // Testimonial
            $table->string('testimonial_source')->nullable();
            $table->unsignedTinyInteger('testimonial_min_stars')->nullable();
            $table->boolean('featured_testimonial')->nullable();
            $table->boolean('prevent_testimonial')->nullable();
            $table->boolean('randomize_testimonial')->nullable();
            $table->boolean('show_testimonial_source')->nullable();
            $table->boolean('show_endorsal_branding')->nullable();
            $table->boolean('show_recency')->nullable();
            // Grid settings
            $table->unsignedTinyInteger('grid_columns')->nullable();
            $table->unsignedTinyInteger('grid_rows')->nullable();
            $table->boolean('grid_fixed_height')->nullable();
            // Carousel settings
            $table->unsignedTinyInteger('carousel_max_testimonials')->nullable();
            $table->boolean('carousel_adaptive_height')->nullable();
            $table->boolean('carousel_show_controls')->nullable();
            $table->boolean('carousel_show_pagination')->nullable();
            $table->boolean('carousel_autoplay')->nullable();
            $table->unsignedDecimal('carousel_slide_delay', 8, 2)->nullable();
            // 4. Set up theme:
            $table->string('theme_type')->nullable();
            $table->boolean('theme_card_layout')->nullable();
            $table->string('font_style')->nullable();
            // colors
            $table->string('background_color')->nullable();
            $table->string('primary_text_color')->nullable();
            $table->string('secondary_text_color')->nullable();
            $table->string('quote_color')->nullable();
            $table->string('stars_color')->nullable();
            $table->string('author_color')->nullable();
            $table->string('date_color')->nullable();
            // embed_code
            $table->text('embed_code')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('widgets');
    }
}
