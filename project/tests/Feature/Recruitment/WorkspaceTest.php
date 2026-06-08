<?php

namespace Tests\Feature\Recruitment;

use App\Models\Document;
use App\Models\Job;
use App\Models\User;
use App\Notifications\RecruitmentCandidateMessageNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WorkspaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_recruitment_user_can_view_recruitment_workspace_pages(): void
    {
        $this->seed();

        $user = User::factory()->withRole(3)->create();
        $user->profile()->create(['country' => 'ZA']);
        $user->recruitmentProfile()->create();

        $this->actingAs($user)
            ->get(route('recruitment.dashboard'))
            ->assertOk()
            ->assertSee('Recruitment Dashboard');

        $this->actingAs($user)
            ->get(route('recruitment.profile.edit'))
            ->assertOk()
            ->assertSee('Recruitment Company Profile');

        $this->actingAs($user)
            ->get(route('recruitment.jobs.index'))
            ->assertOk()
            ->assertSee('Recruiter Jobs');

        $this->actingAs($user)
            ->get(route('recruitment.jobs.create'))
            ->assertOk()
            ->assertSee('Create Job Post')
            ->assertSee('job_description_editor', false)
            ->assertSee('ckeditor-classic.bundle.js', false);

        $this->actingAs($user)
            ->get(route('recruitment.candidates.index'))
            ->assertOk()
            ->assertSee('Candidate Pipeline');

        $this->actingAs($user)
            ->get(route('recruitment.applications.index'))
            ->assertOk()
            ->assertSee('Applications');
    }

    public function test_recruitment_user_can_update_company_profile(): void
    {
        $this->seed();

        $user = User::factory()->withRole(3)->create([
            'email' => 'recruitment@test.local',
            'phone' => '0825551001',
        ]);
        $user->profile()->create(['country' => 'ZA']);
        $user->recruitmentProfile()->create();

        $response = $this->actingAs($user)->put(route('recruitment.profile.update'), [
            'first_name' => 'Lerato',
            'surname' => 'Recruiter',
            'email' => 'recruitment@test.local',
            'phone' => '0825551001',
            'company_name' => 'Akhani Talent Hub',
            'registration_number' => '201408196207',
            'website' => 'https://akhani.example.test',
            'company_phone' => '0115552233',
            'contact_person_name' => 'Lerato Recruiter',
        ]);

        $response->assertRedirect(route('recruitment.profile.edit'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('recruitment_profiles', [
            'user_id' => $user->id,
            'company_name' => 'Akhani Talent Hub',
            'registration_number' => '201408196207',
        ]);
    }

    public function test_recruitment_user_can_create_job_posts(): void
    {
        $this->seed();

        $user = User::factory()->withRole(3)->create();
        $user->profile()->create(['country' => 'ZA']);
        $user->recruitmentProfile()->create([
            'company_name' => 'Akhani Talent Hub',
        ]);

        $response = $this->actingAs($user)->post(route('recruitment.jobs.store'), [
            'title' => 'Senior Procurement Analyst',
            'location' => 'Johannesburg',
            'province' => 'Gauteng',
            'employment_type' => 'Permanent',
            'description' => 'Lead procurement analysis, stakeholder reporting, and verification workflow support.',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('recruitment.jobs.index'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('jobs', [
            'user_id' => $user->id,
            'title' => 'Senior Procurement Analyst',
            'province' => 'Gauteng',
            'status' => 'published',
        ]);
    }

    public function test_recruitment_user_can_view_candidates_from_job_applications(): void
    {
        $this->seed();

        $recruiter = User::factory()->withRole(3)->create();
        $recruiter->profile()->create(['country' => 'ZA']);
        $recruiter->recruitmentProfile()->create(['company_name' => 'Akhani Talent Hub']);

        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create(['country' => 'ZA', 'province' => 'Gauteng']);
        $candidate->candidateProfile()->create();

        $job = Job::query()->create([
            'user_id' => $recruiter->id,
            'title' => 'Project Administrator',
            'location' => 'Durban',
            'employment_type' => 'Contract',
            'description' => 'Coordinate project administration and candidate documentation across client teams.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $job->applications()->create([
            'candidate_user_id' => $candidate->id,
            'status' => 'submitted',
            'applied_at' => now(),
        ]);

        $this->actingAs($recruiter)
            ->get(route('recruitment.applications.index'))
            ->assertOk()
            ->assertSee($candidate->full_name)
            ->assertSee('Project Administrator');

        $this->actingAs($recruiter)
            ->get(route('recruitment.candidates.index'))
            ->assertOk()
            ->assertSee($candidate->full_name);
    }

    public function test_recruitment_user_can_filter_candidates_by_province(): void
    {
        $this->seed();

        $recruiter = User::factory()->withRole(3)->create();
        $recruiter->profile()->create(['country' => 'ZA']);
        $recruiter->recruitmentProfile()->create(['company_name' => 'Akhani Talent Hub']);

        $gautengCandidate = User::factory()->withRole(2)->create([
            'first_name' => 'Gauteng',
            'surname' => 'Candidate',
        ]);
        $gautengCandidate->profile()->create(['country' => 'ZA', 'province' => 'Gauteng']);
        $gautengCandidate->candidateProfile()->create(['job_title' => 'Coordinator']);

        $westernCapeCandidate = User::factory()->withRole(2)->create([
            'first_name' => 'Western',
            'surname' => 'Candidate',
        ]);
        $westernCapeCandidate->profile()->create(['country' => 'ZA', 'province' => 'Western Cape']);
        $westernCapeCandidate->candidateProfile()->create(['job_title' => 'Administrator']);

        $job = Job::query()->create([
            'user_id' => $recruiter->id,
            'title' => 'Project Administrator',
            'location' => 'Durban',
            'employment_type' => 'Contract',
            'description' => 'Coordinate project administration and candidate documentation across client teams.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $job->applications()->create([
            'candidate_user_id' => $gautengCandidate->id,
            'status' => 'submitted',
            'applied_at' => now(),
        ]);

        $job->applications()->create([
            'candidate_user_id' => $westernCapeCandidate->id,
            'status' => 'submitted',
            'applied_at' => now(),
        ]);

        $this->actingAs($recruiter)
            ->get(route('recruitment.candidates.index', ['province' => 'Gauteng']))
            ->assertOk()
            ->assertSee($gautengCandidate->full_name)
            ->assertDontSee($westernCapeCandidate->full_name)
            ->assertSee('Gauteng');
    }

    public function test_recruitment_user_can_review_an_application(): void
    {
        $this->seed();
        Storage::fake('public');

        $recruiter = User::factory()->withRole(3)->create();
        $recruiter->profile()->create(['country' => 'ZA']);
        $recruiter->recruitmentProfile()->create(['company_name' => 'Akhani Talent Hub']);

        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create(['country' => 'ZA']);
        $candidate->candidateProfile()->create(['job_title' => 'Administrator']);

        $job = Job::query()->create([
            'user_id' => $recruiter->id,
            'title' => 'Office Manager',
            'location' => 'Johannesburg',
            'employment_type' => 'Permanent',
            'description' => 'Lead office operations and candidate coordination.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $application = $job->applications()->create([
            'candidate_user_id' => $candidate->id,
            'status' => 'submitted',
            'applied_at' => now(),
        ]);

        $storedPath = 'documents/job_application/candidate-cv.pdf';
        Storage::disk('public')->put($storedPath, 'cv content');
        Document::query()->create([
            'user_id' => $candidate->id,
            'application_id' => $application->id,
            'category' => 'job_application',
            'type' => 'cv',
            'original_name' => 'candidate-cv.pdf',
            'path' => $storedPath,
            'mime_type' => 'application/pdf',
            'size' => 128,
            'status' => 'uploaded',
            'uploaded_at' => now(),
        ]);
        Storage::disk('public')->put('documents/candidate_profile/qualification.pdf', 'qualification content');
        Document::query()->create([
            'user_id' => $candidate->id,
            'category' => 'candidate_profile',
            'type' => 'qualification',
            'original_name' => 'qualification.pdf',
            'path' => 'documents/candidate_profile/qualification.pdf',
            'mime_type' => 'application/pdf',
            'size' => 128,
            'status' => 'uploaded',
            'uploaded_at' => now(),
        ]);

        $candidate->candidateProfile()->update([
            'notice_period' => '30 days',
            'willing_to_relocate' => true,
            'job_industry' => 'Procurement & Supply Chain',
            'preferred_employment_type' => 'Permanent',
            'salary_expectation' => 'R25 000 per month',
            'education_level' => 'Diploma',
            'education' => 'National Diploma in Logistics',
            'certifications' => 'CIPS Level 4',
            'experience' => 'Five years in procurement administration.',
            'skills' => 'SAP, reporting, sourcing',
        ]);

        $response = $this->actingAs($recruiter)->put(route('recruitment.applications.update', $application), [
            'status' => 'shortlisted',
            'reviewer_notes' => 'Strong profile and relevant experience.',
        ]);

        $response->assertRedirect(route('recruitment.applications.show', $application));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'status' => 'shortlisted',
            'reviewer_notes' => 'Strong profile and relevant experience.',
        ]);

        $this->actingAs($recruiter)
            ->get(route('recruitment.applications.show', $application))
            ->assertOk()
            ->assertSee('candidate-cv.pdf')
            ->assertSee('qualification.pdf')
            ->assertSee('30 days')
            ->assertSee('Procurement & Supply Chain')
            ->assertSee('SAP, reporting, sourcing');
    }

    public function test_recruitment_user_can_notify_candidate_from_application_review(): void
    {
        $this->seed();
        Notification::fake();

        $recruiter = User::factory()->withRole(3)->create([
            'first_name' => 'Lerato',
            'surname' => 'Recruiter',
        ]);
        $recruiter->profile()->create(['country' => 'ZA']);
        $recruiter->recruitmentProfile()->create(['company_name' => 'Akhani Talent Hub']);

        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create(['country' => 'ZA']);
        $candidate->candidateProfile()->create();

        $job = Job::query()->create([
            'user_id' => $recruiter->id,
            'title' => 'Operations Analyst',
            'location' => 'Cape Town',
            'employment_type' => 'Contract',
            'description' => 'Support reporting and applicant coordination.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $application = $job->applications()->create([
            'candidate_user_id' => $candidate->id,
            'status' => 'submitted',
            'applied_at' => now(),
        ]);

        $response = $this->actingAs($recruiter)->post(route('recruitment.applications.notify', $application), [
            'subject' => 'Interview availability',
            'message' => 'Please confirm your availability for an interview this week.',
        ]);

        $response->assertRedirect(route('recruitment.applications.show', $application));
        $response->assertSessionHas('status');

        Notification::assertSentTo($candidate, RecruitmentCandidateMessageNotification::class);
    }

    public function test_recruitment_user_can_download_candidate_application_document(): void
    {
        $this->seed();
        Storage::fake('public');

        $recruiter = User::factory()->withRole(3)->create();
        $recruiter->profile()->create(['country' => 'ZA']);
        $recruiter->recruitmentProfile()->create(['company_name' => 'Akhani Talent Hub']);

        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create(['country' => 'ZA']);
        $candidate->candidateProfile()->create();

        $job = Job::query()->create([
            'user_id' => $recruiter->id,
            'title' => 'Document Review Specialist',
            'location' => 'Johannesburg',
            'employment_type' => 'Permanent',
            'description' => 'Review candidate files and support the recruitment process.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $application = $job->applications()->create([
            'candidate_user_id' => $candidate->id,
            'status' => 'submitted',
            'applied_at' => now(),
        ]);

        $storedPath = 'documents/job_application/candidate-cv.pdf';
        Storage::disk('public')->put($storedPath, 'cv content');
        $document = Document::query()->create([
            'user_id' => $candidate->id,
            'application_id' => $application->id,
            'category' => 'job_application',
            'type' => 'cv',
            'original_name' => 'candidate-cv.pdf',
            'path' => $storedPath,
            'mime_type' => 'application/pdf',
            'size' => 128,
            'status' => 'uploaded',
            'uploaded_at' => now(),
        ]);

        $response = $this->actingAs($recruiter)
            ->get(route('recruitment.applications.documents.show', [$application, $document]));

        $response->assertOk();
        $this->assertStringContainsString(
            'candidate-cv.pdf',
            (string) $response->headers->get('content-disposition')
        );
    }

    public function test_recruitment_user_can_download_candidate_profile_document(): void
    {
        $this->seed();
        Storage::fake('public');

        $recruiter = User::factory()->withRole(3)->create();
        $recruiter->profile()->create(['country' => 'ZA']);
        $recruiter->recruitmentProfile()->create(['company_name' => 'Akhani Talent Hub']);

        $candidate = User::factory()->withRole(2)->create();
        $candidate->profile()->create(['country' => 'ZA']);
        $candidate->candidateProfile()->create();

        $job = Job::query()->create([
            'user_id' => $recruiter->id,
            'title' => 'Candidate Records Specialist',
            'location' => 'Johannesburg',
            'employment_type' => 'Permanent',
            'description' => 'Review candidate records and supporting documents.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $application = $job->applications()->create([
            'candidate_user_id' => $candidate->id,
            'status' => 'submitted',
            'applied_at' => now(),
        ]);

        $storedPath = 'documents/candidate_profile/licence.pdf';
        Storage::disk('public')->put($storedPath, 'licence content');
        $document = Document::query()->create([
            'user_id' => $candidate->id,
            'category' => 'candidate_profile',
            'type' => 'drivers_licence',
            'original_name' => 'licence.pdf',
            'path' => $storedPath,
            'mime_type' => 'application/pdf',
            'size' => 128,
            'status' => 'uploaded',
            'uploaded_at' => now(),
        ]);

        $response = $this->actingAs($recruiter)
            ->get(route('recruitment.applications.candidate-documents.show', [$application, $document]));

        $response->assertOk();
        $this->assertStringContainsString(
            'licence.pdf',
            (string) $response->headers->get('content-disposition')
        );
    }

    public function test_procurement_user_cannot_access_recruitment_pages(): void
    {
        $this->seed();

        $user = User::factory()->withRole(4)->create();
        $user->profile()->create(['country' => 'ZA']);
        $user->procurementProfile()->create();

        $this->actingAs($user)
            ->get(route('recruitment.jobs.index'))
            ->assertForbidden();
    }
}
