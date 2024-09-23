<?php

use App\Models\User;
use AyatKyo\Klorovel\Core\Facades\Setting;
use Database\Seeders\DefaultUserSeeder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

test('can display homepage', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('can display user detail', function () {
    /** @var \Illuminate\Foundation\Testing\TestCase $this */

    $this->seed();

    $response = loginAs('supermin')
        ->followingRedirects()
        ->get('/admin');

    $response->assertSee("Admin Page");
});


test('can store site settings', function () {
    /** @var \Illuminate\Foundation\Testing\TestCase $this */
    //  PREP
    Storage::fake('setting');

    $supermin = User::factory()->create([
        'role' => 'supermin'
    ]);

    $data = (object) [
        'profil' => 'ini profile singkat ganti',
        'telepon' => '087814115828',
        'kontak_list' => '[{"id":1679927065677,"name":"Email 2","value":"ayat.kyo@gmail.com","type":"email"}]'
    ];

    $this->mock(Filesystem::class)
        ->shouldReceive('put')
        ->once();
    
    //  ACT
    $response = $this->actingAs($supermin)->put('admin/pengaturan-situs/informasi', [
        'profil'      => $data->profil,
        'telepon'     => $data->telepon,
        'kontak_list' => $data->kontak_list,
    ]);

    //  ASSERT
    $response->assertOk();

    expect(Setting::loadOrCreateFromDb('web'))
        ->profil->toBe($data->profil)
        ->telepon->toBe($data->telepon)
        ->kontak_list->toBe($data->kontak_list);
});
