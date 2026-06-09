<?php

namespace Tests\Feature\Candidate;

use App\Models\Document;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WorkspaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_candidate_user_can_view_candidate_workspace_pages(): void
    {
        $this->seed();

        $user = User::factory()->withRole(2)->create();
        $user->profile()->create(['country' => 'ZA']);
        $user->candidateProfile()->create();
        $user->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $job = Job::query()->create([
            'user_id' => User::factory()->withRole(3)->create()->id,
            'title' => 'Operations Coordinator',
            'location' => 'Cape Town',
            'employment_type' => 'Permanent',
            'description' => 'Support operations, candidate coordination, and recruitment delivery across client accounts.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->actingAs($user)
            ->get(route('candidate.dashboard'))
            ->assertOk()
            ->assertSee('Candidate Dashboard');

        $this->actingAs($user)
            ->get(route('candidate.profile.edit'))
            ->assertOk()
            ->assertSee('Candidate Profile');

        $this->actingAs($user)
            ->get(route('candidate.jobs.index'))
            ->assertOk()
            ->assertSee('Published Jobs');

        $this->actingAs($user)
            ->get(route('candidate.jobs.show', $job))
            ->assertOk()
            ->assertSee('Apply now');

        $this->actingAs($user)
            ->get(route('candidate.applications.index'))
            ->assertOk()
            ->assertSee('My Applications');

        $this->actingAs($user)
            ->get(route('candidate.documents.index'))
            ->assertOk()
            ->assertSee('Candidate Documents')
            ->assertSee('candidate_document_dropzone', false);
    }

    public function test_candidate_user_can_update_candidate_profile(): void
    {
        $this->seed();

        $user = User::factory()->withRole(2)->create([
            'email' => 'candidate@test.local',
            'phone' => '0825552001',
        ]);
        $user->profile()->create(['country' => 'ZA']);
        $user->candidateProfile()->create();
        $user->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $response = $this->actingAs($user)->put(route('candidate.profile.update'), [
            'first_name' => 'Naledi',
            'surname' => 'Candidate',
            'email' => 'candidate@test.local',
            'phone' => '0825552001',
            'city' => 'Johannesburg',
            'province' => 'Gauteng',
            'job_title' => 'Procurement Administrator',
            'experience_level' => 'Mid-level',
            'employment_status' => 'Available immediately',
            'notice_period' => '30 days',
            'willing_to_relocate' => '1',
            'job_industry' => 'Procurement & Supply Chain',
            'preferred_employment_type' => 'Permanent',
            'salary_expectation' => 'R25 000 per month',
            'education_level' => 'Diploma',
            'education' => 'National Diploma in Supply Chain Management',
            'certifications' => 'CIPS Level 4',
            'experience' => 'Five years of procurement and reporting support experience.',
            'skills' => 'SAP, sourcing, reporting, supplier onboarding',
            'bio' => 'Experienced administrator supporting procurement teams, client reporting, and application workflows.',
        ]);

        $response->assertRedirect(route('candidate.profile.edit'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('candidate_profiles', [
            'user_id' => $user->id,
            'job_title' => 'Procurement Administrator',
            'experience_level' => 'Mid-level',
            'notice_period' => '30 days',
            'job_industry' => 'Procurement & Supply Chain',
            'education_level' => 'Diploma',
        ]);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'city' => 'Johannesburg',
            'province' => 'Gauteng',
        ]);
    }

    public function test_candidate_can_upload_profile_documents(): void
    {
        $this->seed();
        Storage::fake('public');

        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create(['country' => 'ZA']);
        $candidate->candidateProfile()->create();
        $candidate->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $response = $this->actingAs($candidate)
            ->postJson(route('candidate.documents.store'), [
                'type' => 'qualification',
                'file' => UploadedFile::fake()->create('qualification.pdf', 300, 'application/pdf'),
            ]);

        $response->assertOk()
            ->assertJson([
                'status' => 'Candidate document uploaded successfully.',
            ]);

        $this->assertDatabaseHas('documents', [
            'user_id' => $candidate->id,
            'category' => 'candidate_profile',
            'type' => 'qualification',
        ]);
    }

    public function test_candidate_can_apply_for_published_job(): void
    {
        $this->seed();
        Storage::fake('public');

        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create(['country' => 'ZA']);
        $candidate->candidateProfile()->create();
        $candidate->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $recruiter = User::factory()->withRole(3)->create();
        $recruiter->profile()->create(['country' => 'ZA']);
        $recruiter->recruitmentProfile()->create(['company_name' => 'Akhani Talent Hub']);

        $job = Job::query()->create([
            'user_id' => $recruiter->id,
            'title' => 'Verification Support Officer',
            'location' => 'Johannesburg',
            'employment_type' => 'Contract',
            'description' => 'Support verification operations, document review, and candidate communication across client projects.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->actingAs($candidate)->post(route('candidate.applications.store', $job), [
            'cover_letter' => 'I am interested in bringing my operational support experience to this role.',
            'cv_document' => UploadedFile::fake()->create('candidate-cv.pdf', 400, 'application/pdf'),
            'supporting_documents' => [
                UploadedFile::fake()->create('certificate.pdf', 250, 'application/pdf'),
            ],
        ]);

        $response->assertRedirect(route('candidate.applications.index'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('applications', [
            'job_id' => $job->id,
            'candidate_user_id' => $candidate->id,
            'status' => 'submitted',
        ]);

        $application = $candidate->applications()->latest()->firstOrFail();

        $this->assertDatabaseHas('documents', [
            'user_id' => $candidate->id,
            'application_id' => $application->id,
            'type' => 'cv',
        ]);

        $this->assertSame(2, Document::query()->where('application_id', $application->id)->count());
        $this->assertCount(2, Storage::disk('public')->allFiles('documents/job_application'));
    }

    public function test_candidate_cannot_apply_twice_for_same_job(): void
    {
        $this->seed();

        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create(['country' => 'ZA']);
        $candidate->candidateProfile()->create();
        $candidate->verificationRecords()->create([
            'module' => 'sa_identity',
            'provider' => 'verifynow',
            'status' => 'verified',
        ]);

        $recruiter = User::factory()->withRole(3)->create();
        $job = Job::query()->create([
            'user_id' => $recruiter->id,
            'title' => 'Document Controller',
            'location' => 'Pretoria',
            'employment_type' => 'Permanent',
            'description' => 'Manage document flow, application records, and administrative coordination for recruiter teams.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $candidate->applications()->create([
            'job_id' => $job->id,
            'status' => 'submitted',
            'applied_at' => now(),
        ]);

        $response = $this->actingAs($candidate)->post(route('candidate.applications.store', $job), [
            'cover_letter' => 'Second attempt',
        ]);

        $response->assertSessionHasErrors('job');
    }

    public function test_recruitment_user_cannot_access_candidate_pages(): void
    {
        $this->seed();

        $recruiter = User::factory()->withRole(3)->create();
        $recruiter->profile()->create(['country' => 'ZA']);
        $recruiter->recruitmentProfile()->create();

        $this->actingAs($recruiter)
            ->get(route('candidate.jobs.index'))
            ->assertForbidden();
    }

    public function test_candidate_dashboard_redirects_to_identity_verification_when_identity_is_not_verified(): void
    {
        $this->seed();

        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create(['country' => 'ZA']);
        $candidate->candidateProfile()->create();

        $this->actingAs($candidate)
            ->get(route('candidate.dashboard'))
            ->assertRedirect(route('candidate.identity-verification.show'));
    }

    public function test_unverified_candidate_cannot_access_candidate_workspace_actions(): void
    {
        $this->seed();

        $candidate = User::factory()->withRole(2)->create([
            'email' => 'candidate-lockout@test.local',
            'phone' => '0825552999',
        ]);
        $candidate->profile()->create(['country' => 'ZA']);
        $candidate->candidateProfile()->create();

        $this->actingAs($candidate)
            ->get(route('candidate.profile.edit'))
            ->assertRedirect(route('candidate.identity-verification.show'));

        $updateResponse = $this->actingAs($candidate)->put(route('candidate.profile.update'), [
            'first_name' => 'Locked',
            'surname' => 'Candidate',
            'email' => 'candidate-lockout@test.local',
            'phone' => '0825552999',
            'city' => 'Johannesburg',
            'province' => 'Gauteng',
        ]);

        $updateResponse->assertRedirect(route('candidate.identity-verification.show'));
        $updateResponse->assertSessionHas('error', 'You need to verify your ID to proceed.');
    }

    public function test_candidate_can_submit_sa_id_verification(): void
    {
        $this->seed();
        Http::fake([
            '*' => Http::response([
                'success' => true,
                'requestId' => 'said-ref-123',
                'reportType' => 'said_verification',
                'mode' => 'sandbox',
                'results' => [
                    'said_verification' => [
                        'transaction_id' => 'txn-1',
                        'realTimeResults' => [
                            'Status' => 'ID Number Valid',
                        ],
                    ],
                ],
            ], 200),
        ]);

        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create(['country' => 'ZA']);
        $candidate->candidateProfile()->create();

        $response = $this->actingAs($candidate)->post(route('candidate.identity-verification.store'), [
            'id_number' => '9106011234087',
        ]);

        $response->assertRedirect(route('candidate.identity-verification.show'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('verification_records', [
            'user_id' => $candidate->id,
            'module' => 'sa_identity',
            'status' => 'verified',
            'provider_reference' => 'said-ref-123',
        ]);

        $this->assertDatabaseHas('profiles', [
            'user_id' => $candidate->id,
            'id_number' => '9106011234087',
            'identity_verified' => 1,
        ]);
    }
}
