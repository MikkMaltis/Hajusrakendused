<?php

namespace Database\Seeders;

use App\Models\FavoriteMusic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class FavoriteMusicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $music = [
            [
                'title' => 'The Groove',
                'image' => 'https://i1.sndcdn.com/artworks-Haw349us17Rvu9Ih-cHpTrg-t1080x1080.jpg',
                'description' => 'A high-energy psytrance track that combines driving basslines with intricate melodies. Perfect for late-night dance floors.',
                'artist' => 'Rising Dust',
                'genre' => 'Psytrance'
            ],
            [
                'title' => 'American Dream',
                'image' => 'https://i1.sndcdn.com/artworks-A8dIru1YYYPXkHtX-Nak6hg-t500x500.jpg',
                'description' => 'A deep and atmospheric psytrance track that takes listeners on a journey through sound. Features lush synths and hypnotic rhythms.',
                'artist' => 'Ace Ventura, Volcano',
                'genre' => 'Psytrance'
            ],
            [
                'title' => 'Truffle Shuffle',
                'image' => 'https://i1.sndcdn.com/artworks-000235576963-vltbvo-t1080x1080.jpg',
                'description' => 'Very technical sounding psytrance track. Features catchy hooks and groovy basslines.',
                'artist' => 'Burn in Noise',
                'genre' => 'Psytrance'
            ],
            [
                'title' => 'Juice',
                'image' => 'https://i.scdn.co/image/ab67616d0000b273b5dde7be58cbf5b62292b35d',
                'description' => 'A high-energy psychedelic journey packed with groovy basslines and intricate synth work. "Juice" is a quintessential GMS track that captures their signature sound.',
                'artist' => 'GMS',
                'genre' => 'Psytrance'
            ],
            [
                'title' => 'Salvia Divinorum',
                'image' => 'https://cdn-images.dzcdn.net/images/cover/a1053e9c893f721a8d6d3f6b0ff3b3ff/1900x1900-000000-80-0-0.jpg',
                'description' => 'Inspired by the potent psychedelic plant, this track is a sonic exploration of altered states of consciousness. Expect intense rhythms, complex layers, and a hypnotic progression that pulls you deeper with every beat.',
                'artist' => '1200 Micrograms',
                'genre' => 'Psytrance'
            ],
            [
                'title' => 'Quasar',
                'image' => 'https://f4.bcbits.com/img/a1685439143_10.jpg',
                'description' => 'A cosmic voyage through sound, "Quasar" channels interstellar energy into a powerful trance experience. Electric Universe blends melodic leads and pulsating rhythms to create a track that is both uplifting and mind-expanding.',
                'artist' => 'Electric Universe',
                'genre' => 'Psytrance'
            ],
            [
                'title' => 'Bad Luck Buffet',
                'image' => 'https://i1.sndcdn.com/artworks-000098276368-iblrgd-t240x240.jpg',
                'description' => 'A deep, driving psytrance experience with a dark twist. "Bad Luck Buffet" combines hypnotic rhythms, eerie atmospheres, and powerful drops that reflect Vertical Mode’s signature progressive style. A must-listen for fans of edgy, mind-bending trance.',
                'artist' => 'Vertical Mode',
                'genre' => 'Psytrance'
            ]
        ];

        foreach ($music as $item) {
            FavoriteMusic::create($item);
        }
    }

    public function proxyExternalApi()
    {
        try {
            $response = Http::get('https://hajusrakendus.tak22jasin.itmajakas.ee/api/subjects');

            if ($response->successful()) {
                return $response->json();
            }

            return response()->json(['error' => 'Failed to fetch data'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
