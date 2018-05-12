<?php
namespace Tests\Feature;


use Illuminate\Support\Facades\Session;

trait TagPage {
    public function createTag () {

        $response = $this->post('/tag', [
            'name'=> 'tag 1',
            '_token' => Session::token()
        ]);

        $response->assertStatus(302);
    }

    /**
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function detaiTags(): \Illuminate\Foundation\Testing\TestResponse
    {
        $response = $this->get('/tag/1');
        $response->assertStatus(200);
        $response->assertSee('tag 1');
        return $response;
    }
}