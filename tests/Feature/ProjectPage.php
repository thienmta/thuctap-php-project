<?php
namespace Tests\Feature;


use Illuminate\Support\Facades\Session;

trait ProjectPage {
    public function createProject () {

        $response = $this->post('/projects', [
            'name'=> 'project 1',
            '_token' => Session::token(),
            'company_id' => '1',
            'start_at' => '2018/04/01',
            'finish_at' => '2018/05/01',
            'completed' => '0',
            'description' => 'sss'
        ]);

        $response->assertStatus(302);
    }

    /**
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function detaiProjects()
    {
        $response = $this->get('/projects/1');
        $response->assertStatus(200);
        $response->assertSee('project 1');
        return $response;
    }
}