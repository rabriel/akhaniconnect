<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecruitmentJobSeeder extends Seeder
{
    /**
     * Seed practical recruitment jobs for the default recruitment account.
     */
    public function run(): void
    {
        $recruiter = User::query()
            ->where('email', 'recruitment@akhaniconnect.co.za')
            ->first();

        if ($recruiter === null) {
            return;
        }

        DB::table('jobs')->where('user_id', $recruiter->id)->delete();

        $timestamp = now();

        $jobs = [
            [
                'title' => 'Procurement Administrator',
                'location' => 'Johannesburg',
                'province' => 'Gauteng',
                'employment_type' => 'Permanent',
                'description' => $this->description(
                    'A growing supply chain business is looking for a Procurement Administrator to support vendor onboarding, purchase order tracking, and reporting for internal stakeholders.',
                    [
                        'Capture purchase orders and maintain supplier records.',
                        'Follow up on quotations, delivery dates, and outstanding paperwork.',
                        'Prepare weekly procurement status reports for management.',
                    ],
                    [
                        '2+ years of procurement or administration experience.',
                        'Strong Excel and document management skills.',
                        'Comfortable working in a fast-paced operations environment.',
                    ]
                ),
            ],
            [
                'title' => 'Site Quantity Surveyor',
                'location' => 'Gqeberha',
                'province' => 'Eastern Cape',
                'employment_type' => 'Contract',
                'description' => $this->description(
                    'A construction contractor requires a Site Quantity Surveyor to manage project cost tracking, subcontractor measurements, and claims support on active building projects.',
                    [
                        'Measure work completed on site and prepare payment certificates.',
                        'Track variations, material usage, and subcontractor claims.',
                        'Assist with cost reports and final account preparation.',
                    ],
                    [
                        'National Diploma or Degree in Quantity Surveying.',
                        'Experience on building or civil projects.',
                        'Strong attention to detail and site coordination ability.',
                    ]
                ),
            ],
            [
                'title' => 'Warehouse Supervisor',
                'location' => 'Bloemfontein',
                'province' => 'Free State',
                'employment_type' => 'Permanent',
                'description' => $this->description(
                    'An established logistics operator is hiring a Warehouse Supervisor to lead daily warehouse activities, inventory control, and dispatch coordination.',
                    [
                        'Supervise receiving, picking, packing, and dispatch teams.',
                        'Monitor stock movement and investigate inventory variances.',
                        'Ensure warehouse safety and housekeeping standards are maintained.',
                    ],
                    [
                        '3+ years of warehousing or distribution supervision experience.',
                        'Experience with inventory systems and stock reconciliation.',
                        'Strong people management and reporting skills.',
                    ]
                ),
            ],
            [
                'title' => 'HR Officer',
                'location' => 'Durban',
                'province' => 'KwaZulu-Natal',
                'employment_type' => 'Permanent',
                'description' => $this->description(
                    'A regional services company is seeking an HR Officer to support recruitment administration, onboarding, leave management, and employee relations processes.',
                    [
                        'Coordinate interview scheduling, offers, and onboarding packs.',
                        'Maintain leave records and support payroll-related queries.',
                        'Assist with employee relations documentation and policy communication.',
                    ],
                    [
                        'Diploma or Degree in Human Resources or related field.',
                        '2+ years of generalist HR administration experience.',
                        'Good understanding of South African labour practices.',
                    ]
                ),
            ],
            [
                'title' => 'Junior IT Support Technician',
                'location' => 'Polokwane',
                'province' => 'Limpopo',
                'employment_type' => 'Permanent',
                'description' => $this->description(
                    'A technology support business is looking for a Junior IT Support Technician to assist users with hardware, software, and connectivity issues across branch offices.',
                    [
                        'Log and resolve first-line support tickets.',
                        'Set up workstations, printers, and user accounts.',
                        'Escalate unresolved issues and maintain support documentation.',
                    ],
                    [
                        'Relevant IT certificate or diploma.',
                        'Basic troubleshooting knowledge across Windows and networks.',
                        'Good communication and customer service skills.',
                    ]
                ),
            ],
            [
                'title' => 'Operations Coordinator',
                'location' => 'Nelspruit',
                'province' => 'Mpumalanga',
                'employment_type' => 'Permanent',
                'description' => $this->description(
                    'A field services company needs an Operations Coordinator to manage scheduling, customer communication, and performance tracking across multiple teams.',
                    [
                        'Coordinate technician schedules and route planning.',
                        'Maintain service logs and update customers on progress.',
                        'Compile daily and weekly operational performance reports.',
                    ],
                    [
                        'Experience in operations, logistics, or scheduling.',
                        'Excellent organisational and communication skills.',
                        'Strong administrative ability and attention to detail.',
                    ]
                ),
            ],
            [
                'title' => 'Safety Officer',
                'location' => 'Kimberley',
                'province' => 'Northern Cape',
                'employment_type' => 'Contract',
                'description' => $this->description(
                    'A mining support contractor is searching for a Safety Officer to drive site compliance, toolbox talks, inspections, and incident follow-up.',
                    [
                        'Conduct daily site inspections and risk observations.',
                        'Maintain safety files, permits, and compliance registers.',
                        'Support incident investigations and corrective action tracking.',
                    ],
                    [
                        'Relevant safety qualification and registration where required.',
                        'Experience in industrial, mining, or construction environments.',
                        'Strong reporting and stakeholder engagement skills.',
                    ]
                ),
            ],
            [
                'title' => 'Sales Representative',
                'location' => 'Mahikeng',
                'province' => 'North West',
                'employment_type' => 'Permanent',
                'description' => $this->description(
                    'A fast-moving consumer goods distributor is hiring a Sales Representative to grow customer relationships and achieve monthly sales targets in the region.',
                    [
                        'Visit customers, present promotions, and secure orders.',
                        'Maintain route plans and submit accurate sales reports.',
                        'Support merchandising and customer service activities.',
                    ],
                    [
                        'Proven field sales experience.',
                        'Valid driver’s licence and willingness to travel locally.',
                        'Good communication and target-driven mindset.',
                    ]
                ),
            ],
            [
                'title' => 'Financial Accountant',
                'location' => 'Cape Town',
                'province' => 'Western Cape',
                'employment_type' => 'Permanent',
                'description' => $this->description(
                    'A growing finance team requires a Financial Accountant to manage month-end reporting, reconciliations, compliance support, and audit preparation.',
                    [
                        'Prepare journals, reconciliations, and monthly financial reports.',
                        'Support statutory compliance and audit document preparation.',
                        'Analyse variances and provide finance insights to management.',
                    ],
                    [
                        'Completed accounting qualification.',
                        'Experience in month-end reporting and reconciliations.',
                        'Strong Excel skills and attention to accuracy.',
                    ]
                ),
            ],
            [
                'title' => 'Receptionist and Office Administrator',
                'location' => 'Johannesburg',
                'province' => 'Gauteng',
                'employment_type' => 'Permanent',
                'description' => $this->description(
                    'A professional services office is seeking a Receptionist and Office Administrator to manage front-desk operations and day-to-day office support.',
                    [
                        'Welcome visitors and handle incoming calls professionally.',
                        'Manage meeting room bookings, courier requests, and office supplies.',
                        'Support filing, correspondence, and general administration.',
                    ],
                    [
                        'Previous reception or office administration experience.',
                        'Professional communication and presentation skills.',
                        'Good organisational skills and confidence with office systems.',
                    ]
                ),
            ],
            [
                'title' => 'Mechanical Maintenance Fitter',
                'location' => 'Middelburg',
                'province' => 'Mpumalanga',
                'employment_type' => 'Contract',
                'description' => $this->description(
                    'An industrial plant is looking for a Mechanical Maintenance Fitter to assist with preventative maintenance, breakdown support, and shutdown work.',
                    [
                        'Carry out planned maintenance on production equipment.',
                        'Respond to breakdowns and assist with root-cause analysis.',
                        'Complete maintenance documentation and safety checks.',
                    ],
                    [
                        'Trade-tested fitter qualification.',
                        'Experience in plant or heavy industrial maintenance.',
                        'Ability to work shifts or shutdown periods when required.',
                    ]
                ),
            ],
            [
                'title' => 'Customer Service Consultant',
                'location' => 'Pietermaritzburg',
                'province' => 'KwaZulu-Natal',
                'employment_type' => 'Permanent',
                'description' => $this->description(
                    'A customer-focused business is recruiting a Customer Service Consultant to handle inbound queries, resolve issues, and maintain service excellence.',
                    [
                        'Respond to customer queries via phone and email.',
                        'Resolve service issues and escalate complex matters appropriately.',
                        'Maintain accurate customer records and interaction notes.',
                    ],
                    [
                        'Experience in customer service or call centre support.',
                        'Clear written and verbal communication skills.',
                        'Calm problem-solving approach and attention to detail.',
                    ]
                ),
            ],
        ];

        DB::table('jobs')->insert(array_map(
            fn (array $job): array => [
                'user_id' => $recruiter->id,
                'title' => $job['title'],
                'location' => $job['location'],
                'province' => $job['province'],
                'employment_type' => $job['employment_type'],
                'description' => $job['description'],
                'status' => 'published',
                'published_at' => $timestamp,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            $jobs
        ));
    }

    /**
     * Build a formatted HTML job description block.
     */
    protected function description(string $summary, array $responsibilities, array $requirements): string
    {
        $responsibilityItems = implode('', array_map(
            fn (string $item): string => '<li>' . e($item) . '</li>',
            $responsibilities
        ));

        $requirementItems = implode('', array_map(
            fn (string $item): string => '<li>' . e($item) . '</li>',
            $requirements
        ));

        return sprintf(
            '<p>%s</p><h4>Key Responsibilities</h4><ul>%s</ul><h4>Minimum Requirements</h4><ul>%s</ul>',
            e($summary),
            $responsibilityItems,
            $requirementItems
        );
    }
}
