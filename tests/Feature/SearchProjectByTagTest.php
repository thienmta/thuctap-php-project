<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Tag;
use Illuminate\Support\Facades\Session;

class SearchProjectByTagTest extends TestCase
{
    use ProjectPage;
    use TagPage;

    public function testUserAuthorizationAndCreateProjectCreateTag () {
        $user = $this->authorization();
        $this->createProject();
        $this->createTag();
    }

    public function testAddTagLinkAppearOnEditProject () {
        $user = $this->authorization();
        $response = $this->get('/projects');
        $response->assertStatus(200);
        $this->createProject();
        $response = $this->detaiProjects();
        $response->assertSee('Add Tags');
    }

    public function testListTagsScreenAppear () {
        $user = $this->authorization();
        $this->createProject();
        $response = $this->get('/projects/1/tags')
                    ->assertStatus(200);
    }

    public function testListTagsScreenItem () {
        $user = $this->authorization();
        $this->createProject();
        $response = $this->get('/projects/1/tags')
                    ->assertSee('Tags List')
                    ->assertSee('Submit')
                    ->assertSee('project 1');
    }

    public function testAddTagsScreen () {
        $user = $this->authorization();
        $response = $this->get('/tag/create');
        $response->assertStatus(200);
    }

    public function testAddTags () {
        $user = $this->authorization();
        $this->createTag();
        $response = $this->detaiTags();
        $tags = Tag::all();
        if( !empty($tags) ) {
            $response->assertSee('tag 1');
        } else {
            $response->assertSee('No tag');
        }
    }

    public function testAddNoTagForProject () {
        $this->testUserAuthorizationAndCreateProjectCreateTag();
        $response = $this->get('projects/1/tags');
        $response = $this->post('projects/add_tags', [
            'project_id' => 1,
            '_token' => Session::token()
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('projects/1/tags');
        $this->get('projects/1/tags')->assertSee('Error, You have to choose tags !');
    }

    public function testAddExitsTagForProject () {
        $this->testUserAuthorizationAndCreateProjectCreateTag();
        $response = $this->get('projects/1/tags');
        $response = $this->post('projects/add_tags', [
            'project_id' => 1,
            'tags' => [1], // vì name input = tags[]
            '_token' => Session::token()
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('projects/1');
        $this->get('projects/1')->assertSee('Add tag successfully');
    }

    public function testShowTagsInScreenDetailProject () {
        $this->testAddExitsTagForProject();
        $response = $this->get('projects/1')
                        ->assertSee('List tags of this project')
                        ->assertSee('tag 1');
    }
}