<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Project;
use App\Model\ProjectTag;
use App\Model\Tag;
use Illuminate\Support\Facades\Session;

class DeleteProjectTest extends TestCase
{
    use ProjectPage;
    use TagPage;

    public function checkUserAndCreateProjectCreateTagCreateProjectTag () {
        $user = $this->authorization();
        $this->createProject();
        $this->createTag();
        $this->get('projects/1/tags');
        $response = $this->post('projects/add_tags', [
            'project_id' => 1,
            'tags' => [1], // vì name input = tags[]
            '_token' => Session::token()
        ]);
        $response->assertStatus(302);
        return $response;
    }

    public function testScreenDeleteProject () {
        $response = $this->checkUserAndCreateProjectCreateTagCreateProjectTag();
        $response->assertRedirect('/projects/1');
        $response = $this->post('/projects/1/delete', [
            'project_id' => 1,
            '_token' => Session::token()
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/projects');
        $response->assertDontSee('project 1');
    }

}