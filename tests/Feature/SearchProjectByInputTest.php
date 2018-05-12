<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Tag;
use Illuminate\Support\Facades\Session;

class SearchProjectByInputTest extends TestCase
{
    use ProjectPage;

    public function checkUserAndCreateProject () {
        $user = $this->authorization();
        $this->createProject();
    }

    public function testScreenSearchProject () {
        $this->checkUserAndCreateProject();
        $this->get('/projects')
            ->assertSee('Start from')
            ->assertSee('Start to')
            ->assertSee('Finish from')
            ->assertSee('Finish to')
            ->assertSee('Search')
            ->assertSee('Cancel')
            ->assertSee('project 1');
    }

    public function testScreenSearchProjectByName () {
        $this->checkUserAndCreateProject();
        $response = $this->get('/projects', [   // get() => khong can redirect()
            'nameProject' => '',
            '_token' => Session::token()
        ]);
        $response->assertStatus(200);
        $this->get('/projects?start_at_begin=&start_at_end=&finish_from=&finish_to=&nameProject=ect')
            ->assertSee('project 1');
    }

    public function testScreenSearchProjectByStartFromAndStartTo () {
        $this->checkUserAndCreateProject();
        $response = $this->get('/projects', [   // get() => khong can redirect()
            'start_from' => '2018/04/01',
            'start_to' => '2018/04/02',
            '_token' => Session::token()
        ]);
        $response->assertStatus(200);
        $this->get('/projects?start_at_begin=2018/04/01&start_at_end=2018/04/02&finish_from=&finish_to=&nameProject=')
            ->assertSee('project 1');
    }

}