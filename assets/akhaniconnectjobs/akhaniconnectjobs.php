<?php
/**
 * Plugin Name: Akhani Connect Jobs
 * Plugin URI: https://lmkdigital.africa/
 * Description: Display Akhani Connect jobs with keyword, province, and job type search using the [akhani-connect-jobs] shortcode.
 * Version: 1.0.0
 * Author: LMK Digital
 * Author URI: https://lmkdigital.africa/
 * Author Email: info@lmkdigital.africa
 * Text Domain: akhaniconnectjobs
 */

if (! defined('ABSPATH')) {
    exit;
}

if (! class_exists('AkhaniConnectJobsPlugin')) {
    class AkhaniConnectJobsPlugin
    {
        private const APPLY_URL = 'https://admin.akhaniconnect.co.za/';
        private const SHORTCODE = 'akhani-connect-jobs';
        private const PER_PAGE = 10;

        /**
         * Boot the plugin.
         */
        public function __construct()
        {
            add_shortcode(self::SHORTCODE, [$this, 'renderShortcode']);
            add_action('wp_enqueue_scripts', [$this, 'registerAssets']);
        }

        /**
         * Register plugin assets.
         */
        public function registerAssets(): void
        {
            wp_register_style(
                'akhaniconnectjobs-styles',
                plugin_dir_url(__FILE__) . 'assets/css/akhaniconnectjobs.css',
                [],
                '1.0.0'
            );

            wp_register_script(
                'akhaniconnectjobs-script',
                plugin_dir_url(__FILE__) . 'assets/js/akhaniconnectjobs.js',
                [],
                '1.0.0',
                true
            );
        }

        /**
         * Render the jobs shortcode output.
         *
         * @param array<string, mixed> $atts
         */
        public function renderShortcode(array $atts = []): string
        {
            wp_enqueue_style('akhaniconnectjobs-styles');
            wp_enqueue_script('akhaniconnectjobs-script');

            $keyword = isset($_GET['akhani_jobs_keyword']) ? sanitize_text_field(wp_unslash($_GET['akhani_jobs_keyword'])) : '';
            $province = isset($_GET['akhani_jobs_province']) ? sanitize_text_field(wp_unslash($_GET['akhani_jobs_province'])) : '';
            $type = isset($_GET['akhani_jobs_type']) ? sanitize_text_field(wp_unslash($_GET['akhani_jobs_type'])) : '';
            $page = isset($_GET['akhani_jobs_page']) ? max(1, (int) $_GET['akhani_jobs_page']) : 1;

            $jobsData = $this->fetchJobs($keyword, $province, $type, $page);
            $jobs = $jobsData['jobs'];
            $provinces = $this->fetchDistinctValues('province');
            $types = $this->fetchDistinctValues('employment_type');

            ob_start();
            ?>
            <div class="akhani-connect-jobs">
                <form class="akhani-connect-jobs__search" method="get">
                    <div class="akhani-connect-jobs__field">
                        <label for="akhani_jobs_keyword"><?php echo esc_html__('Keyword', 'akhaniconnectjobs'); ?></label>
                        <input
                            type="text"
                            id="akhani_jobs_keyword"
                            name="akhani_jobs_keyword"
                            value="<?php echo esc_attr($keyword); ?>"
                            placeholder="<?php echo esc_attr__('Search by title, location, or description', 'akhaniconnectjobs'); ?>"
                        >
                    </div>

                    <div class="akhani-connect-jobs__field">
                        <label for="akhani_jobs_province"><?php echo esc_html__('Province', 'akhaniconnectjobs'); ?></label>
                        <select id="akhani_jobs_province" name="akhani_jobs_province">
                            <option value=""><?php echo esc_html__('All Provinces', 'akhaniconnectjobs'); ?></option>
                            <?php foreach ($provinces as $provinceOption) : ?>
                                <option value="<?php echo esc_attr($provinceOption); ?>" <?php selected($province, $provinceOption); ?>>
                                    <?php echo esc_html($provinceOption); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="akhani-connect-jobs__field">
                        <label for="akhani_jobs_type"><?php echo esc_html__('Type', 'akhaniconnectjobs'); ?></label>
                        <select id="akhani_jobs_type" name="akhani_jobs_type">
                            <option value=""><?php echo esc_html__('All Types', 'akhaniconnectjobs'); ?></option>
                            <?php foreach ($types as $typeOption) : ?>
                                <option value="<?php echo esc_attr($typeOption); ?>" <?php selected($type, $typeOption); ?>>
                                    <?php echo esc_html($typeOption); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="akhani-connect-jobs__actions">
                        <button type="submit" class="akhani-connect-jobs__button akhani-connect-jobs__button--primary">
                            <?php echo esc_html__('Search Jobs', 'akhaniconnectjobs'); ?>
                        </button>
                        <a class="akhani-connect-jobs__button akhani-connect-jobs__button--secondary" href="<?php echo esc_url($this->currentShortcodePageUrl()); ?>">
                            <?php echo esc_html__('Reset', 'akhaniconnectjobs'); ?>
                        </a>
                    </div>
                </form>

                <div class="akhani-connect-jobs__results">
                    <?php if (empty($jobs)) : ?>
                        <div class="akhani-connect-jobs__empty">
                            <?php echo esc_html__('There are currently no jobs listed.', 'akhaniconnectjobs'); ?>
                        </div>
                    <?php else : ?>
                        <?php foreach ($jobs as $job) : ?>
                            <?php
                            $accordionId = 'akhani-job-' . (int) $job['id'];
                            $locationParts = array_filter([
                                $job['location'],
                                $job['province'],
                            ]);
                            ?>
                            <div class="akhani-connect-jobs__item">
                                <button
                                    class="akhani-connect-jobs__toggle"
                                    type="button"
                                    aria-expanded="false"
                                    aria-controls="<?php echo esc_attr($accordionId); ?>"
                                >
                                    <span class="akhani-connect-jobs__toggle-main">
                                        <span class="akhani-connect-jobs__title"><?php echo esc_html($job['title']); ?></span>
                                        <?php if (! empty($locationParts)) : ?>
                                            <span class="akhani-connect-jobs__meta"><?php echo esc_html(implode(' | ', $locationParts)); ?></span>
                                        <?php endif; ?>
                                    </span>
                                    <span class="akhani-connect-jobs__toggle-side">
                                        <?php if (! empty($job['employment_type'])) : ?>
                                            <span class="akhani-connect-jobs__badge"><?php echo esc_html($job['employment_type']); ?></span>
                                        <?php endif; ?>
                                        <span class="akhani-connect-jobs__icon" aria-hidden="true">+</span>
                                    </span>
                                </button>

                                <div class="akhani-connect-jobs__panel" id="<?php echo esc_attr($accordionId); ?>" hidden>
                                    <div class="akhani-connect-jobs__detail-grid">
                                        <div class="akhani-connect-jobs__detail">
                                            <span class="akhani-connect-jobs__detail-label"><?php echo esc_html__('Province', 'akhaniconnectjobs'); ?></span>
                                            <span class="akhani-connect-jobs__detail-value"><?php echo esc_html($job['province'] ?: 'N/A'); ?></span>
                                        </div>
                                        <div class="akhani-connect-jobs__detail">
                                            <span class="akhani-connect-jobs__detail-label"><?php echo esc_html__('Location', 'akhaniconnectjobs'); ?></span>
                                            <span class="akhani-connect-jobs__detail-value"><?php echo esc_html($job['location'] ?: 'N/A'); ?></span>
                                        </div>
                                        <div class="akhani-connect-jobs__detail">
                                            <span class="akhani-connect-jobs__detail-label"><?php echo esc_html__('Type', 'akhaniconnectjobs'); ?></span>
                                            <span class="akhani-connect-jobs__detail-value"><?php echo esc_html($job['employment_type'] ?: 'N/A'); ?></span>
                                        </div>
                                        <div class="akhani-connect-jobs__detail">
                                            <span class="akhani-connect-jobs__detail-label"><?php echo esc_html__('Published', 'akhaniconnectjobs'); ?></span>
                                            <span class="akhani-connect-jobs__detail-value"><?php echo esc_html($job['published_label']); ?></span>
                                        </div>
                                    </div>

                                    <div class="akhani-connect-jobs__description">
                                        <?php echo wp_kses_post($job['description']); ?>
                                    </div>

                                    <div class="akhani-connect-jobs__apply">
                                        <a
                                            class="akhani-connect-jobs__button akhani-connect-jobs__button--primary"
                                            href="<?php echo esc_url(self::APPLY_URL); ?>"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            <?php echo esc_html__('Apply', 'akhaniconnectjobs'); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php if (($jobsData['total_pages'] ?? 1) > 1) : ?>
                            <div class="akhani-connect-jobs__pagination">
                                <?php if ((int) $jobsData['current_page'] > 1) : ?>
                                    <a
                                        class="akhani-connect-jobs__page-link akhani-connect-jobs__page-link--nav"
                                        href="<?php echo esc_url($this->paginationUrl((int) $jobsData['current_page'] - 1, $keyword, $province, $type)); ?>"
                                    >
                                        <?php echo esc_html__('Previous', 'akhaniconnectjobs'); ?>
                                    </a>
                                <?php endif; ?>

                                <?php for ($pageNumber = 1; $pageNumber <= (int) $jobsData['total_pages']; $pageNumber++) : ?>
                                    <a
                                        class="akhani-connect-jobs__page-link <?php echo $pageNumber === (int) $jobsData['current_page'] ? 'is-active' : ''; ?>"
                                        href="<?php echo esc_url($this->paginationUrl($pageNumber, $keyword, $province, $type)); ?>"
                                    >
                                        <?php echo esc_html((string) $pageNumber); ?>
                                    </a>
                                <?php endfor; ?>

                                <?php if ((int) $jobsData['current_page'] < (int) $jobsData['total_pages']) : ?>
                                    <a
                                        class="akhani-connect-jobs__page-link akhani-connect-jobs__page-link--nav"
                                        href="<?php echo esc_url($this->paginationUrl((int) $jobsData['current_page'] + 1, $keyword, $province, $type)); ?>"
                                    >
                                        <?php echo esc_html__('Next', 'akhaniconnectjobs'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php

            return (string) ob_get_clean();
        }

        /**
         * Fetch published jobs from the Akhani Connect database.
         *
         * @return array<string, mixed>
         */
        private function fetchJobs(string $keyword, string $province, string $type, int $page): array
        {
            $connection = $this->createJobsConnection();

            if ($connection === null) {
                return [
                    'jobs' => [],
                    'current_page' => 1,
                    'total_pages' => 1,
                    'total_jobs' => 0,
                ];
            }

            $whereSql = " FROM jobs WHERE status = 'published' AND published_at IS NOT NULL";

            $types = '';
            $values = [];

            if ($keyword !== '') {
                $searchValue = '%' . $keyword . '%';
                $whereSql .= " AND (title LIKE ? OR location LIKE ? OR province LIKE ? OR description LIKE ?)";
                $types .= 'ssss';
                $values[] = $searchValue;
                $values[] = $searchValue;
                $values[] = $searchValue;
                $values[] = $searchValue;
            }

            if ($province !== '') {
                $whereSql .= " AND province = ?";
                $types .= 's';
                $values[] = $province;
            }

            if ($type !== '') {
                $whereSql .= " AND employment_type = ?";
                $types .= 's';
                $values[] = $type;
            }

            $countSql = "SELECT COUNT(*) AS aggregate" . $whereSql;
            $countStatement = mysqli_prepare($connection, $countSql);

            if (! $countStatement) {
                mysqli_close($connection);

                return [
                    'jobs' => [],
                    'current_page' => 1,
                    'total_pages' => 1,
                    'total_jobs' => 0,
                ];
            }

            if ($values !== []) {
                mysqli_stmt_bind_param($countStatement, $types, ...$values);
            }

            mysqli_stmt_execute($countStatement);
            $countResult = mysqli_stmt_get_result($countStatement);
            $countRow = $countResult ? mysqli_fetch_assoc($countResult) : null;
            $totalJobs = isset($countRow['aggregate']) ? (int) $countRow['aggregate'] : 0;
            $totalPages = max(1, (int) ceil($totalJobs / self::PER_PAGE));
            $currentPage = min($page, $totalPages);
            $offset = ($currentPage - 1) * self::PER_PAGE;

            if ($countResult) {
                mysqli_free_result($countResult);
            }
            mysqli_stmt_close($countStatement);

            $sql = "
                SELECT
                    id,
                    title,
                    location,
                    province,
                    employment_type,
                    description,
                    published_at
            " . $whereSql . " ORDER BY published_at DESC, id DESC LIMIT ? OFFSET ?";

            $statement = mysqli_prepare($connection, $sql);

            if (! $statement) {
                mysqli_close($connection);

                return [
                    'jobs' => [],
                    'current_page' => 1,
                    'total_pages' => 1,
                    'total_jobs' => 0,
                ];
            }

            $queryTypes = $types . 'ii';
            $queryValues = $values;
            $queryValues[] = self::PER_PAGE;
            $queryValues[] = $offset;
            mysqli_stmt_bind_param($statement, $queryTypes, ...$queryValues);

            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);

            if (! $result) {
                mysqli_stmt_close($statement);
                mysqli_close($connection);

                return [
                    'jobs' => [],
                    'current_page' => 1,
                    'total_pages' => 1,
                    'total_jobs' => 0,
                ];
            }

            $jobs = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $jobs[] = [
                    'id' => (string) $row['id'],
                    'title' => (string) $row['title'],
                    'location' => (string) ($row['location'] ?? ''),
                    'province' => (string) ($row['province'] ?? ''),
                    'employment_type' => (string) ($row['employment_type'] ?? ''),
                    'description' => (string) ($row['description'] ?? ''),
                    'published_label' => $this->formatPublishedDate($row['published_at'] ?? null),
                ];
            }

            mysqli_free_result($result);
            mysqli_stmt_close($statement);
            mysqli_close($connection);

            return [
                'jobs' => $jobs,
                'current_page' => $currentPage,
                'total_pages' => $totalPages,
                'total_jobs' => $totalJobs,
            ];
        }

        /**
         * Fetch distinct filter values from the jobs table.
         *
         * @return array<int, string>
         */
        private function fetchDistinctValues(string $column): array
        {
            if (! in_array($column, ['province', 'employment_type'], true)) {
                return [];
            }

            $connection = $this->createJobsConnection();

            if ($connection === null) {
                return [];
            }

            $sql = sprintf(
                "SELECT DISTINCT %s FROM jobs WHERE status = 'published' AND %s IS NOT NULL AND %s <> '' ORDER BY %s ASC",
                $column,
                $column,
                $column,
                $column
            );

            $result = mysqli_query($connection, $sql);

            if (! $result) {
                mysqli_close($connection);

                return [];
            }

            $values = [];

            while ($row = mysqli_fetch_row($result)) {
                if (isset($row[0]) && $row[0] !== '') {
                    $values[] = (string) $row[0];
                }
            }

            mysqli_free_result($result);
            mysqli_close($connection);

            return $values;
        }

        /**
         * Create a mysqli connection to the Laravel jobs database.
         */
        private function createJobsConnection()
        {
            $config = $this->databaseConfig();

            if ($config['name'] === '' || $config['user'] === '') {
                return null;
            }

            $connection = @mysqli_connect(
                $config['host'],
                $config['user'],
                $config['password'],
                $config['name'],
                (int) $config['port']
            );

            if (! $connection) {
                return null;
            }

            mysqli_set_charset($connection, 'utf8mb4');

            return $connection;
        }

        /**
         * Database placeholders for the Laravel jobs database.
         *
         * Fill these credentials in after moving the plugin into WordPress.
         *
         * @return array<string, string>
         */
        private function databaseConfig(): array
        {
            return [
                'host' => 'sql58.jnb1.host-h.net',
                'port' => '3306',
                'name' => 'akhanumenc_db2',
                'user' => 'akhanumenc_2',
                'password' => '1uANoQc4h40fnD9Wpb6Q',
            ];
        }

        /**
         * Format the published date label.
         */
        private function formatPublishedDate(?string $publishedAt): string
        {
            if ($publishedAt === null || $publishedAt === '') {
                return 'Not specified';
            }

            $timestamp = strtotime($publishedAt);

            if ($timestamp === false) {
                return 'Not specified';
            }

            return date_i18n('d M Y', $timestamp);
        }

        /**
         * Build a reset URL for the current page.
         */
        private function currentShortcodePageUrl(): string
        {
            global $wp;

            if (isset($wp->request)) {
                return home_url(add_query_arg([], $wp->request));
            }

            return home_url('/');
        }

        /**
         * Build a pagination URL while preserving active filters.
         */
        private function paginationUrl(int $page, string $keyword, string $province, string $type): string
        {
            $queryArgs = array_filter([
                'akhani_jobs_keyword' => $keyword,
                'akhani_jobs_province' => $province,
                'akhani_jobs_type' => $type,
                'akhani_jobs_page' => $page > 1 ? $page : null,
            ], static function ($value) {
                return $value !== null && $value !== '';
            });

            return add_query_arg($queryArgs, $this->currentShortcodePageUrl());
        }
    }

    new AkhaniConnectJobsPlugin();
}
