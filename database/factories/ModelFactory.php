<?php

$factory->define(App\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->md5,
    ];
});

$factory->define(App\SubRole::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->md5,
    ];
});

$factory->define(App\Hero::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->paragraph,
        'role_id' => factory(App\Role::class)->create()->id,
        'health' => $faker->numberBetween(100, 500),
        'armour' => $faker->numberBetween(0, 400),
        'shield' => $faker->numberBetween(0, 200),
        'real_name' => $faker->name,
        'age' => $faker->numberBetween(20, 90),
        'height' => $faker->numberBetween(170, 220),
        'affiliation' => $faker->company,
        'base_of_operations' => $faker->country,
        'difficulty' => $faker->numberBetween(1, 3),
    ];
});

$factory->define(App\Ability::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->md5,
        'description' => $faker->paragraph,
        'hero_id' => factory(App\Hero::class)->create()->id,
        'is_ultimate' => $faker->numberBetween(0, 1),
    ];
});

$factory->define(App\RewardType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->md5,
    ];
});

$factory->define(App\Currency::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->md5,
    ];
});

$factory->define(App\Quality::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->md5,
    ];
});

$factory->define(App\Reward::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->md5,
        'reward_type_id' => factory(App\RewardType::class)->create()->id,
        'hero_id' => null,
        'cost' => 25,
        'currency_id' => factory(App\Currency::class)->create()->id,
        'quality_id' => factory(App\Quality::class)->create()->id,
        'event_id' => null,
    ];
});

$factory->define(App\Achievement::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'hero_id' => null,
        'reward_id' => factory(App\Reward::class)->create()->id,
    ];
});

$factory->define(App\Event::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->md5,
        'start_date' => $faker->date('Y-m-d'),
        'end_date' => $faker->date('Y-m-d'),
    ];
});

$factory->define(App\MapMode::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->md5,
    ];
});

$factory->define(App\Map::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->md5,
        'location' => $faker->country,
        'map_mode_id' => factory(App\MapMode::class)->create()->id,
        'event_id' => null,
    ];
});

$factory->define(App\MapStage::class, function (Faker\Generator $faker) {
    return [
        'map_id' => factory(App\Map::class)->create()->id,
        'name' => $faker->md5,
    ];
});

$factory->define(App\Platform::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->md5,
    ];
});

$factory->define(App\GameMode::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->md5,
    ];
});
