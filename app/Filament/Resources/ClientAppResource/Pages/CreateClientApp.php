<?php

namespace App\Filament\Resources\ClientAppResource\Pages;

use Illuminate\Support\Str;
use App\Models\ClientSecret;
use Laravel\Passport\Client;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ClientAppResource;

class CreateClientApp extends CreateRecord
{
    protected static string $resource = ClientAppResource::class;

    public string $plainSecret; // ← Untuk disimpan sementara ke instance

    protected function handleRecordCreation(array $data): Client
    {
        $this->plainSecret = Str::random(40);

        $client = Client::forceCreate([
            'name' => $data['name'],
            'secret' => bcrypt($this->plainSecret), // tetap hash untuk Passport
            'redirect_uris' => $data['redirect_uris'],
            'grant_types' => $data['grant_types'] ?? ['authorization_code', 'refresh_token'],
            'provider' => null,
            'revoked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Simpan secret plaintext ke table tambahan
        ClientSecret::create([
            'client_id' => $client->id,
            'secret' => $this->plainSecret,
        ]);

        session()->flash('new_client_secret', $this->plainSecret);

        return $client;
    }

    protected function afterCreate(): void
    {
        // simpan ke session agar bisa ditampilkan di modal/redirect/ENV
        session()->flash('new_client_secret', $this->plainSecret);
    }
}
