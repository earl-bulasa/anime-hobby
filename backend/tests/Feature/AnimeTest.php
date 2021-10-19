<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnimeTest extends TestCase
{

    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStore()
    {
        $response = $this->post('/api/anime', [
            'title' => 'Hajime no Ippo',
            'description' => "Makunouchi Ippo has been bullied his entire life. Constantly running errands and being beaten up by his classmates, Ippo has always dreamed of changing himself, but never has the passion to act upon it. One day, in the midst of yet another bullying, Ippo is saved by Takamura Mamoru, who happens to be a boxer. Ippo faints from his injuries and is brought to the Kamogawa boxing gym to recover. As he regains consciousness, he is awed and amazed at his new surroundings in the gym, though lacks confidence to attempt anything. Takamura places a photo of Ippo's classmate on a punching bag and forces him to punch it. It is only then that Ippo feels something stir inside him and eventually asks Takamura to train him in boxing. Thinking that Ippo does not have what it takes, Takamura gives him a task deemed impossible and gives him a one week time limit. With a sudden desire to get stronger, for himself and his hard working mother, Ippo trains relentlessly to accomplish the task within the time limit. Thus Ippo's journey to the top of the boxing world begins.",
            'myanimelist_id' => 263,
            'theme_songs' => [
                [
                    'type' => 'Opening',
                    'title' => 'Test'
                ]
            ]
        ]);
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $response = $this->get('/api/anime/18');
        $response->assertStatus(200);
    }

    public function testDelete()
    {
        $response = $this->delete('/api/anime/34');
        $response->assertStatus(200);
    }
}
