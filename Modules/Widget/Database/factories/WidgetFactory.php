<?php

use Faker\Generator as Faker;
use Modules\User\Models\Users;

$factory->define(Modules\Widget\Models\Widget::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'type' => $faker->state,
        'testimonial_source' => $faker->randomElement($array = array ('Google Places', 'Yelp', 'Tripadvisor')),
        'testimonial_min_stars' => $faker->numberBetween(1,5),
        'featured_testimonial' => $faker->numberBetween(0,1),
        'prevent_testimonial' => $faker->numberBetween(0,1),
        'randomize_testimonial' => $faker->numberBetween(0,1),
        'show_testimonial_source' => $faker->numberBetween(0,1),
        'show_endorsal_branding' => $faker->numberBetween(0,1),
        'show_recency' => $faker->numberBetween(0,1),
        'grid_columns' => $faker->numberBetween(1,5),
        'grid_rows' => $faker->numberBetween(1,5),
        'grid_fixed_height' => $faker->numberBetween(0,1),
        'carousel_max_testimonials' => $faker->numberBetween(1,10),
        'carousel_adaptive_height' => $faker->numberBetween(0,1),
        'carousel_show_controls' => $faker->numberBetween(0,1),
        'carousel_show_pagination' => $faker->numberBetween(0,1),
        'carousel_autoplay' => $faker->numberBetween(0,1),
        'carousel_slide_delay' => $faker->numberBetween(1,5),
        'theme_type' => $faker->randomElement($array = array ('Slider','Multi Slider','List', 'Grid', 'Single Quote', 'Badge')),
        'theme_card_layout' => $faker->numberBetween(0,1),
        'font_style' => $faker->randomElement($array = array ('Times New Roman", Times, serif','Arial, Helvetica, sans-serif')),
        'background_color' => $faker->hexcolor,
        'primary_text_color' => $faker->hexcolor,
        'secondary_text_color' => $faker->hexcolor,
        'quote_color' => $faker->hexcolor,
        'stars_color' => $faker->hexcolor,
        'author_color' => $faker->hexcolor,
        'date_color' => $faker->hexcolor,
        'embed_code' => $faker->randomHtml(2,3),
        'number_of_reviews' => $faker->numberBetween(1,10),
        'sort_review_by' => $faker->randomElement($array = array ('Date', 'Rating')),
        'schema_markup' => $faker->numberBetween(0,1),
        'user_id' => Users::all()->random()->id
    ];
});
